<?php

namespace App\Controllers;

use Core\Container;

class TaskController
{
    /**
     * @var Core\Http\Response
     */
    private $response;

    public function __construct()
    {
        $this->response = Container::instance()->response;
    }

    public function index()
    {
        $this->response->view('tasks/index');
    }
}