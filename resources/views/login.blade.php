@extends('layouts.main')

@section('content')

<div class="ui raised very padded text container center aligned segment" style="top: 50%; transform: translateY(-50%);">
	<h2 class="ui icon header">
		<i class="id card outline icon"></i>
		<div class="content">
			HEALTH CERTIFICATE MANAGEMENT SYSTEM
		</div>
	</h2>

	<div class="ui divider"></div>

	<form action="{{ url()->current() }}" method="POST" class="ui form {{ $errors->any() ? 'error' : 'success' }}">
		{{ csrf_field() }}

		@include('commons.error_success_message')

		<div class="ten wide field block_center {{ !$errors->has('username') ?: 'error' }}">
			<label>Username</label>
			<input type="text" name="username" value="{{ old('username') }}" placeholder="Username" autofocus>
		</div>
  
		<div class="ten wide field block_center {{ !$errors->has('password') ?: 'error' }}">
			<label>Password</label>
			<input type="password" name="password" value="{{ old('password') }}" placeholder="Password">
		</div>

		<br>

		<div class="ten wide field block_center">
			<button class="ui fluid inverted green button" type="submit">SIGN IN</button>
		</div>
	</form>
</div>

@endsection