<?php

namespace App\Http\Controllers\Auth\Passport;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Auth\Passport\AuthorizationCodeToken;

class CallbackController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if($request->code){
            return (new AuthorizationCodeToken)(
                $request,
                $request->header('client_id'), // CLIENT_ID
                $request->header('client_redirect_uri'), // REDIRECT_URI
                $request->header('client_secret') // CLIENT_SECRET
            );
        }

        return [
            'access_token' => $request->input('access_token'),
            'token_type' => $request->input('token_type'),
            'expires_in' => $request->input('expires_in')
        ];
    }
}
