<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Authentication Guard
     */
    protected $guards = ['web'];

    /**
     * Model Roles
     */
    protected $roles = [
        'Admin',
        'CEO',
        'CTO',
        'CMO',
        'CSO',
        'HRM',
        'Accountant',
        'Guardian',
        'Manager',
        'Marketer',
        'School-Owner',
        'Software-Developer',
        'Student',
        'Super-Admin',
        'Tutor',
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->guards() as $guard) {
            foreach ($this->roles() as $role) {
                Role::factory()->create([
                    'name' => $role,
                    'guard_name' => $guard
                ]);
            }
        }
    }

    /**
     * Model Roles
     */
    protected function roles ()
    {
        return $this->roles;
    }

    /**
     * Authentication Guard
     */
    protected function guards ()
    {
        return $this->guards;
    }
}
