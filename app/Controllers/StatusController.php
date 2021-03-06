<?php

namespace App\Controllers;

use Core\Auth\Auth;
use Core\Http\Response;
use Core\Exceptions\NotAuthorisedException;

class StatusController extends Controller
{
    /**
     * Update status of the task in the database.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        if (! Auth::check()) {
            throw new NotAuthorisedException;
        }

        $this->builder->table('tasks')->where('id', '=', $id)->update([
            'is_completed' => (bool) $this->request->input('is_completed') ?: 0
        ]);

        return Response::redirect("/tasks")->withSuccess([
            'message' => 'Status of the task was successfully updated'
        ]);
    }
}
