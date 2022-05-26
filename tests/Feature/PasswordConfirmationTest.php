<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PasswordConfirmationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_confirm_password_screen_can_be_rendered()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/confirm-password');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_password_can_be_confirmed()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/confirm-password', [
            'password' => $this->correctPassword(),
        ]);

        $response->assertRedirect();

        $response->assertSessionHasNoErrors();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_password_can_be_confirmed_through_api()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user,'api')->postJson('api/confirm-password', [
            'password' => $this->correctPassword(),
        ]);

        $response->assertNoContent();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_password_is_not_confirmed_with_invalid_password()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/confirm-password', [
            'password' => $this->wrongPassword(),
        ]);

        $response->assertSessionHasErrors();
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_password_is_not_confirmed_with_invalid_password_through_api()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user,'api')->postJson('api/confirm-password', [
            'password' => $this->wrongPassword(),
        ]);

        $response->assertJsonValidationErrors(['password']);
    }
}
