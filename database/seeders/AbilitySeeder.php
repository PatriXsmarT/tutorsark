<?php

namespace Database\Seeders;

use App\Models\Ability;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AbilitySeeder extends Seeder
{
    /**
     *
     */
    public function abilitiesNeeded(){

        return config('app.abilities');
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->abilitiesNeeded() as $ability) {
            // Create the role needed.
            Ability::factory()->create([
                'name' => $ability
            ]);
        }
    }
}
