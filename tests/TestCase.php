<?php

namespace Tests;

use App\Services\ArkanaApi;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Support\Facades\Http;

abstract class TestCase extends BaseTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
        config(['services.arkana_api.url' => 'http://api.test/api']);
        Http::preventStrayRequests();
    }

    /**
     * Pretend an account logged in through the API.
     */
    protected function loginAs(string $role, array $akun = []): static
    {
        return $this->withSession([
            ArkanaApi::SESSION_TOKEN => 'test-token',
            ArkanaApi::SESSION_AKUN => array_merge([
                'id' => 1,
                'username' => $role,
                'role' => $role,
                'nama' => ucfirst($role).' Test',
                'no_telp' => null,
                'no_wa' => null,
            ], $akun),
        ]);
    }

    /**
     * Wrap data in the backend's {success, data, message} envelope.
     */
    protected static function api(mixed $data, int $status = 200, string $message = 'OK')
    {
        return Http::response(['success' => $status < 400, 'data' => $data, 'message' => $message], $status);
    }
}
