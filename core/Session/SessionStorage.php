<?php

namespace Core\Session;

class SessionStorage
{    
    /**
     * @var string
     */
    protected $name;

    /**
     * Create new instance of the SessionStorage.
     * 
     * @param string $name of storage
     * @return void
     */
    public function __construct($name = 'data')
    {
        if (! isset($_SESSION[$name])) {
            $_SESSION[$name] = [];
        }

        $this->name = $name;
    }

    /**
     * Put set of data to the session storage.
     * 
     * @param  array $data
     * @return void
     */
    public function set(array $data)
    {
        $_SESSION[$this->name] = $data;
    }

    /**
     * Get value by key.
     * 
     * @param  string $key
     * @param  mixed $default value
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->exists($key) ? $_SESSION[$this->name][$key] : $default;
    }

    /**
     * Check if session has the given key.
     * 
     * @param  string $key
     * @return boolean
     */
    public function exists($key)
    {
        return isset($_SESSION[$this->name][$key]);
    }

    /**
     * Put value with the given key to the session.
     * 
     * @param  string $key
     * @param  mixed $value
     * @return void
     */
    public function put($key, $value)
    {
        $_SESSION[$this->name][$key] = $value; 
    }

    /**
     * Remove item from session.
     * 
     * @param  string $key
     * @return void
     */
    public function forget($key)
    {
        if($this->exists($key)) {
           unset($_SESSION[$this->name][$key]);
        }
    }

    /**
     * Clear session from all items.
     * 
     * @return void
     */
    public function clear()
    {
        unset($_SESSION[$this->name]);
    }
}