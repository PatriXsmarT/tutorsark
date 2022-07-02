<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ProfileCreatedSuccessfully;
use App\Notifications\ProfileUpdatedSuccessfully;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfileTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    // public function setUp(): void
    // {
    //     // first include all the normal setUp operations
    //     parent::setUp();

    //     // now re-register all the roles and permissions (clears cache and reloads relations)
    //     $this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();
    // }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_see_their_profile()
    {
        $profile = Profile::factory()->create();

        $this->actingAs($profile->user,'api');

        $this->getJson('api/users/'.$profile->owner->id.'/profile')
        ->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_view_their_profile()
    {
        $profileData = $this->profileData();

        $profile = Profile::factory()->create($profileData);

        $this->actingAs($profile->user,'api');

        $this->getJson('api/profiles/'.$profile->id)
        ->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_create_a_profile()
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->actingAs($user,'api');

        $profileData = $this->profileData();

        $this->postJson('api/users/'.$user->id.'/profiles', $profileData)
        ->assertJsonFragment($profileData)
        ->assertStatus(201);

        Notification::assertSentTo($user, ProfileCreatedSuccessfully::class);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_update_their_profile()
    {
        Notification::fake();

        $user = User::factory()->create();

        $this->actingAs($user,'api');

        $profile = Profile::factory()->create([
            'user_id' => $user
        ]);

        $profileData = $this->profileData();

        $this->putJson('api/profiles/'.$profile->id, $profileData)
        ->assertJsonFragment($profileData)
        ->assertStatus(200);

        Notification::assertSentTo($user, ProfileUpdatedSuccessfully::class);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_delete_their_profile()
    {
        $profileData = $this->profileData();

        $profile = Profile::factory()->create($profileData);

        $this->actingAs($profile->user,'api');

        $profile->user->assignRole('admin');

        $this->deleteJson('api/profiles/'.$profile->id)
        ->assertStatus(200);
    }


    /**
     *
     */
    protected function profileData()
    {
        return [
            'first_name' => $this->faker->unique()->firstNameMale(),
            'last_name' => $this->faker->unique()->lastName(),
            'middle_name' => $this->faker->unique()->firstNameFemale(),
            'gender' => 'male',
            'occupation' => $this->faker->jobTitle(),
            'dob' => now()->addYears('-18')->toDateString(),
            'bio' => $this->faker->paragraph(),
            'website' => $this->faker->url(),
            'phone_number' => $this->faker->e164PhoneNumber() ,
            'address' => $this->faker->streetAddress(),
            'town' => $this->faker->city(),
            'state' => $this->faker->state(),
            'country' => $this->faker->country()
        ];
    }
}
