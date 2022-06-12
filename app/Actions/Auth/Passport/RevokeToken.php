<?php

namespace App\Actions\Auth\Passport;

use Lcobucci\JWT\Token\Parser;
use Illuminate\Http\Request;
use Laravel\Passport\TokenRepository;
use Laravel\Passport\RefreshTokenRepository;
use Lcobucci\JWT\Encoding\JoseEncoder;

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
        $tokenId = (new Parser(new JoseEncoder()))->parse($request->bearerToken())->claims()->all()['jti'];
        // $tokenId = $request->user('api')->token()->id;

        // Revoke an access token...
        $tokenRepository = app(TokenRepository::class);
        $tokenRepository->revokeAccessToken($tokenId);

        // Revoke all of the token's refresh tokens...
        $refreshTokenRepository = app(RefreshTokenRepository::class);
        $refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);

        return $tokenId;
    }
}
