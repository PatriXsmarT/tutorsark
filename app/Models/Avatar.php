<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Avatar extends Model
{
    use HasFactory;

    /**
     *
     */
    const User_Max_Allowed = 10;

    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Get the parent avatarable model.
     */
    public function avatarable()
    {
        return $this->morphTo('avatarable');
    }
}
