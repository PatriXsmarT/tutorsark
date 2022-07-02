<?php

namespace App\Http\Controllers\Auth\Socialite;

use App\Http\Controllers\Controller;
use App\Models\Auth\Socialite\SocialAccount;
use App\Http\Requests\Auth\Socialite\StoreSocialAccountRequest;
use App\Http\Requests\Auth\Socialite\UpdateSocialAccountRequest;

class SocialAccountController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Auth\Socialite\StoreSocialAccountRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSocialAccountRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Socialite\SocialAccount  $socialAccount
     * @return \Illuminate\Http\Response
     */
    public function show(SocialAccount $socialAccount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Socialite\SocialAccount  $socialAccount
     * @return \Illuminate\Http\Response
     */
    public function edit(SocialAccount $socialAccount)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Auth\Socialite\UpdateSocialAccountRequest  $request
     * @param  \App\Models\Socialite\SocialAccount  $socialAccount
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSocialAccountRequest $request, SocialAccount $socialAccount)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Socialite\SocialAccount  $socialAccount
     * @return \Illuminate\Http\Response
     */
    public function destroy(SocialAccount $socialAccount)
    {
        //
    }
}
