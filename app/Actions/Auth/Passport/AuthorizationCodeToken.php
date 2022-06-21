<?php

namespace App\Actions\Auth\Passport;

use Illuminate\Http\Request;
use InvalidArgumentException;
use Illuminate\Support\Facades\Http;

class AuthorizationCodeToken
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param String $clientId
     * @param String $clientSecret
     * @param String $clientRedirectUri
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $clientId = null, $clientRedirectUri = null, $clientSecret = null)
    {
        $state = $request->session()->pull('state');

        $codeVerifier = $request->session()->pull('code_verifier');

        throw_unless(
            strlen($state) > 0 && $state === $request->state,
            InvalidArgumentException::class
        );

        $postData = [
            'grant_type' => 'authorization_code',// 'grant_type' => 'authorization_code',
            'client_id' => $clientId,
            'redirect_uri' => $clientRedirectUri,
            'code_verifier' => $codeVerifier,
            'code' => $request->code,
            'client_secret' => $clientSecret,
        ];

        return Http::asForm()->post(config('passport.token_endpoint'), $postData)->throw()->json();
    }
}
