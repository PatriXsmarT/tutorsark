<?php

namespace App\Subscribers;

class PassportEventSubscriber
{
    /**
     * Revokes old tokens.
     */
    public function revokeOldTokens($event) {

    }

    /**
     * Prune old tokens.
     */
    public function pruneOldTokens($event) {

    }

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
                'revokeOldTokens',
            ],

            'Laravel\Passport\Events\RefreshTokenCreated' => [
                'pruneOldTokens',
            ],
        ];
    }
}
