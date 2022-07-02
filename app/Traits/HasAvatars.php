<?php

namespace App\Traits;

use App\Models\Avatar;

trait HasAvatars
{
    public function avatars(){

        return $this->morphMany(Avatar::class,'avatarable');
    }

}
