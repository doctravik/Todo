<?php

namespace Core;

use ArrayAccess;

class Container implements ArrayAccess
{
    /**
     * @var Container
     */
    private static $instance;

    /**
     * @var array
     */
    private $registry = [];
    
    /**
     * Private construstor for the singleton.
     */
    private function __construct() {}

    /**
     * Getter for the instance.
     * 
     * @return Container
     */
    public function instance()
    {
        if (! self::$instance ) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Load configurations.
     * 
     * @param  array  $config
     * @return void
     */
    public function init(array $config = [])
    {
        foreach ($config as $key => $item) {
            $this->offsetSet($key, $item);
        }
    }

    /**
     * Bind dependency to the container.
     * 
     * @param string $offset
     * @param mix $value
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        $this->registry[$offset] = $value;
    }

    /**
     * Get dependency from the container.
     * 
     * @param string $offset
     * @return mixed
     */
    public function offsetGet($offset)
    {
        return $this->has($offset) ? $this->registry[$offset] : null;
    }

    /**
     * Remove dependency from the container.
     * 
     * @param string $offset
     * @return void
     */
    public function offsetUnset($offset)
    {
        if ($this->has($offset)) {
            unset($this->registry[$offset]);
        }
    }

    /**
     * Check if container has the given dependency.
     * 
     * @param string $offset
     * @return boolean
     */
    public function offsetExists($offset)
    {
        return isset($this->registry[$offset]);
    }

    /**
     * Alias to the offsetExists method.
     * 
     * @param string $offset
     * @return boolean
     */
    public function has($offset)
    {
        return $this->offsetExists($offset);
    }

    /**
     * Easy access to the dependency.
     * 
     * @param  string $property
     * @return mixed
     */
    public function __get($property)
    {
        return $this->offsetGet($property);
    }
}