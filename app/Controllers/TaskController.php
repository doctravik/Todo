<?php

namespace App\Controllers;

use Core\Container;
use Core\Http\Response;
use Core\Database\QueryBuilder;

class TaskController
{
    /**
     * @var Core\Http\Request
     */
    private $request;

    /**
     * @var \PDO
     */
    private $db;

    public function __construct()
    {
        $container = Container::instance();
        $this->request = $container->request;
        $this->builder = new QueryBuilder($container->db);
    }

    /**
     * Show task's list.
     * 
     * @return Response
     */
    public function index()
    {
        return Response::view('tasks/index');
    }

    /**
     * Store task in database.
     * 
     * @return [type] [description]
     */
    public function store()
    {
        $attributes = $this->request->only(['content', 'username','email']);
        $this->builder->insert('tasks', $attributes);

        return Response::redirect("/tasks");
    }
}