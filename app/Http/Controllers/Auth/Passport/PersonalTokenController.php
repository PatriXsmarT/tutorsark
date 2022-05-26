<?php

namespace App\Http\Controllers\Auth\Passport;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Auth\Passport\PersonalToken;

class PersonalTokenController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // Personal token name
        $tokenName = $request->token_name?: Str::random(6).'@'.time();

        // Personal token scopes
        $tokenScopes = $request->token_scopes?:config('passport.default_scope');

        return (new PersonalToken)($request->user(), $tokenName, $tokenScopes);
    }
}
