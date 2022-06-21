<?php

namespace Tests\Feature\Auth\Passport;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserClientCrudTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_see_list_of_oauth_clients_created()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $this->get('/oauth/clients')->assertSuccessful();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_create_new_oauth_clients()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $data = [
            'name' => 'Client Name',
            'redirect' => 'http://example.com/callback'
        ];

        $response = $this->post('/oauth/clients', $data);

        $this->assertDatabaseHas('oauth_clients', $data);

        $response->assertCreated();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_update_their_oauth_client_details()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $createData = [
            'name' => config('app.name').'Client Name',
            'redirect' => 'http://example.com/callback'
        ];

        $createResponse = $this->post('/oauth/clients', $createData);

        $this->assertDatabaseHas('oauth_clients', $createData);

        $updateData = [
            'name' => 'New'.config('app.name').' Client Name',
            'redirect' => 'http://new.example.com/callback'
        ];

        $updateResponse = $this->put('/oauth/clients/'.$createResponse['id'], $updateData)
        ->assertSuccessful();

        $this->assertDatabaseHas('oauth_clients', $updateData);

        $this->assertSame($createResponse['id'], $updateResponse['id']);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_delete_their_oauth_clients_details()
    {
        $user = User::factory()->create();

        $this->actingAs($user);

        $data = [
            'name' => 'Client Name',
            'redirect' => 'http://example.com/callback'
        ];

        $createResponse = $this->post('/oauth/clients', $data);

        $this->assertDatabaseHas('oauth_clients', $data);

        $this->delete('/oauth/clients/'. $createResponse['id'])->assertSuccessful();;

        $this->assertDatabaseHas('oauth_clients', array_merge($data, ['revoked' => true]));
    }
}
