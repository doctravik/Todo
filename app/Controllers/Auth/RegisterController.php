<?php

namespace App\Controllers\Auth;

use App\Models\User;
use Core\Http\Response;
use Core\Validator\Validator;
use App\Controllers\Controller;

class RegisterController extends Controller
{
    /**
     * Show register user form.
     *
     * @return Response
     */
    public function showRegisterForm()
    {
        return Response::view('auth/register');
    }

    /**
     * Save user in the db.
     *
     * @return Response
     */
    public function register()
    {
        $attributes = $this->request->only(['username', 'email', 'password']);

        $validator = Validator::validate($attributes, [
            'username' => ['required', ['unique' => 'users']],
            'email' => ['required', 'email', ['unique' => 'users']],
            'password' => ['required']
        ]);

        if ($validator->failed()) {
            return Response::redirect("/register")->withErrors($validator->getErrors());
        }

        if (User::register($attributes)) {
            return Response::redirect("/register")->withErrors([
                'username' => ['Could not save user.']
            ]);
        }

        return Response::redirect("/register")->withSuccess([
            'message' => "User was successfully created"
        ]);
    }
}
