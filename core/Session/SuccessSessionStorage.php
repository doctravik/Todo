<?php

namespace Core\Session;

class SuccessSessionStorage extends SessionStorage
{
    /**
     * Create new instance of the SuccessSessionStorage.
     *
     * @param string $name of storage
     * @return void
     */
    public function __construct($name = 'success')
    {
        parent::__construct($name);
    }
}
