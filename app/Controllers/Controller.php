<?php

namespace App\Controllers;

use Core\Http\Request;
use Core\Database\Builder;

abstract class Controller
{
    /**
     * Web request
     *
     * @var Request
     */
    protected $request;

    /**
     * Query builder
     *
     * @var Builder
     */
    protected $builder;

    /**
     * Create instance of Controller.
     */
    public function __construct()
    {
        $this->request = new Request;
        $this->builder = new Builder;
    }
}
