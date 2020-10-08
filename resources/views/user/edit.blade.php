@extends('layouts.authenticated')

@section('sub_content')

<div class="sixteen wide column center aligned">
	<div class="ui attached message">
		<h2 class="ui header">
			Edit User
		</h2>
	</div>

	<div class="ui attached fluid segment">
		<div class="ui stackable centered grid">
			<div class="six wide column">
				<form action="{{ url()->current() }}" method="POST" class="ui form segment center aligned {{ $errors->any() ? 'error' : 'success' }}">
					{{ csrf_field() }}
					{{ method_field('PUT')}}

					@if(session('success') != NULL)
						<div class="ui success message">
							<div class="header">{{ session('success')['header'] }}</div>

							<p>{{ session('success')['message'] }}</p>
						</div>
					@endif

					<div class="field{!! !$errors->has('username') ? '"' : ' error" data-content="' . $errors->first('username') . '" data-position="top center"' !!}>
						<label>Username:</label>
						<input type="text" name="username" value="{{ old('username') != null ? old('username') : $user->username }}">
					</div>

					<div class="field{!! !$errors->has('password') ? '"' : ' error" data-content="' . $errors->first('password') . '" data-position="top center"' !!}>
						<label>Password:</label>
						<input type="password" name="password" value="{{ old('password') }}">
					</div>

					<div class="field{!! !$errors->has('password_confirmation') ? '"' : ' error" data-content="' . $errors->first('password_confirmation') . '" data-position="top center"' !!}>
						<label>Confirm Password:</label>
						<input type="password" name="password_confirmation" value="{{ old('password_confirmation') }}">
					</div>

					<div class="field">
						<button type="submit" class="ui fluid green button">Edit User</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection

@section('sub_custom_js')

<script>
	$('.field').popup();
</script>

@endsection