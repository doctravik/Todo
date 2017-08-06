<?php

use Core\Collection\Collection;
use Core\Session\ErrorsSessionStorage;

function errors($errorName)
{
    return new Collection((new ErrorsSessionStorage())->get($errorName));
}