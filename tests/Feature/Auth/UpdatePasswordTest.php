<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UpdatePasswordTest extends TestCase
{
    Use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_update_their_password()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('update-password',[
            'current_password' => $this->correctPassword(),
            'password' => $this->correctPassword(),
        ]);

        $response
            ->assertValid()
            ->assertSessionDoesntHaveErrors()
            ->assertSuccessful();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_update_their_password_through_api()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user,'api')->postJson('api/update-password',[
            'current_password' => $this->correctPassword(),
            'password' => $this->correctPassword(),
        ]);

        $response
            ->assertValid()
            ->assertSuccessful();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_not_update_their_password_with_a_wrong_password_format()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('update-password',[
            'current_password' => $this->correctPassword(),
            'password' => $this->incorrectPasswordFormat(),
        ]);

        $response
            ->assertInvalid()
            ->assertSessionHasErrors(['password'])
            ->assertRedirect();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_not_update_their_password_with_a_wrong_password_format_through_api()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user,'api')->postJson('api/update-password',[
            'current_password' => $this->correctPassword(),
            'password' => $this->incorrectPasswordFormat(),
        ]);

        $response
            ->assertJsonValidationErrors(['password'])
            ->assertUnprocessable();
    }
}
