<?php

namespace App\Filters;

use Core\Container;
use Core\Http\Request;
use Core\Database\Builder;

abstract class Filter
{
    /**
     * @var Builder
     */
    protected $builder;

    /**
     * @var Request
     */
    protected $request;

    /**
     * Allowed filters.
     *
     * @var array
     */
    protected $filters;

    /**
     * Create a new instance of Filter class
     */
    public function __construct()
    {
        $this->request = Container::instance()->request;
    }

    /**
     * Apply the filters.
     *
     * @param  Builder $builder
     * @return Builder
     */
    public function apply(Builder $builder)
    {
        $this->builder = $builder;

        foreach ($this->getFilters() as $filter => $value) {
            if (method_exists($this, $filter)) {
                $this->$filter($value);
            }
        }

        return $this->builder;
    }

    /**
     * Retrieve all allowed filters from the web request.
     *
     * @return array
     */
    protected function getFilters()
    {
        return array_intersect_key($this->request->all(), array_flip($this->filters));
    }
}
