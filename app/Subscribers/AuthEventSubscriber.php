<?php

namespace App\Subscribers;

use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Failed;
use Illuminate\Auth\Events\Logout;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Events\Validated;
use Illuminate\Auth\Events\Attempting;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\OtherDeviceLogout;
use Illuminate\Auth\Events\CurrentDeviceLogout;

class AuthEventSubscriber
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

            'Illuminate\Auth\Events\Registered' => [
                [AuthEventSubscriber::class,'handleRegisteredUser'],
            ],

            'Illuminate\Auth\Events\Attempting' => [
                [AuthEventSubscriber::class,'handleAuthenticationAttempt'],
            ],

            'Illuminate\Auth\Events\Authenticated' => [
                [AuthEventSubscriber::class,'handleAuthenticated'],
            ],

            'Illuminate\Auth\Events\Login' => [
                [AuthEventSubscriber::class,'handleSuccessfulLogin'],
            ],

            'Illuminate\Auth\Events\Failed' => [
                [AuthEventSubscriber::class,'handleFailedLogin'],
            ],

            'Illuminate\Auth\Events\Validated' => [
                [AuthEventSubscriber::class,'handleValidated'],
            ],

            'Illuminate\Auth\Events\Verified' => [
                [AuthEventSubscriber::class,'handleVerified'],
            ],

            'Illuminate\Auth\Events\Logout' => [
                [AuthEventSubscriber::class,'handleSuccessfulLogout'],
            ],

            'Illuminate\Auth\Events\CurrentDeviceLogout' => [
                [AuthEventSubscriber::class,'handleCurrentDeviceLogout'],
            ],

            'Illuminate\Auth\Events\OtherDeviceLogout' => [
                [AuthEventSubscriber::class,'handleOtherDeviceLogout'],
            ],

            'Illuminate\Auth\Events\Lockout' => [
                [AuthEventSubscriber::class,'handleLockout'],
            ],

            'Illuminate\Auth\Events\PasswordReset' => [
                [AuthEventSubscriber::class,'handlePasswordReset']
            ],
        ];
    }

    /**
     * Handle the event.
     *
     * @param  Registered  $event
     * @return void
     */
    public function handleRegisteredUser(Registered $event)
    {

    }

    /**
     * Handle the event.
     *
     * @param  Attempting  $event
     * @return void
     */
    public function handleAuthenticationAttempt(Attempting $event)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Authenticated  $event
     * @return void
     */
    public function handleAuthenticated(Authenticated $event)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handleSuccessfulLogin(Login $event)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Failed  $event
     * @return void
     */
    public function handleFailedLogin(Failed $event)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Validated  $event
     * @return void
     */
    public function handleValidated(Validated $event)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Verified  $event
     * @return void
     */
    public function handleVerified(Verified $event)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Logout  $event
     * @return void
     */
    public function handleSuccessfulLogout(Logout $event)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CurrentDeviceLogout  $event
     * @return void
     */
    public function handleCurrentDeviceLogout(CurrentDeviceLogout $event)
    {
        //
    }

     /**
     * Handle the event.
     *
     * @param  OtherDeviceLogout  $event
     * @return void
     */
    public function handleOtherDeviceLogout(OtherDeviceLogout $event)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Lockout  $event
     * @return void
     */
    public function handleLockout(Lockout $event)
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  PasswordReset  $event
     * @return void
     */
    public function handlePasswordReset(PasswordReset $event)
    {
        //
    }
}
