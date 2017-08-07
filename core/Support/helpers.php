<?php

use Core\Collection\Collection;
use Core\Session\ErrorsSessionStorage;
use Core\Session\RequestSessionStorage;

/**
 * Helper for output validation errors.
 * 
 * @param  string $errorName
 * @return string
 */
function errors($errorName)
{
    return new Collection((new ErrorsSessionStorage())->get($errorName));
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

    return $storage->exists($key) ? $storage->get($key) : $default;
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

