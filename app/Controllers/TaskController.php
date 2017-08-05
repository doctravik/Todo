<?php

namespace App\Controllers;

use Core\Container;
use Core\Http\Response;

class TaskController
{
    public function index()
    {
        return Response::view('tasks/index');
    }
}