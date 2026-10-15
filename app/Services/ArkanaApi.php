<?php

namespace App\Services;

use App\Exceptions\ApiException;
use App\Exceptions\ApiUnauthenticatedException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

/**
 * Thin client for the ArkanaProperty backend API. Calls are made
 * server-side with the Sanctum token kept in the session, so the token
 * never reaches the browser. Every method returns the envelope's "data".
 *
 * Errors: 422 becomes a ValidationException (forms redirect back with
 * errors), 401 an ApiUnauthenticatedException (user is sent to login),
 * anything else an ApiException carrying the API message.
 */
class ArkanaApi
{
    public const SESSION_TOKEN = 'api.token';

    public const SESSION_AKUN = 'api.akun';

    public function get(string $uri, array $query = []): mixed
    {
        return $this->send(fn (PendingRequest $http) => $http->get($uri, array_filter($query, fn ($v) => $v !== null && $v !== '')));
    }

    public function post(string $uri, array $data = []): mixed
    {
        return $this->send(fn (PendingRequest $http) => $http->post($uri, $data));
    }

    public function put(string $uri, array $data = []): mixed
    {
        return $this->send(fn (PendingRequest $http) => $http->put($uri, $data));
    }

    public function patch(string $uri, array $data = []): mixed
    {
        return $this->send(fn (PendingRequest $http) => $http->patch($uri, $data));
    }

    /**
     * Multipart POST; UploadedFile values are sent as file parts and null
     * values are skipped.
     */
    public function postMultipart(string $uri, array $data): mixed
    {
        return $this->send(function (PendingRequest $http) use ($uri, $data) {
            $http->asMultipart();

            foreach ($data as $name => $value) {
                if ($value instanceof UploadedFile) {
                    $http->attach($name, $value->get(), $value->getClientOriginalName());
                    unset($data[$name]);
                } elseif ($value === null) {
                    unset($data[$name]);
                }
            }

            return $http->post($uri, $data);
        });
    }

    /**
     * Raw response for binary downloads (e.g. KTP files).
     */
    public function download(string $uri): Response
    {
        $response = $this->request()->get($uri);

        if ($response->status() === 401) {
            throw new ApiUnauthenticatedException('Sesi Anda telah berakhir. Silakan masuk kembali.', 401);
        }

        if ($response->failed()) {
            throw new ApiException($response->json('message') ?? 'File tidak ditemukan.', $response->status());
        }

        return $response;
    }

    public function token(): ?string
    {
        return session(self::SESSION_TOKEN);
    }

    public function akun(): ?array
    {
        return session(self::SESSION_AKUN);
    }

    public function storeSession(string $token, array $akun): void
    {
        session()->put(self::SESSION_TOKEN, $token);
        session()->put(self::SESSION_AKUN, $akun);
    }

    public function forgetSession(): void
    {
        session()->forget([self::SESSION_TOKEN, self::SESSION_AKUN]);
    }

    private function request(): PendingRequest
    {
        $http = Http::baseUrl(rtrim(config('services.arkana_api.url'), '/'))
            ->acceptJson()
            ->timeout((int) config('services.arkana_api.timeout', 10));

        return $this->token() ? $http->withToken($this->token()) : $http;
    }

    private function send(callable $call): mixed
    {
        try {
            /** @var Response $response */
            $response = $call($this->request());
        } catch (ConnectionException) {
            throw new ApiException('Server API tidak dapat dihubungi. Coba beberapa saat lagi.', 503);
        }

        if ($response->successful()) {
            return $response->json('data');
        }

        $message = $response->json('message') ?? 'Terjadi kesalahan pada server API.';

        throw match ($response->status()) {
            401 => new ApiUnauthenticatedException($message, 401),
            422 => is_array($response->json('data'))
                ? ValidationException::withMessages($response->json('data'))
                : ValidationException::withMessages(['api' => $message]),
            default => new ApiException($message, $response->status(), $response->json('data')),
        };
    }
}
