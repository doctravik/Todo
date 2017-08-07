<?php

namespace App\Filters;

use App\Filters;

class TaskFilter extends Filter
{
    /**
     * @var array
     */
    protected $filters = ['sort'];

    /**
     * Sort tasks by attribute and order.
     * 
     * @param  string $attribute
     * @return Core\Database\Builder
     */
    protected function sort($attribute)
    {
        $order = $this->request->input('order') ?? 'asc'; 

        return $this->builder->orderBy($attribute, $order);
    }
}