<?php

namespace App\Controllers;

use Core\Container;
use App\Models\Auth;
use App\Models\Task;
use Core\Http\Response;
use Core\Database\Builder;
use App\Filters\TaskFilter;
use Core\File\UploadedFile;
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
        $attributes = $this->request->only(['sort', 'order']);

        $validator = Validator::validate($attributes, [
            'sort' => ['maybeRequired', ['in' => 'content,username,email,is_completed']],
            'order' => ['maybeRequired', ['in' => 'asc,desc']]
        ]);

        if ($validator->failed()) {
            return Response::redirect("/tasks")->withErrors($validator->getErrors());
        }

        $tasks = Task::sort(new TaskFilter)->paginate(3);

        return Response::view('tasks/index', compact('tasks'));
    }

    /**
     * Show create form for the task.
     * 
     * @return Response
     */
    public function create()
    {
        return Response::view("tasks/create");
    }

    /**
     * Store task in database.
     * 
     * @return Response
     */
    public function store()
    {
        $attributes = $this->request->only(['content', 'username','email', 'image']);

        $validator = Validator::validate($attributes, [
            'content' => ['required'],
            'image' => ['maybeRequired', ['mimes' => 'jpeg,jpg,gif,png'], ['max' => '2048']],
            'username' => ['required'],
            'email' => ['required', 'email', ['unique' => 'tasks']]
        ]);

        if ($validator->failed()) {
            return Response::redirect("/tasks/create")->withErrors($validator->getErrors());
        }

        $this->builder->table('tasks')->insert($attributes);

        return Response::redirect("/tasks");
    }

    /**
     * Show edit form for the task.
     * 
     * @return Response
     */
    // public function edit($id)
    // {
    //     if (! Auth::check()) {
    //         throw new NotAuthorisedException;
    //     }

    //     $task = $this->builder->table('tasks')->where('id', '=', $id)->get()[0];

    //     return Response::view("tasks/edit", compact('task'));
    // }

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
            return Response::redirect("/tasks")->withErrors($validator->getErrors());
        }

        $this->builder->table('tasks')->where('id', '=', $id)->update($attributes);

        return Response::redirect("/tasks");
    }
}