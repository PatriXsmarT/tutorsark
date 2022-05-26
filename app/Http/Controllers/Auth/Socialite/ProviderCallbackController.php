<?php

namespace App\Http\Controllers\Auth\Socialite;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Actions\Auth\Passport\PersonalToken;
use App\Actions\Auth\Socialite\ProviderUser;
use App\Providers\RouteServiceProvider;

class ProviderCallbackController extends Controller
{
    /**
     * Authenticate the user from Provider.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  String  $provider
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request, $provider)
    {
        $providerUser = (new ProviderUser)($provider);

        $user = User::whereEmail($providerUser->getEmail())->firstOrFail();

        $socialAccount = $user->social_accounts()->where([
            'provider' => $provider,
            'provider_id' => $providerUser->getId()
        ])->first();

        if(!$socialAccount){

            $user->social_accounts()->create(
                $this->neededData($provider, $providerUser)
            );
        } else {

            $socialAccount->update(
                $this->neededData($provider, $providerUser)
            );
        }

        return  $this->authenticate($request, $user, $provider);
    }

    /**
     *  Get social media account informations.
     *
     * @param $provider
     * @param $providerUser
     *
     * @return array
     */
    protected function neededData($provider, $providerUser)
    {
        return [
            "provider" => $provider,
            "provider_id" => $providerUser->getId(),
            "token" => $providerUser->token,
            "token_secret" => $provider == 'twitter' ? $providerUser->tokenSecret : null,
            "refresh_token" => $provider != 'twitter' ? $providerUser->refreshToken : null,
            "expires_in" => $provider != 'twitter' ? $providerUser->expiresIn : null,
            "name" => $providerUser->getName(),
            "nickname" => $providerUser->getNickname(),
            "email" => $providerUser->getEmail(),
            "avatar" => $providerUser->getAvatar(),
            "content" => json_encode($providerUser)
        ];
    }

    /**
     *
     */
    protected function authenticate(Request $request, User $user, $provider)
    {
        if($request->state) {

            $unHashedStateQuery = Cache::pull($request->state);

            parse_str($unHashedStateQuery, $state);

            if($state['request_callback_url'] != config(('app.url'))){

                // Generate Personal Token and redirect
                return redirect()->away(
                    $state['request_callback_url'].'?'.
                    Arr::query([
                        'tutorsark' => (new PersonalToken)($user, $provider.'@'.time())
                    ])
                );
            }
        }

        Auth::login($user);

        return redirect()->intended(RouteServiceProvider::HOME);
    }
}
