<?php

namespace Tests\Feature\Auth\Passport;

use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\ClientRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RevokeAccessTokenTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_access_tokens_issued_to_oauth_password_grant_client_can_be_revoked()
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

        $this->postJson('api/oauth/revoke-token',[],[
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$response['access_token'],
        ])->assertSuccessful();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_access_tokens_issued_to_oauth_client_credentials_grant_can_be_revoked()
    {
        $clientRepository = New ClientRepository;

        $oauth_client = $clientRepository->create(
            null,
            'New OAuth Client',
            ''
        );

        $response = $this->postJson('oauth/token',[
            'grant_type' => 'client_credentials',
            'client_id' => $oauth_client->id,
            'client_secret' => $oauth_client->secret,
            'scope' => '*'
        ])
        ->assertJsonStructure(['token_type','expires_in','access_token'])
        ->assertJsonCount(3)
        ->assertSuccessful();

        $this->postJson('api/oauth/revoke-token',[],[
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$response['access_token'],
        ])->assertSuccessful();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_access_tokens_issued_to_oauth_personal_access_grant_can_be_revoked()
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

        $response = $this->post('/oauth/personal-access-tokens', $data)
        ->assertSee('accessToken')
        ->assertSuccessful();

        $this->postJson('api/oauth/revoke-token',[],[
            'Accept' => 'application/json',
            'Authorization' => 'Bearer '.$response['accessToken'],
        ])->assertSuccessful();
    }
}
