<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Avatar>
 */
class AvatarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $avatarable = User::class;

        $uploader = User::class;

        return [
            'avatarable_type' => $avatarable,
            'avatarable_id' => $avatarable::factory(),
            'path' => UploadedFile::fake()->image('avatar.jpg')->store('avatars','public'),
            'uploader_id' => $uploader::factory()
        ];
    }
}
