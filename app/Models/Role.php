<?php

namespace App\Models;

use App\Traits\HasAbilities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, HasAbilities, SoftDeletes;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get all of the users that are assigned this role.
     */
    public function users()
    {
        return $this->morphedByMany(User::class, 'roleable')->withTimeStamps();
    }
}
