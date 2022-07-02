<?php

namespace App\Observers;

use App\Models\Profile;
use App\Events\ProfileCreated;
use App\Events\ProfileUpdated;

class ProfileObserver
{
    /**
     * Handle the Profile "created" event.
     *
     * @param  \App\Models\Profile  $profile
     * @return void
     */
    public function created(Profile $profile)
    {
        event(new ProfileCreated($profile->owner));
    }

    /**
     * Handle the Profile "updated" event.
     *
     * @param  \App\Models\Profile  $profile
     * @return void
     */
    public function updated(Profile $profile)
    {
        event(new ProfileUpdated($profile->owner));
    }

    /**
     * Handle the Profile "deleted" event.
     *
     * @param  \App\Models\Profile  $profile
     * @return void
     */
    public function deleted(Profile $profile)
    {
        //
    }

    /**
     * Handle the Profile "restored" event.
     *
     * @param  \App\Models\Profile  $profile
     * @return void
     */
    public function restored(Profile $profile)
    {
        //
    }

    /**
     * Handle the Profile "force deleted" event.
     *
     * @param  \App\Models\Profile  $profile
     * @return void
     */
    public function forceDeleted(Profile $profile)
    {
        //
    }
}
