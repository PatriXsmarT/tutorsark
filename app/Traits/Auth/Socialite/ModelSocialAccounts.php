<?php

namespace App\Traits\Auth\Socialite;

use App\Models\Socialite\SocialAccount;

trait ModelSocialAccounts
{
    /**
     * Model social accounts.
     *
     * @return App\Models\Socialite\SocialAccount;
     */
    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }
}
