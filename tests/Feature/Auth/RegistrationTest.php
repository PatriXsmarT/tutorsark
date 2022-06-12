<?php

namespace Tests\Feature\Auth;

use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_registration_screen_can_be_rendered()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_new_users_can_register()
    {
        $response = $this->post('/register', [
            'name' => 'Test User',
            'email' => $this->faker->safeEmail(),
            'password' => $this->correctPassword(),
            'password_confirmation' => $this->correctPassword(),
        ]);

        $this->assertAuthenticated();

        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_new_users_can_register_through_api()
    {
        $response = $this->postJson('api/register', [
            'name' => 'Test User',
            'email' => $email = $this->faker->safeEmail(),
            'password' => $this->correctPassword(),
            'password_confirmation' => $this->correctPassword(),
        ]);

        $this->assertDatabaseHas('users', [
            'email' => $email,
        ]);

        $response->assertCreated();
    }
}
