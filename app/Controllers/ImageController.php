<?php

namespace App\Controllers;

use App\Models\Task;
use Core\Http\Response;
use App\Models\Image\Image;
use Core\Validator\Validator;
use App\Controllers\Controller;
use App\Models\Image\ImageHandler;

class ImageController extends Controller
{
    /**
     * Attach image to the task.
     * 
     * @return Response
     */
    public function store($id)
    {
        $uploadedImage = $this->request->input('image');
        
        $validator = Validator::validate(['image' => $uploadedImage], [
            'image' => ['required', ['mimes' => 'jpeg,jpg,gif,png'], ['max' => '2048']]
        ]);

        if ($validator->failed()) {
            return Response::redirect("/tasks")->withErrors($validator->getErrors());
        }

        $image = Image::createFromPath($uploadedImage->getPath());
        $path = (new ImageHandler($image))->resize()->save();

        if (! $path) {
            return Response::redirect("/tasks")
                ->withErrors(['image', 'Could not recieve path of the image']);
        }

        $this->builder->table('tasks')->where('id', '=', $id)->update([
            'image' => $path
        ]);

        return Response::redirect("/tasks");
    }
}