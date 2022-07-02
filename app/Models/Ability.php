<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ability extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get all of the roles that are assigned this ability.
     */
    public function roles()
    {
        return $this->morphedByMany(Role::class, 'abilitable')->withTimeStamps();
    }
}
