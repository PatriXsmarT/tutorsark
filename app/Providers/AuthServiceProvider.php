<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            // This works in the app by using gate-related functions like auth()->user->can() and @can()
            return $user->combinedAbilitiesThrough('roles')->pluck('name')->contains($ability)? true : null;
        });

        Gate::after(function ($user, $ability) {
            // if your Super Admin shouldn't be allowed to do things your app doesn't want "anyone" to do.
            return $user->hasRole('super-admin'); // note this returns boolean
        });
    }
}
