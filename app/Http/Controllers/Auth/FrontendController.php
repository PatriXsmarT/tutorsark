<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FrontendController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        if($request->path() == "/"){

            return redirect()->away(config('frontend.app.url'));
        }

        return redirect()->away(config('frontend.app.url').'/'.$request->path());
    }
}
