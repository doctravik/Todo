<?php

namespace App\Controllers\Auth;

use App\Models\Auth;
use Core\Http\Response;
use Core\Validator\Validator;
use App\Controllers\Controller;

class LoginController extends Controller
{
    /**
     * Show login form for admin.
     * 
     * @return Response
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return Response::redirect("/tasks");            
        }

        return Response::view('auth/login');
    }

    /**
     * Login to the admin section.
     * 
     * @return Response
     */
    public function login()
    {
        $attributes = $this->request->only(['username', 'password']);
        
        $validator = Validator::validate($attributes, [
            'username' => ['required'],
            'password' => ['required']
        ]);

        if ($validator->failed()) {
            return Response::redirect("/admin")->withErrors($validator->getErrors());
        }

        if ($this->verifyCredentials($attributes) == false) {
            return Response::redirect("/admin")->withErrors([
                'username' => ['Your credentials were not verified.']
            ]);
        }

        Auth::login();

        return Response::redirect("/tasks");
    }

    /**
     * Logout from the admin section.
     * 
     * @return Response
     */
    public function logout()
    {
        Auth::logout(); 
        
        return Response::redirect("/tasks");
    }

    /**
     * Check if credentials are valid.
     * 
     * @param  array $credentials
     * @return boolean
     */
    protected function verifyCredentials($credentials)
    {
        return $credentials['username'] === 'admin' && $credentials['password'] === '123';
    }
}