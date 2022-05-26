<?php

namespace App\Http\Controllers\Auth\Socialite;

use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use Laravel\Socialite\Facades\Socialite;

class ProviderRedirectController extends Controller
{
    /**
     * Redirect the user to the Provider authentication page.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  String  $provider
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $provider)
    {
        // Add any addition parameters you which to have back from providers as a query string
        //  to the state parameter, it will be returned back by all providers.
        $queryString = Arr::query([
            'request_callback_url' => $request->query('callback_url',config('app.url'))
        ]);

        // Hash the query string you want to pass as the state parameter
        $hashedStateQuery = Hash::make($queryString);

        // Used the hash as the key to store query string in other to retrieve them later.
        Cache::put([$hashedStateQuery => $queryString], now()->addSeconds(3600));

        $toProvider =   $provider == 'twitter'?
                            Socialite::driver($provider)
                            :
                            Socialite::driver($provider)
                            ->with([
                                'state' => $hashedStateQuery,
                                'access_type' => 'offline' // Added cause of Google.
                            ])->stateless();

        return  $request->wantsJson() ?
                    $toProvider->redirect()->getTargetUrl() :
                    $toProvider->redirect() ;
    }
}
