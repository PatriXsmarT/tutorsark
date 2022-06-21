<?php

namespace Tests\Feature\Auth\Passport;

use Tests\TestCase;
use App\Models\User;
use Laravel\Passport\ClientRepository;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserPersonalAccessTokenCrudTest extends TestCase
{
    use RefreshDatabase, WithFaker;

     /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_see_oauth_personal_access_tokens_created_using_the_web()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->get('/oauth/personal-access-tokens')->assertSuccessful();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_create_oauth_personal_access_tokens_using_the_web()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $data = [
            'name' => config('app.name').'Personal Access Token',
            'scope' => '*'
        ];

        $this->postJson('/oauth/personal-access-tokens', $data)
        ->assertJsonStructure(['accessToken','token'])
        ->assertSuccessful();

        $this->assertDatabaseHas('oauth_access_tokens', ['name' => config('app.name').'Personal Access Token',]);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_update_oauth_personal_access_tokens_using_the_web()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $createData = [
            'name' => config('app.name').'Personal Access Token',
            'scope' => '*'
        ];

        $createResponse = $this->postJson('/oauth/personal-access-tokens', $createData)
        ->assertJsonStructure(['accessToken','token'])
        ->assertSuccessful();

        $this->assertDatabaseHas('oauth_access_tokens', ['name' => config('app.name').'Personal Access Token',]);

        $updateData = [
            'name' => 'New '.config('app.name').'Personal Access Token',
            'scope' => '*'
        ];

        $updateResponse = $this->post('/oauth/personal-access-tokens/'.$createResponse->json('id'), $updateData)
        ->assertJsonStructure(['accessToken','token'])
        ->assertSuccessful();

        $this->assertDatabaseHas('oauth_access_tokens', ['name' => 'New '.config('app.name').'Personal Access Token',]);

        $this->assertSame($createResponse->json('id'), $updateResponse->json('id'));
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_delete_oauth_personal_access_tokens_using_the_web()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $createData = [
            'name' => config('app.name').'Personal Access Token',
            'scope' => '*'
        ];

        $createResponse = $this->postJson('/oauth/personal-access-tokens', $createData)
        ->assertJsonStructure(['accessToken','token'])
        ->assertSuccessful();

        $this->assertDatabaseHas('oauth_access_tokens', ['name' => config('app.name').'Personal Access Token',]);

        $this->deleteJson('oauth/personal-access-tokens/'.$createResponse['token']['id'])
        ->assertSuccessful();

        $this->assertDatabaseHas('oauth_access_tokens', [
            'name' => config('app.name').'Personal Access Token',
            'revoked' => true
        ]);
    }
}
