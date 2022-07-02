<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
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
            'country' => $this->faker->country(),
            'user_id'=> $user = User::factory()->create()
        ];
    }
}
