<?php

namespace App\Actions\Auth\Passport;

use Illuminate\Http\Request;
use App\Models\Passport\Client;
use Illuminate\Support\Facades\Http;
use App\Models\Passport\PersonalAccessClient;

class PasswordToken
{
    /**
     * The login username column variable.
     *
     * @return string
     */
    public static $username = 'email';

    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param String $clientId
     * @param String $clientSecret
     * @param String $scope
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $clientId, $clientSecret, $scope ="*")
    {
        return Http::asForm()->post(config('passport.token_endpoint'),
        [
            'grant_type' => 'password',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'username' => $request->input(static::username()),
            'password' =>  $request->password,
            'scope' => $scope
        ])->throw()->json();
    }

    /**
     * Get the login username column variable to be used.
     *
     * @return string
     */
    public static function username()
    {
        return static::$username;
    }
}
