<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use App\Models\Avatar;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreAvatarRequest;
use App\Http\Requests\UpdateAvatarRequest;

class AvatarController extends Controller
{
    const Max_Allowed = 10;

    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $this->authorize('viewAny', Avatar::class);

        return $user->avatars;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreAvatarRequest  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAvatarRequest $request, User $user)
    {
        $this->authorize('create', Avatar::class);

        return $user->avatars()->create([
            'path' => $request->file('avatar')->store('avatars', 'public'),
            'uploader_id' => $user->id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Avatar  $avatar
     * @return \Illuminate\Http\Response
     */
    public function show(Avatar $avatar)
    {
        $this->authorize('view', $avatar);

        return $avatar;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateAvatarRequest  $request
     * @param  \App\Models\Avatar  $avatar
     * @return \Illuminate\Http\Response
     */
    // public function update(UpdateAvatarRequest $request, Avatar $avatar)
    // {
    //     //
    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Avatar  $avatar
     * @return \Illuminate\Http\Response
     */
    public function destroy(Avatar $avatar)
    {
        $this->authorize('delete', $avatar);

        return $avatar->delete();
    }
}
