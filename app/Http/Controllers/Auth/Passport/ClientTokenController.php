<?php

namespace App\Http\Controllers\Auth\Passport;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Auth\Passport\ClientToken;

class ClientTokenController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return (new ClientToken)(
            $request->input('client_id'), // CLIENT_ID
            $request->input('client_secret'), // CLIENT_SECRET
        );
    }
}
