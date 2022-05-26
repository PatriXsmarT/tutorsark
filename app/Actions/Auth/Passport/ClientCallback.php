<?php

namespace App\Actions\Auth\Passport;

use Illuminate\Http\Request;
use InvalidArgumentException;
use Illuminate\Support\Facades\Http;

class ClientCallback
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
    public function __invoke(Request $request, $clientId = null, $clientSecret = null, $clientRedirectUri = null)
    {
        $state = $request->session()->pull('state');

        $codeVerifier = $request->session()->pull('code_verifier');

        throw_unless(
            strlen($state) > 0 && $state === $request->state,
            InvalidArgumentException::class
        );

        return Http::asForm()->post(config('passport.token_endpoint'), [
            'grant_type' => 'authorization_code',
            'client_id' => $clientId,
            'client_secret' => $clientSecret,
            'redirect_uri' => $clientRedirectUri,
            'code' => $request->code,
            'code_verifier' => $codeVerifier,
        ])->throw()->json();
    }
}
