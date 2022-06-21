<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class AuthenticationTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_login_screen_can_be_rendered()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_authenticate_using_the_login_screen()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => $this->correctPassword(),
        ]);

        $this->assertAuthenticated();

        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_apps_can_get_access_token_using_users_email_and_password()
    {
        $user = User::factory()->create();

        $response = $this->postJson('api/login', [
            'email' => $user->email,
            'password' => $this->correctPassword(),
        ])
        ->assertJsonStructure(['token_type','expires_in','access_token','refresh_token'])
        ->assertJsonCount(4)
        ->assertSuccessful();

        $this->getJson('api/user', [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$response['access_token'],
        ])
        ->assertSuccessful();
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_not_authenticate_nor_get_access_token_with_invalid_password()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => $this->wrongPassword(),
        ])
        ->assertInvalid();

        $this->postJson('api/login', [
            'email' => $user->email,
            'password' => $this->wrongPassword(),
        ])
        ->assertStatus(500);

        $this->assertGuest();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_logout_using_web_sessions()
    {
        $user = User::factory()->create();

        $this->post('/login', [
            'email' => $user->email,
            'password' => $this->correctPassword(),
        ])
        ->assertRedirect(RouteServiceProvider::HOME);

        $this->assertAuthenticated();

        $this->post('/logout', [])->assertRedirect();

        $this->get('/user')->assertRedirect();

        $this->assertGuest();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_logout_by_revoking_access_token()
    {
        $this->noHandling();

        $user = User::factory()->create();

        $response = $this->postJson('api/login', [
            'email' => $user->email,
            'password' => $this->correctPassword(),
        ])
        ->assertJsonStructure(['token_type','expires_in','access_token','refresh_token'])
        ->assertJsonCount(4)
        ->assertSuccessful();

        $this->postJson('api/logout',[],[
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$response['access_token'],
        ])->assertSuccessful();
    }
}
