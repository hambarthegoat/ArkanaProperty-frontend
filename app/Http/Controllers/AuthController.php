<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Exceptions\ApiUnauthenticatedException;
use App\Http\Middleware\EnsureApiRole;
use App\Services\ArkanaApi;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function __construct(private ArkanaApi $api) {}

    public function show()
    {
        if ($this->api->token() && $this->api->akun()) {
            return redirect(EnsureApiRole::homeFor($this->api->akun()['role'] ?? null));
        }

        return view('pages.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        try {
            $data = $this->api->post('auth/login', $credentials);
        } catch (ApiUnauthenticatedException) {
            throw ValidationException::withMessages(['username' => 'Username atau password salah.']);
        }

        $request->session()->regenerate();
        $this->api->storeSession($data['token'], $data['akun']);

        return redirect()->intended(EnsureApiRole::homeFor($data['akun']['role']));
    }

    public function logout(Request $request)
    {
        try {
            $this->api->post('auth/logout');
        } catch (ApiException) {
            // Token already invalid on the API side; clearing locally is enough.
        }

        $this->api->forgetSession();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
