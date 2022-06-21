<?php

namespace App\Http\Controllers\Auth\Passport;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Auth\Passport\RedirectClient;

class ImplicitTokenController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return (new RedirectClient)(
            $request,
            $request->client_id, // CLIENT_ID
            $request->client_redirect_uri, // CLIENT_Redirect_URI
            '', // ACCESS SCOPES
            'token' // CLIENT_SECRET
        );
    }
}
