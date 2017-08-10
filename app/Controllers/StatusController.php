<?php

namespace App\Controllers;

use App\Models\Auth;
use Core\Http\Response;
use App\Controllers\Controller;
use Core\Exceptions\NotAuthorisedException;

class StatusController extends Controller
{
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

        $this->builder->table('tasks')->where('id', '=', $id)->update([
            'is_completed' => (bool) $this->request->input('is_completed') ?: 0
        ]);

        return Response::redirect("/tasks");
    }
}