<?php

namespace App\Actions\Passport;

use Illuminate\Http\Request;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;

class RevokeToken
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $tokenId = $request->user()->token()->id;

        // Revoke an access token...
        $tokenRepository = app(TokenRepository::class);
        $tokenRepository->revokeAccessToken($tokenId);

        // Revoke all of the token's refresh tokens...
        $refreshTokenRepository = app(RefreshTokenRepository::class);
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);

        return true;
    }
}
