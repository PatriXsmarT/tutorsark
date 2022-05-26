<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Traits\Auth\RedirectsUsers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Validation\ValidationException;
use App\Http\Requests\Auth\PasswordConfirmationRequest;

class PasswordConfirmationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Confirm Password Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password confirmations and
    | uses a simple trait to include the behavior. You're free to explore
    | this trait and override any functions that require customization.
    |
    */

    use RedirectsUsers;

    /**
     * Where to redirect users when the intended url fails.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request)
    {
        $request->wantsJson()
            ? $this->middleware('auth:api')
            : $this->middleware(['auth','throttle:6,1']);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('auth.confirm-password');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  App\Http\Requests\Auth\PasswordConfirmationRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PasswordConfirmationRequest $request)
    {
        if (!Auth::guard('web')->validate([
            'email' => $request->user()->email,
            'password' => $request->password,
        ])){

            throw ValidationException::withMessages([
                'password' => __('auth.password'),
            ]);
        }

        if(!$request->wantsJson()){

            $request->session()->passwordConfirmed();

            return redirect()->intended($this->redirectPath());
        }

        return  new JsonResponse([], 204);
    }
}
