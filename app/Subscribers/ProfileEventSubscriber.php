<?php

namespace App\Subscribers;


use App\Events\ProfileCreated;
use App\Events\ProfileUpdated;
use App\Notifications\ProfileCreatedSuccessfully;
use App\Notifications\ProfileUpdatedSuccessfully;


class ProfileEventSubscriber
{
    /**
     * Register the listeners for the subscriber.
     *
     * @param  \Illuminate\Events\Dispatcher  $events
     * @return array
     */
    public function subscribe($events)
    {
        return [
            ProfileCreated::class => [
                [ProfileEventSubscriber::class,'handleProfileCreated'],
            ],

            ProfileUpdated::class => [
                [ProfileEventSubscriber::class,'handleProfileUpdated'],
            ],
        ];
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ProfileCreated  $event
     * @return void
     */
    public function handleProfileCreated(ProfileCreated $event)
    {
        $event->user->notify(new ProfileCreatedSuccessfully);
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ProfileUpdated  $event
     * @return void
     */
    public function handleProfileUpdated(ProfileUpdated $event)
    {
        $event->user->notify(new ProfileUpdatedSuccessfully);
    }
}