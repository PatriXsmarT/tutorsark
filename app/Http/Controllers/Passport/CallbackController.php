<?php

namespace App\Http\Controllers\Passport;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Actions\Passport\ClientCallback;

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
        $this->middleware('guest');

        return (new ClientCallback)(
            $request,
            '', // CLIENT_ID
            '', // CLIENT_SECRET
            '' // REDIRECT_URI,
        );
    }
}
