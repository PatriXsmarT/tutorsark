<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class PasswordResetTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_reset_password_link_screen_can_be_rendered()
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_reset_password_link_can_be_requested()
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_reset_password_link_can_be_requested_through_api()
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->postJson('api/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_reset_password_screen_can_be_rendered()
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) {

            $response = $this->get('/reset-password/'.$notification->token);

            $response->assertStatus(200);

            return true;
        });
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_password_can_be_reset_with_a_valid_token()
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->post('/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {

            $response = $this->post('/reset-password', [
                'token' => $notification->token,
                'email' => $user->email,
                'password' => $this->correctPassword(),
                'password_confirmation' => $this->correctPassword(),
            ]);

            $response->assertSessionHasNoErrors();

            return true;
        });
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_password_can_be_reset_with_a_valid_token_through_api()
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->postJson('api/forgot-password', ['email' => $user->email]);

        Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {

            $response = $this->post('api/reset-password', [
                'token' => $notification->token,
                'email' => $user->email,
                'password' => $this->correctPassword(),
                'password_confirmation' => $this->correctPassword(),
            ]);

            $response->assertValid();

            return true;
        });
    }
}
