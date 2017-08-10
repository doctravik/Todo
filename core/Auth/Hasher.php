<?php

namespace Core\Auth;

class Hasher
{
    /**
     * Create hash code for password value.
     * 
     * @param  string $password
     * @return string
     */
    public function crypt($password)
    {
        return password_hash($password, PASSWORD_DEFAULT);
    }
}