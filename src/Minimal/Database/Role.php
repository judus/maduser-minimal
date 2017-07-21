<?php

namespace Maduser\Minimal\Database;

class Role extends ORM
{
    protected $table = 'roles';

    public function users()
    {
        return $this->belongsToMany(User::class, 'role_id', 'id');
    }

}