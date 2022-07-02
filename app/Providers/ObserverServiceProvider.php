<?php

namespace App\Providers;

use App\Models\Role;
use App\Models\User;
use App\Models\Avatar;
use App\Models\Profile;
use App\Observers\RoleObserver;
use App\Observers\UserObserver;
use App\Observers\AvatarObserver;
use App\Observers\ProfileObserver;
use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     *  This is the array of observers for each model.
     *
     * @var array
     */
    protected $modelObservers = [
        User::class => [
            UserObserver::class
        ],

        Profile::class => [
            ProfileObserver::class
        ],

        Avatar::class => [
            AvatarObserver::class
        ],

        Role::class => [
            RoleObserver::class
        ],
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerModelObservers();
    }

    /**
     *  Register all observers for each model.
     *
     * @return void
     */
    protected function registerModelObservers()
    {
        foreach($this->modelObservers as $model=>$observers){

            foreach($observers as $observer){

                $model::observe($observer);
            }
        }
    }
}
