@extends('layouts.authenticated')

@section('sub_content')

<div class="sixteen wide column center aligned">
	<div class="ui attached message">
		<h2 class="ui header">
			User Administration
		</h2>
	</div>

	<div class="ui attached fluid segment">
		<div class="ui stackable grid">
			<div class="ten wide column">
				<h3>Users</h3>

				<table class="ui center aligned striped selectable celled table">
					<thead>
						<tr>
							<th>Username</th>
							<th></th>
							<th></th>
						</tr>
					</thead>

					<tbody>
						@foreach($users as $user)
							<tr>
								<td>{{ $user->username }}</td>
								<td class="collapsing">
									<a href="{{ url("users/{$user->user_id}") }}" class="ui mini yellow button">Edit</a>
								</td>
								<td class="collapsing">
									<button class="ui mini red delete button" data-id="{{ $user->user_id }}">Remove</button>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>
			</div>

			<div class="six wide column">
				<h3>Add New User</h3>

				<form method="POST" action="{{ url()->current() }}" class="ui form segment {{ $errors->any() ? 'error' : 'success' }}">
					{{ csrf_field() }}

					@if(session('success') != NULL)
						<div class="ui success message">
							<div class="header">{{ session('success')['header'] }}</div>

							<p>{{ session('success')['message'] }}</p>
						</div>
					@endif

					<div class="field{!! !$errors->has('username') ? '"' : ' error" data-content="' . $errors->first('username') . '" data-position="top center"' !!}>
						<label>Username:</label>
						<input type="text" name="username" value="{{ old('username') }}" required>
					</div>

					<div class="field{!! !$errors->has('password') ? '"' : ' error" data-content="' . $errors->first('password') . '" data-position="top center"' !!}>
						<label>Password:</label>
						<input type="password" name="password" value="{{ old('password') }}" required>
					</div>

					<div class="field{!! !$errors->has('password_confirmation') ? '"' : ' error" data-content="' . $errors->first('password_confirmation') . '" data-position="top center"' !!}>
						<label>Confirm Password:</label>
						<input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}" required>
					</div>

					<div class="field">
						<button type="submit" class="ui fluid green button">Add User</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('sub_custom_js')
<script>var delete_url = '{{ url()->current() }}';</script>
<script src="{{ mix('/js/user_administration.js') }}"></script>

<div id="delete_modal" class="ui mini modal">
	<i class="close icon"></i>
	<div class="header">
		Remove User
	</div>
	<div class="content">
		<p>Are you sure you want to remove the selected user?</p>
	</div>
	<div class="actions">
		<div class="ui black deny button">
			No
		</div>
		<form id="delete_form" method="POST" style="display: inline;">
			{{ csrf_field() }}
			{{ method_field('DELETE') }}

			<button class="ui red button" type="submit">Yes</button>
		</form>
	</div>
</div>

@endsection