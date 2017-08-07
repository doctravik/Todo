<?php

namespace App\Controllers;

use Core\Container;
use App\Models\Auth;
use Core\Http\Response;
use Core\Database\Builder;
use Core\Validator\Validator;
use Core\Exceptions\NotAuthorisedException;

class TaskController
{
    /**
     * @var Core\Http\Request
     */
    private $request;

    /**
     * @var Builder
     */
    private $builder;

    /**
     * Create instance of TaskController.
     */
    public function __construct()
    {
        $this->request = Container::instance()->request;
        $this->builder = new Builder;
    }

    /**
     * Show task's list.
     * 
     * @return Response
     */
    public function index()
    {
        $tasks = $this->builder->table('tasks')->get();

        return Response::view('tasks/index', compact('tasks'));
    }

    /**
     * Store task in database.
     * 
     * @return Response
     */
    public function store()
    {
        $attributes = $this->request->only(['content', 'username','email']);
        
        $validator = Validator::validate($attributes, [
            'content' => ['required'],
            'username' => ['required'],
            'email' => ['required', 'email', ['unique' => 'tasks']],
            // 'image' => [['mimes' => 'jpg,jpeg,png,bmp'], ['max' => '2048']]
        ]);

        if ($validator->failed()) {
            return Response::redirect("/tasks")->withErrors($validator->getErrors());
        }

        $this->builder->table('tasks')->insert($attributes);

        return Response::redirect("/tasks");
    }

    /**
     * Show edit form for the task.
     * 
     * @return Response
     */
    public function edit($id)
    {
        if (! Auth::check()) {
            throw new NotAuthorisedException;
        }

        $task = $this->builder->table('tasks')->where('id', '=', $id)->get()[0];

        return Response::view("tasks/edit", compact('task'));
    }

    /**
     * Update content of the task in the database.
     * 
     * @return Response
     */
    public function update($id)
    {
        if (! Auth::check()) {
            throw new NotAuthorisedException;
        }

        $attributes = $this->request->only(['content']);

        $validator = Validator::validate($attributes, [
            'content' => ['required', ['unique' => 'tasks']],
        ]);

        if ($validator->failed()) {
            return Response::redirect("/tasks/$id/edit")->withErrors($validator->getErrors());
        }

        $this->builder->table('tasks')->where('id', '=', $id)->update($attributes);

        return Response::redirect("/tasks/$id/edit");
    }
}