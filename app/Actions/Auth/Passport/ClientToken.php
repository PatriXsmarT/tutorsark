<?php

namespace App\Actions\Auth\Passport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ClientToken
{
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
    public function __invoke($clientId, $clientSecret, $scope = '*')
    {
        return Http::asForm()->post(config('passport.token_endpoint'), [
            'grant_type' => 'client_credentials',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'scope' => $scope,
        ])->throw()->json();
    }
}
