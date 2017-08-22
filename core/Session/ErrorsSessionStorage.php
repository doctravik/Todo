<?php

namespace Core\Session;

class ErrorsSessionStorage extends SessionStorage
{
    /**
     * Create new instance of the ErrorsSessionStorage.
     *
     * @param string $name of storage
     * @return void
     */
    public function __construct($name = 'errors')
    {
        parent::__construct($name);
    }
}
