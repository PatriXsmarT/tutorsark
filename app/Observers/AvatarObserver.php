<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Avatar;
use App\Jobs\ResizeImage;
use App\Events\AvatarCreated;
use Illuminate\Support\Facades\Storage;

class AvatarObserver
{
    /**
     * Handle the Avatar "created" event.
     *
     * @param  \App\Models\Avatar  $avatar
     * @return void
     */
    public function created(Avatar $avatar)
    {
        $user = User::findOrFail($avatar->uploader_id);

        if ($user->avatars->count() > Avatar::User_Max_Allowed) {

            $avatar = $user->avatars()->first();

            Storage::disk('public')->delete($avatar->path);

            $avatar->delete();
        }

        ResizeImage::dispatch('storage/'.$avatar->path, 500, 500);

        event(new AvatarCreated($user));
    }

    /**
     * Handle the Avatar "updated" event.
     *
     * @param  \App\Models\Avatar  $avatar
     * @return void
     */
    public function updated(Avatar $avatar)
    {
        //
    }

    /**
     * Handle the Avatar "deleted" event.
     *
     * @param  \App\Models\Avatar  $avatar
     * @return void
     */
    public function deleted(Avatar $avatar)
    {
        //
    }

    /**
     * Handle the Avatar "restored" event.
     *
     * @param  \App\Models\Avatar  $avatar
     * @return void
     */
    public function restored(Avatar $avatar)
    {
        //
    }

    /**
     * Handle the Avatar "force deleted" event.
     *
     * @param  \App\Models\Avatar  $avatar
     * @return void
     */
    public function forceDeleted(Avatar $avatar)
    {
        //
    }
}
