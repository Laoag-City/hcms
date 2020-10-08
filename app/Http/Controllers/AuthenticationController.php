<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class AuthenticationController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
    	$this->request = $request;
    }

    public function login()
    {
    	if($this->request->isMethod('get'))
    	{
    		return view('login', ['title' => 'Sign In']);
    	}

    	elseif($this->request->isMethod('post'))
    	{
    		$validator = Validator::make($this->request->all(), [
    				'username' => 'required',
    				'password' => 'required'
    			]);

            $validator->validate();

            $validator->after(function($validator) {
                if(!Auth::attempt(['username' => $this->request->username, 'password' => $this->request->password]))
                    //Since the following error is owned by username and password field and we don't want individual error messages for both fields, 
                    //just put a non-existing field name named compound_error.
                    $validator->errors()->add('compound_error', 'You entered an invalid login credential.');
            });

            $validator->validate();

    		return redirect()->intended('/');
    	}
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
