<?php

namespace App\Controllers;

use Core\Auth\Auth;
use App\Models\Task;
use Core\Http\Response;
use App\Filters\TaskFilter;
use App\Models\Image\Image;
use Core\Validator\Validator;
use App\Controllers\Controller;
use App\Models\Image\ImageHandler;
use Core\Exceptions\NotAuthorisedException;

class TaskController extends Controller
{
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
        $users = $this->builder->table('users')->get();

        return Response::view("tasks/create", compact('users'));
    }

    /**
     * Store task in database.
     * 
     * @return Response
     */
    public function store()
    {
        $attributes = $this->request->only(['content', 'user_id', 'image']);

        $validator = Validator::validate($attributes, [
            'content' => ['required'],
            'user_id' => ['required', ['exists' => 'users:id']],
            'image' => ['maybeRequired', ['mimes' => 'jpeg,jpg,gif,png'], ['max' => '2048']]
        ]);

        if ($validator->failed()) {
            return Response::redirect("/tasks/create")->withErrors($validator->getErrors());
        }

        if( $this->request->input('image')->getPath()) {
            $image = Image::createFromPath($this->request->input('image')->getPath());
            $path = (new ImageHandler($image))->resize()->save();
        }

        Task::create(array_merge($attributes, [
            'image' => $path ?? null
        ]));

        return Response::redirect("/tasks")->withSuccess([
            'message' => 'Task was successfully created'
        ]);
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
            return Response::redirect("/tasks")->withErrors($validator->getErrors());
        }

        $this->builder->table('tasks')->where('id', '=', $id)->update($attributes);

        return Response::redirect("/tasks")->withSuccess([
            'message' => 'Content of the task was successfully updated'
        ]);
    }
}