<?php

namespace App\Controllers;

use App\Models\Task;
use Core\Http\Request;
use Core\Http\Response;
use Core\Database\Builder;
use App\Models\Image\Image;
use Core\File\UploadedFile;
use Core\Validator\Validator;
use App\Models\Image\ImageHandler;

class ImageController
{
    /**
     * @var Request
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
        $this->request = new Request;
        $this->builder = new Builder;
    }

    /**
     * Attach image to the task.
     * 
     * @return Response
     */
    public function store($id)
    {
        $uploadedImage = new UploadedFile($_FILES['image']);
        
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