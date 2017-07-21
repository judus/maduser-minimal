<?php

namespace Maduser\Minimal\Database;

use Maduser\Minimal\Exceptions\MinimalException;

class User extends ORM
{
    protected $table = 'users';

    public function profile()
    {
        return $this->hasOne(Profile::class, 'user_id', 'id');
    }

    public function role()
    {
        return $this->hasMany(Role::class, 'role_user', 'role_id', 'user_id', 'id');
    }
}