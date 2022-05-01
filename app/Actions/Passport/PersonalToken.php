<?php

namespace App\Actions\Passport;

use App\Models\User;

class PersonalToken
{
    /**
     * Handle the incoming request.
     *
     * @param  \App\Models\User  $user
     * @param String $tokenName
     * @param Array $tokenScopes
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(User $user, $tokenName, $tokenScopes = null)
    {
        // Token scopes...
        $tokenScopes = $tokenScopes?:[];

        // Creating a personal token...
        return $user->createToken($tokenName, $tokenScopes);
    }
}
