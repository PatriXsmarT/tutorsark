<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Traits\Auth\RedirectsUsers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Actions\Auth\Passport\RevokeToken;
use App\Actions\Auth\Passport\PasswordToken;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Authentication Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and redirecting
    | them to your home screen or issue api token. The controller uses a trait to
    | conveniently provide its functionality to your applications.
    |
    |
    */

    use RedirectsUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->middleware('guest')->except(['index','logoutOtherDevices','logoutDevice']);

        $request->bearerToken()?
        $this->middleware('auth:api')->only(['index','logoutDevice']):
        $this->middleware('auth')->only(['index','logoutOtherDevices','logoutDevice']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Auth::user();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an authentication attempt.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(LoginRequest $request)
    {
        if(! $request->wantsJson()){

            $request->authenticate();

            $request->session()->regenerate();

            return redirect()->intended($this->redirectPath());
        }

        // Generate Token For Api
        return (new PasswordToken)(
            $request,
            config('passport.password_grant_client.id'),
            config('passport.password_grant_client.secret'),
        );
    }

    /**
     * Destroy an authenticated session in other devices.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logoutOtherDevices(Request $request)
    {
        $request->validate([
            'password' => ['required','string','confirmed']
        ]);

        $currentPassword = $request->password;

        return Auth::logoutOtherDevices($currentPassword);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logoutDevice(Request $request)
    {
        if(! $request->bearerToken()){
            Auth::logout();

            $request->session()->invalidate();

            $request->session()->regenerateToken();
        } else {

            // Revoke user request auth token
            (new RevokeToken)($request);
        }

        return $request->wantsJson()
            ? new JsonResponse([], 204)
            : redirect('/');
    }
}
