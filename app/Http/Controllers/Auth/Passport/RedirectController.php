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
            '', // CLIENT_ID
            '' // CLIENT_SECRET
        );
    }
}
