<?php

namespace Core;

use ArrayAccess;

class Container implements ArrayAccess
{
    private $registry = [];

    public function __construct(array $items = [])
    {
        foreach ($items as $key => $item) {
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

    public function __get($property)
    {
        return $this->offsetGet($property);
    }
}