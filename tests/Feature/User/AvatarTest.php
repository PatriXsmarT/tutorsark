<?php

namespace Tests\Feature\User;

use Tests\TestCase;
use App\Models\User;
use App\Models\Avatar;
use App\Events\AvatarCreated;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AvatarTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_see_their_avatars()
    {
        $this->noHandling();

        $user = User::factory()->create();

        Avatar::factory(3)->for($user,'avatarable')->create([
            'uploader_id' => $user
        ]);

        $this->actingAs($user,'api');

        $this->getJson('api/users/'.$user->id.'/avatars')
        ->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_view_their_avatar()
    {
        $user = User::factory()->create();

        $avatar = Avatar::factory()->for($user, 'avatarable')->create([
            'uploader_id' => $user
        ]);

        $this->actingAs($user,'api');

        $this->getJson('api/avatars/'.$avatar->id)
        ->assertJson($avatar->toArray())
        ->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_users_can_upload_an_avatar()
    {
        Event::fake(AvatarCreated::class);

        $this->noHandling();

        $user = User::factory()->create();

        $this->actingAs($user,'api');

        $this->postJson('api/users/'.$user->id.'/avatars', $this->avatarData())
        ->assertJsonStructure(['path','uploader_id'])
        ->assertStatus(201);

        Event::assertDispatched(AvatarCreated::class);
    }

    /**
     * Create a new avatar data.
     */
    protected function avatarData()
    {
        return [
            'avatar' => UploadedFile::fake()->image('avatar.jpg')
        ];
    }
}
