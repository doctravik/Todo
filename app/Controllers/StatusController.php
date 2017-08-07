<?php

namespace App\Controllers;

use Core\Container;
use App\Models\Auth;
use Core\Http\Response;
use Core\Database\Builder;
use Core\Exceptions\NotAuthorisedException;

class StatusController
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
     * Update status of the task in the database.
     * 
     * @return Response
     */
    public function update($id)
    {
        if (! Auth::check()) {
            throw new NotAuthorisedException;
        }

        $attributes = $this->request->only(['is_completed']);

        $this->builder->table('tasks')->where('id', '=', $id)->update([
            'is_completed' => (bool) $this->request->input('is_completed') ?: 0
        ]);

        return Response::redirect("/tasks");
    }
}