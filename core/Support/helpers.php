<?php

use Core\Auth\Auth;
use Core\Container;
use Core\Collection\Collection;
use Core\Session\ErrorsSessionStorage;
use Core\Session\RequestSessionStorage;

/**
 * Helper for output validation errors.
 * 
 * @param  string $errorName
 * @return string
 */
function errors($errorName = null)
{
    if ($errorName) {
        return new Collection((new ErrorsSessionStorage())->get($errorName));    
    }

    return new ErrorsSessionStorage();
}

/**
 * Helper for old input.
 * 
 * @param  string $key
 * @param  string $default value
 * @return mixed
 */
function old($key, $default = '')
{
    $storage = new RequestSessionStorage;

    return $storage->has($key) ? $storage->get($key) : $default;
}

/**
 * Dump the value and die script.
 * 
 * @param  mixed $value
 * @return void
 */
function dd($value)
{
    var_dump($value);
    die();
}

/**
 * Include partial to the view.
 *
 * @param  array $data
 * @return void
 */
function includePartial($path, array $data = [])
{
    extract($data);

    require "./app/views/$path";
}

/**
 * Get config.
 *
 * @param  string $key
 * @return mixed
 */
function config($key)
{
    return Container::instance()->config[$key];
}

/**
 * Create auth handler.
 * 
 * @return Auth
 */
function auth()
{
    return (new Auth);
}
