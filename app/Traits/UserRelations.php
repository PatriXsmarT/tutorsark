<?php

namespace App\Traits;

use App\Models\Profile;

trait UserRelations
{
    /**
     * Get the profile of a user
     */
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}