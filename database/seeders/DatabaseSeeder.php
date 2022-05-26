<?php

namespace Database\Seeders;

use App\Models\Passport\Client;
use App\Models\Passport\PersonalAccessClient;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Laravel\Passport\ClientRepository;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(ClientRepository $clients)
    {


        Client::factory()->create([
            'id' => '96539625-e018-4915-b52c-88ec34378fae',
            'name' => 'TutorsArk Personal Access Client',
            'secret' => 'rcGnn1LdebzHsyWzkhVnLI4xCmLGGZ6iR5L4F8kK',
            'redirect' => 'http://localhost',
            'personal_access_client' => true,
            'password_client' => false,
            'revoked' => false
        ]);

        PersonalAccessClient::create([
            'id' => 1,
            'client_id' => '96539625-e018-4915-b52c-88ec34378fae'
        ]);

        Client::factory()->create([
            'id' => '96539626-102c-4e7b-8150-b549662b10df',
            'name' => 'TutorsArk Password Grant Client',
            'secret' => 'ubhKE7FZZV5MtUHedo66i5HZ4oD17t74thMbwaJC',
            'provider' => 'users',
            'redirect' => 'http://localhost',
            'personal_access_client' => false,
            'password_client' => true,
            'revoked' => false
        ]);
    }
}
