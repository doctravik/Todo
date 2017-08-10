<?php

namespace App\Models;

use Core\Auth\Hasher;
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

        $users = (new Builder)->table($user->table)
            ->where('username', '=', $username)
            ->get();

        if ($users) {
            return $users[0];
        }

        return null;
    }

    /**
     * Register user in db.
     * 
     * @param  array $attributes
     * @return boolean
     */
    public static function register($attributes)
    {
        $user = new static;

        return (new Builder)->table($user->table)->insert(
            array_merge($attributes, ['password' => Hasher::crypt($attributes['password'])])
        );
    }
}