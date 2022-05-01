<?php

namespace App\Providers;

use App\Models\Passport\Token;
use Laravel\Passport\Passport;
use App\Models\Passport\Client;
use App\Models\Passport\AuthCode;
use Illuminate\Support\ServiceProvider;
use App\Models\Passport\PersonalAccessClient;

class PassportServiceProvider extends ServiceProvider
{
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
        Passport::routes();

        // Passport::loadKeysFrom(__DIR__.'/../../storage');

        // Passport::hashClientSecrets();

        Passport::tokensExpireIn(now()->addDays(30));

        Passport::refreshTokensExpireIn(now()->addYear());

        Passport::personalAccessTokensExpireIn(now()->addMonths(6));

        Passport::useTokenModel(Token::class);

        Passport::useClientModel(Client::class);

        Passport::useAuthCodeModel(AuthCode::class);

        Passport::usePersonalAccessClientModel(PersonalAccessClient::class);

        // Passport::enableImplicitGrant(); // Not recommended

        Passport::tokensCan(config('passport.tokens_can'));

        Passport::setDefaultScope(config('passport.default_scope'));

        Passport::cookie(config('passport.cookie_name'));
    }
}
