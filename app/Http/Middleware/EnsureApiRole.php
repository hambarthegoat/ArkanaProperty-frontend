<?php

namespace App\Http\Middleware;

use App\Services\ArkanaApi;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Guards panel pages using the account stored at login. Guests go to the
 * login page; a logged-in account with another role goes to its own home.
 */
class EnsureApiRole
{
    public function __construct(private ArkanaApi $api) {}

    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $akun = $this->api->akun();

        if (! $this->api->token() || ! $akun) {
            return redirect()->guest(route('login'));
        }

        if (! in_array($akun['role'] ?? null, $roles, true)) {
            return redirect(self::homeFor($akun['role'] ?? null));
        }

        return $next($request);
    }

    public static function homeFor(?string $role): string
    {
        return match ($role) {
            'admin' => route('admin.dashboard'),
            'marketing' => route('marketing.dashboard'),
            'leads' => route('portal.dashboard'),
            default => route('login'),
        };
    }
}
