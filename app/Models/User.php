<?php

namespace App\Models;

use App\Traits\HasRoles;
use App\Traits\HasAvatars;
use App\Traits\UserRelations;
use Laravel\Passport\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Auth\Passport\HasPasswordGrant;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\Auth\Socialite\ModelSocialAccounts;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail
{
    use
    HasApiTokens,
    HasRoles,
    HasAvatars,
    HasPasswordGrant,
    ModelSocialAccounts,
    HasFactory,
    UserRelations,
    Notifiable,
    SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'name',
    //     'email',
    //     'password',
    // ];

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
