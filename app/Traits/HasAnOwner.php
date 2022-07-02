<?php

namespace App\Traits;

use App\Models\User;

trait HasAnOwner
{
    public function user(){

        return $this->belongsTo(User::class);
    }

    public function owner(){

        return $this->belongsTo(User::class,'user_id');
    }
}
