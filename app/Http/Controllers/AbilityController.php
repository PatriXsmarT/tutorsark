<?php

namespace App\Http\Controllers;

use App\Models\Ability;
use App\Http\Requests\StoreAbilityRequest;
use App\Http\Requests\UpdateAbilityRequest;

class AbilityController extends Controller
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
     * @param  \App\Http\Requests\StoreAbilityRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAbilityRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ability  $ability
     * @return \Illuminate\Http\Response
     */
    public function show(Ability $ability)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ability  $ability
     * @return \Illuminate\Http\Response
     */
    public function edit(Ability $ability)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAbilityRequest  $request
     * @param  \App\Models\Ability  $ability
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAbilityRequest $request, Ability $ability)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ability  $ability
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ability $ability)
    {
        //
    }
}
