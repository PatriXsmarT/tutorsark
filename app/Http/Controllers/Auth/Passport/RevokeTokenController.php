<?php

namespace App\Http\Controllers\Auth\Passport;

use App\Actions\Auth\Passport\RevokeToken;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RevokeTokenController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $this->middleware('auth:api');

        return (new RevokeToken)($request);
    }
}
