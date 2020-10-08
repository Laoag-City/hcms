<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    protected $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function getOrCreateUser()
	{
		if($this->request->isMethod('get'))
		{
			return view('user.index', [
				'title' => 'Users',
				'users' => User::where('admin', '!=', '1')->get()
			]);
		}

		elseif($this->request->isMethod('post'))
		{
			$this->create_edit_logic();

			return back()->with('success', ['header' => 'User added successfully!', 'message' => "New user's credentials are {$this->request->username} (username) and {$this->request->password} (password)."]);
		}

		abort('405');
	}

	public function editOrDeleteUser(User $user)
	{
		if($this->request->isMethod('get'))
		{
			return view('user.edit', [
				'title' => 'Edit User',
				'user' => $user
			]);
		}

		elseif($this->request->isMethod('put'))
		{
			$this->create_edit_logic($user);

			return back()->with('success', ['header' => 'User edited successfully!', 'message' => "Updated user's credentials are {$this->request->username} (username) and {$this->request->password} (password)."]);
		}

		elseif($this->request->isMethod('delete'))
		{
			$user->delete();
			return back();
		}

		abort('405');
	}

	private function create_edit_logic($user = null)
	{
		$this->validate($this->request, [
			'username' => 'bail|required|alpha_dash|max:15',
			'password' => 'bail|required|min:6|confirmed',
			'password_confirmation' => 'bail|required'
		]);

		$user = $user != null ? $user : new User;
		$user->username = $this->request->username;
		$user->password = bcrypt($this->request->password);
		$user->save();
	}
}
