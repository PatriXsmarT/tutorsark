<?php

namespace App\Actions\Passport;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RefreshToken
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
    public function __invoke(Request $request, $clientId, $clientSecret, $scope = '*')
    {
        return Http::asForm()->post(config('passport.token_endpoint'),
        [
            'grant_type' => 'refresh_token',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'refresh_token' => $request->refresh_token,
            'scope' => $scope
        ])->throw()->json();
    }
}
