<?php

namespace Tests\Feature\Auth\Socialite;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginWithSocialAccountTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_login_through_a_socialite_provider()
    {
        $provider = 'github';

        $response = $this->getJson('login/'.$provider)
        ->assertSuccessful();

        $this->followRedirects(
            $this->get('login/'.$provider)
            ->assertRedirect()
        );
    }

}
