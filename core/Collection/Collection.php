<?php

namespace Core\Collection;

use Countable;

class Collection implements Countable
{
    /**
     * @var $array
     */
    protected $items;

    /**
     * Create an instance of the collection.
     * 
     * @param array $items
     * @return void
     */
    public function __construct($items)
    {
        $this->items = is_array($items) ? $items : [];
    }

    /**
     * Count items from collection.
     * 
     * @return integer
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * Get all items from collection.
     * 
     * @return array
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Check if the collection is empty.
     * 
     * @return boolean
     */
    public function isEmpty()
    {
        return empty($this->items);
    }

    /**
     * Get first item from collection.
     * 
     * @param  mixed $default value
     * @return mixed
     */
    public function first($default = null)
    {
        return $this->items[0] ?? $default;
    }

    /**
     * Check if the collection exists.
     * 
     * @return boolean
     */
    public function exists()
    {
        return ! empty($this->items);
    }
}