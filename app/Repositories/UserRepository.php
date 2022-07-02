<?php

namespace App\Repositories;

use App\Models\User;
use App\Contracts\Repository\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    /**
     *
     */
    protected $users;

    /**
     *
     */
    public function __construct(User $users)
    {
        $this->users = $users;
    }

    /**
     *
     * @return array
     */
    public function all()
    {
        return $this->users->all();
    }

    /**
     *
     * @return int
     */
    public function count()
    {
        return $this->users->count();
    }
}
