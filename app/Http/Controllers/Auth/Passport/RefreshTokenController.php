<?php

namespace App\Http\Controllers\Auth\Passport;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Auth\Passport\RefreshToken;

class RefreshTokenController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return (new RefreshToken)(
            $request,
            $request->client_id, // CLIENT_ID
            $request->client_secret, // CLIENT_SECRET
            // $request->scopes // Access Scope
        );
    }
}
