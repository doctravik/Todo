<?php

use Core\Collection\Collection;
use Core\Session\ErrorsSessionStorage;

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

