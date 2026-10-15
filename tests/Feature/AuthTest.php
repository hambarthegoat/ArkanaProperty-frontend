<?php

namespace Tests\Feature;

use App\Services\ArkanaApi;
use Illuminate\Http\Client\Request;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AuthTest extends TestCase
{
    public function test_login_page_renders_form(): void
    {
        $this->get('/login')->assertOk()->assertSee('name="username"', false)->assertSee('Admin Panel');
    }

    public function test_login_stores_token_and_redirects_by_role(): void
    {
        Http::fake([
            'api.test/api/auth/login' => self::api([
                'akun' => ['id' => 2, 'username' => 'dimas', 'role' => 'marketing', 'nama' => 'Dimas'],
                'token' => '2|secret',
                'token_type' => 'Bearer',
            ]),
        ]);

        $this->post('/login', ['username' => 'dimas', 'password' => 'password'])
            ->assertRedirect(route('marketing.dashboard'))
            ->assertSessionHas(ArkanaApi::SESSION_TOKEN, '2|secret')
            ->assertSessionHas(ArkanaApi::SESSION_AKUN.'.role', 'marketing');

        Http::assertSent(fn (Request $r) => $r->url() === 'http://api.test/api/auth/login' && $r['username'] === 'dimas');
    }

    public function test_leads_account_goes_to_portal(): void
    {
        Http::fake(['api.test/api/auth/login' => self::api([
            'akun' => ['id' => 9, 'username' => '081234567890', 'role' => 'leads', 'nama' => 'Ahmad'],
            'token' => '9|secret',
        ])]);

        $this->post('/login', ['username' => '081234567890', 'password' => 'x'])->assertRedirect(route('portal.dashboard'));
    }

    public function test_wrong_credentials_show_error(): void
    {
        Http::fake(['api.test/api/auth/login' => self::api(null, 401, 'Invalid username or password')]);

        $this->from('/login')
            ->post('/login', ['username' => 'dimas', 'password' => 'salah'])
            ->assertRedirect('/login')
            ->assertSessionHasErrors('username')
            ->assertSessionMissing(ArkanaApi::SESSION_TOKEN);
    }

    public function test_guest_is_sent_to_login_and_wrong_role_to_own_home(): void
    {
        $this->get('/marketing')->assertRedirect(route('login'));

        $this->loginAs('leads')->get('/admin')->assertRedirect(route('portal.dashboard'));
    }

    public function test_logout_revokes_token_and_clears_session(): void
    {
        Http::fake(['api.test/api/auth/logout' => self::api(null)]);

        $this->loginAs('marketing')
            ->post('/logout')
            ->assertRedirect(route('login'))
            ->assertSessionMissing(ArkanaApi::SESSION_TOKEN);

        Http::assertSent(fn (Request $r) => $r->hasHeader('Authorization', 'Bearer test-token'));
    }
}
