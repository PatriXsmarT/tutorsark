<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     *
     */
    public function rolesNeeded(){

        return config('app.roles');
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->rolesNeeded() as $role) {
            // Create the role needed.
            Role::factory()->create([
                'name' => $role
            ]);
        }
    }
}
