<?php

namespace App\Http\Controllers\Passport;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Passport\RefreshToken;

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
        $this->middleware('guest');

        return (new RefreshToken)(
            $request,
            '', // CLIENT_ID
            '' // CLIENT_SECRET
        );
    }
}
