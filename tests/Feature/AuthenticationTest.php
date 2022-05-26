<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Auth\Passport\Client;
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
    public function test_users_can_get_api_token_using_their_email_and_password_and_access_resources_using_it()
    {
        $this->noHandling();

        if(Client::where('personal_access_client',true)->count() & Client::where('password_client',true)->count())
        {
            $user = User::factory()->create();

            $response_1 = $this->postJson('api/login', [
                'email' => $user->email,
                'password' => $this->correctPassword(),
            ])
            ->assertJsonStructure(['token_type','expires_in','access_token','refresh_token'])
            ->assertJsonCount(4)
            ->assertSuccessful();

            $this->getJson('api/user', [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$response_1['access_token'],
            ])
            ->assertSuccessful();
        }
    }


    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_not_authenticate_nor_get_api_token_with_invalid_password()
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
}
