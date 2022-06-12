<?php

namespace Tests\Feature\Auth\Passport;

use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\ClientRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GrantAccessTokenTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_oauth_authourization_code_grant_client_can_be_issued_access_tokens()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $clientRepository = New ClientRepository;

        $oauth_client = $clientRepository->create(
            $user->id,
            "New Client",
            $this->faker()->url()
        );

        $response = $this->get('oauth/redirect',[
            'client_id' => $oauth_client->id,
            'client_uri' => $oauth_client->redirect
        ]);

        $response->assertRedirect();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_oauth_client_credentials_grant_can_be_issued_access_tokens()
    {
        $clientRepository = New ClientRepository;

        $oauth_client = $clientRepository->create(
            null,
            $clientName = "New OAuth Client",
            ''
        );

        $response = $this->postJson('oauth/token',[
            'grant_type' => 'client_credentials',
            'client_id' => $oauth_client->id,
            'client_secret' => $oauth_client->secret,
            'scope' => '*'
        ]);

        $response->assertJsonStructure(['token_type','expires_in','access_token'])
        ->assertJsonCount(3)
        ->assertSuccessful();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_oauth_password_grant_client_can_be_issued_access_tokens()
    {
        $clientRepository = New ClientRepository;

        $provider = 'users';

        $oauth_client = $clientRepository->createPasswordGrantClient(
            null,
            config('app.name').' Password Grant Client',
            'http://localhost',
            $provider
        );

        $user = User::factory()->create();

        $response = $this->postJson('oauth/token', [
            'grant_type' => 'password',
            'username' => $user->email,
            'password' => $this->correctPassword(),
            'client_id' => $oauth_client->id,
            'client_secret' => $oauth_client->secret,
            'scope' => '*'
        ])
        ->assertJsonStructure(['token_type','expires_in','access_token','refresh_token'])
        ->assertJsonCount(4)
        ->assertSuccessful();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_oauth_personal_access_grant_client_can_be_issued_access_tokens()
    {
        $clientRepository = New ClientRepository;

        $clientRepository->createPersonalAccessClient(
            null,
            config('app.name').' Personal Grant Client',
            'http://localhost'
        );

        $user = User::factory()->create();

        $this->actingAs($user);

        $data = [
            'name' => 'Personal Access Token',
            'scope' => '*'
        ];

        $this->post('/oauth/personal-access-tokens', $data)
        ->assertSee('accessToken')
        ->assertSuccessful();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_oauth_client_can_be_issued_access_token_using_a_user_refresh_token()
    {
        $clientRepository = New ClientRepository;

        $provider = 'users';

        $oauth_client = $clientRepository->createPasswordGrantClient(
            null,
            config('app.name').' Password Grant Client',
            'http://localhost',
            $provider
        );

        $user = User::factory()->create();

        $response = $this->postJson('oauth/token', [
            'grant_type' => 'password',
            'username' => $user->email,
            'password' => $this->correctPassword(),
            'client_id' => $oauth_client->id,
            'client_secret' => $oauth_client->secret,
            'scope' => '*'
        ])
        ->assertJsonStructure(['token_type','expires_in','access_token','refresh_token'])
        ->assertJsonCount(4)
        ->assertSuccessful();

        $this->post('oauth/token',[
            'grant_type' => 'refresh_token',
            'client_id' => $oauth_client->id,
            'client_secret' => $oauth_client->secret,
            'refresh_token' => $response['refresh_token'],
            'scope' => '*'
        ])
        ->assertJsonStructure(['token_type','expires_in','access_token','refresh_token'])
        ->assertJsonCount(4)
        ->assertSuccessful();
    }
}
