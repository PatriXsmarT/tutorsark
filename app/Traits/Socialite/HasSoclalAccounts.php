<?php

namespace App\Traits\Socialite;

trait HasSocialAccounts
{
    /**
     * Model can have many social accounts.
     */
    public function social_accounts()
    {
        return $this->hasMany(SocialAccount::class);
    }
}
