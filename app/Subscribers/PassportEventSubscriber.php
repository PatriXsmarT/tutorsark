<?php

namespace App\Subscribers;

use Laravel\Passport\Events\AccessTokenCreated;
use Laravel\Passport\Events\RefreshTokenCreated;

class PassportEventSubscriber
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
            'Laravel\Passport\Events\AccessTokenCreated' => [
                [PassportEventSubscriber::class,'handleRevokeOldTokens'],
            ],

            'Laravel\Passport\Events\RefreshTokenCreated' => [
                [PassportEventSubscriber::class,'handlePruneOldTokens'],
            ],
        ];
    }

    /**
     * Handle the event.
     *
     * @param  AccessTokenCreated  $event
     * @return void
     */
    public function handleRevokeOldTokens(AccessTokenCreated $event)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  RefreshTokenCreated  $event
     * @return void
     */
    public function handlePruneOldTokens(RefreshTokenCreated $event)
    {
        //
    }
}
