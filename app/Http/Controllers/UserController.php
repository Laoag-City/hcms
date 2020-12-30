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
		if($user == null)
		{
			$username_unique_rule = 'unique:users,username';
			$full_name_unique_rule = 'unique:users,full_name';
		}
		else
		{
			$username_unique_rule = "unique:users,username,{$user->user_id},user_id";
			$full_name_unique_rule = "unique:users,full_name,{$user->user_id},user_id";
		}

		$this->validate($this->request, [
			'username' => "bail|required|alpha_dash|max:15|$username_unique_rule",
			'full_name' => "bail|required|alpha_spaces|max:100|$full_name_unique_rule",
			'password' => 'bail|required|min:6|confirmed',
			'password_confirmation' => 'bail|required'
		]);

		$user = $user != null ? $user : new User;
		$user->username = $this->request->username;
		$user->full_name = $this->request->full_name;
		$user->password = bcrypt($this->request->password);
		$user->save();
	}
}
