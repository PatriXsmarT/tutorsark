<?php

namespace App\Http\Controllers\Auth\Passport;

use App\Actions\Auth\Passport\RedirectClient;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RedirectController extends Controller
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

        return (new RedirectClient)(
            $request,
            $request->client_id, // CLIENT_ID
            $request->client_redirect_uri // CLIENT_Redirect_URI
        );
    }
}
