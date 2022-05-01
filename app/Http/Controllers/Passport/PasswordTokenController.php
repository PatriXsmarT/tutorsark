<?php

namespace App\Http\Controllers\Passport;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Passport\PasswordToken;

class PasswordTokenController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->middleware('guest');

        return (new PasswordToken)(
            $request,
            config('passport.password_grant_client.id'),
            config('passport.password_grant_client.secret')
        );
    }
}
