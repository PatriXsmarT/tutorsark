<?php

namespace Tests\Feature\Auth\Passport;

use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\Client;
use Laravel\Passport\ClientRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class RefreshAccessTokenTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_oauth_authourization_code_grant_client_can_be_issued_access_tokens_using_users_refresh_token()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $clientRepository = New ClientRepository;

        $oauth_client = $clientRepository->create(
            $user->id,
            "New Client",
            'http://127:0.0.1:8000/oauth/callback',
            null,
        );

        $this->followRedirects = true;

        $redirectResponse = $this->postJson('oauth/redirect',[
            'client_id' => $oauth_client->id,
            'client_redirect_uri' => $oauth_client->redirect
        ])
        ->assertSessionHasAll(['_token','state'])
        ->assertViewIs('passport::authorize')
        ->assertViewHasAll(['authToken','request','client'])
        ->assertSuccessful();
        $token_response = $this->withHeaders([
            'client_id' => $oauth_client->id,
            'client_redirect_uri' => $oauth_client->redirect,
            'client_secret' => $oauth_client->secret
        ])
        ->followRedirects(
            $this->postJson('oauth/authorize',[
                'state' => $redirectResponse['request']['state'],
                'client_id' => $redirectResponse['client']['id'],
                'auth_token' => $redirectResponse['authToken'],
            ])
        )
        ->assertJsonStructure(['token_type','expires_in','access_token','refresh_token'])
        ->assertJsonCount(4)
        ->assertSuccessful();

        $this->getAccessTokenFromRefreshToken($oauth_client, $token_response);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_oauth_authourization_code_grant_client_with_pkce_can_be_issued_access_tokens_using_users_refresh_token()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $clientRepository = New ClientRepository;

        $oauth_client = $clientRepository->create(
            $user->id,
            "New Client",
            'http://127:0.0.1:8000/oauth/callback',
            null,
            false,
            false,
            false
        );

        $this->followRedirects = true;

        $redirectResponse = $this->postJson('oauth/redirect',[
            'client_id' => $oauth_client->id,
            'client_redirect_uri' => $oauth_client->redirect
        ])
        ->assertSessionHasAll(['_token','state','code_verifier'])
        ->assertViewIs('passport::authorize')
        ->assertViewHasAll(['authToken','request','client'])
        ->assertSuccessful();

        $token_response = $this->withHeaders([
            'client_id' => $oauth_client->id,
            'client_redirect_uri' => $oauth_client->redirect
        ])
        ->followRedirects(
            $this->postJson('oauth/authorize',[
                'state' => $redirectResponse['request']['state'],
                'client_id' => $redirectResponse['client']['id'],
                'auth_token' => $redirectResponse['authToken'],
            ])
        )
        ->assertJsonStructure(['token_type','expires_in','access_token','refresh_token'])
        ->assertJsonCount(4)
        ->assertSuccessful();

        $this->getAccessTokenFromRefreshToken($oauth_client, $token_response);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_oauth_password_grant_client_can_be_issued_access_token_using_users_refresh_token()
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

        $token_response = $this->postJson('oauth/token', [
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

        $this->getAccessTokenFromRefreshToken($oauth_client, $token_response);
    }

    protected function getAccessTokenFromRefreshToken(Client $oauth_client, $token_response)
    {
        // $response = $this->postJson('oauth/token',[
        //     'grant_type' => 'refresh_token',
        //     'client_id' => $oauth_client->id,
        //     'client_secret' => $oauth_client->secret,
        //     'refresh_token' => $token_response['refresh_token'],
        //     'scope' => '*'
        // ]);

        // $response = $this->postJson('api/oauth/refresh-token',[
        //     'client_id' => $oauth_client->id,
        //     'client_secret' => $oauth_client->secret,
        //     'refresh_token' => $token_response['refresh_token'],
        //     'scope' => '*'
        // ]);

        $response = $this->postJson('oauth/refresh-token',[
            'client_id' => $oauth_client->id,
            'client_secret' => $oauth_client->secret,
            'refresh_token' => $token_response['refresh_token'],
            'scope' => '*'
        ]);

        $response
        ->assertJsonStructure(['token_type','expires_in','access_token','refresh_token'])
        ->assertJsonCount(4)
        ->assertSuccessful();
    }
}
