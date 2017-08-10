<?php

namespace Core\Auth;

class Auth
{
    /**
     * Helper for checking if user is authenticated.
     * 
     * @return boolean
     */
    public static function check()
    {
        return isset($_SESSION['is_authenticated']) 
            && $_SESSION['is_authenticated'] === true;
    }

    /**
     * Set admin credentials
     * 
     * @return void
     */
    public static function login()
    {
        $_SESSION['is_authenticated'] = true;
    }

    /**
     * Reset admin credentials
     * 
     * @return void
     */
    public static function logout()
    {
        unset($_SESSION['is_authenticated']);
    }
}
