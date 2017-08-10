<?php

namespace App\Models;

use Core\Database\Builder;

class User
{
    /**
     * Table for this model.
     * 
     * @var string
     */
    protected $table = 'users';

    /**
     * Find user by username in db.
     * 
     * @param  string $username
     * @return mixed
     */
    public static function findByUsername($username)
    {
        $user = new static;
// dd($username);
        return (new Builder)->table($user->table)
            ->where('username', '=', $username)
            ->get()[0];
    }
}