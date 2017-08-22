<?php

namespace Core\Session;

class RequestSessionStorage extends SessionStorage
{
    /**
     * Create new instance of the RequestSessionStorage.
     *
     * @param string $name of storage
     * @return void
     */
    public function __construct($name = 'old_input')
    {
        parent::__construct($name);
    }
}
