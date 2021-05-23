@extends('layouts.main')

@section('custom_css')
	@yield('sub_custom_css')
@endsection

@section('content')
	@php
		$current_url = request()->path();
	@endphp

	<div id="main_menu" class="ui fluid stackable menu">
		<div class="ui container">
			<div class="ui simple dropdown item">
				Health Certificate
				<i class="dropdown icon"></i>

				<div class="menu">
					<a href="{{ url('/') }}" class="item">New Health Certificate</a>
					<a href="{{ url('health_certificate/existing_client') }}" class="item">Add Health Certificate To Existing Client</a>
					<a href="" class="item">Renew A Health Certificate</a>
				</div>
			</div>

			<div class="ui simple dropdown item">
				Sanitary Permit
				<i class="dropdown icon"></i>

				<div class="menu">
					<a href="{{ url('sanitary_permit') }}" class="item">New Sanitary Permit</a>
					<a href="" class="item">Add Sanitary Permit To Existing Client/Business</a>
					<a href="" class="item">Renew A Sanitary Permit</a>
				</div>
			</div>

			<div class="right menu">
				<form action="{{ url('search') }}" class="item">
					<div class="ui action input">
						<input type="text" name="q" placeholder="Search Clients">
						<button class="ui icon button">
    						<i class="search icon"></i>
  						</button>
					</div>
				</form>

				@can('is-admin')
					<div class="ui simple dropdown item">
						Admin Controls
						<i class="dropdown icon"></i>

						<div class="menu">
							<a href="{{ url('users') }}" class="item">User Administration</a>
						</div>
					</div>
				@endcan

				<a class="item" href="#" onclick="event.preventDefault(); document.getElementById('logout_form').submit();">
					Logout
    			</a>

    			<form id="logout_form" action="{{ url('/logout') }}" method="POST" style="display: none;">
        			{{ csrf_field() }}
    			</form>
			</div>
		</div>
	</div>

	<div id="main_container" class="ui grid container">
		@yield('sub_content')
	</div>

	<div id="footer" class="ui borderless mini menu">
		<div class="item">Copyright 2020. All rights reserved.</div>

		<div class="right menu">
			<a id="about" class="item">About</a>
		</div>
	</div>
@endsection

@section('custom_js')
	@yield('sub_custom_js')

	<script src="{{ mix('/js/authenticated.js') }}"></script>

	<div id="about_modal" class="ui tiny modal text_center">
		<h2 class="ui icon header">
			<i class="help circle outline icon"></i>
			<div class="content">
				About the Developer
			</div>
		</h2>
		<div class="content">
			<h3>
				<i>
					This <u>Health Certificate Management System</u> (HCMS) is proudly<br> 
					<i class="blue code icon" title="Coded"></i> with all the 
					<i class="red heart icon" title="love"></i> in the 
					<i class="green world icon" title="world"></i> by the 
					<i class="spy icon" title="developer (Russell James Funtila Bello)"></i>.
				</i>
			</h3>
			<h4>You can contact me through the following:</h4>
			<a href="https://www.facebook.com/russelljames.bello" target="_blank"><i class="big blue facebook icon"></i> /russelljames.bello</a>
			<br><br>
			<a href="#"><i class="big red mail icon"></i> russellbello24@gmail.com</a>
			<br><br>
			<a href="#"><i class="big black address book outline icon"></i> 09386573424</a>
		</div>
		<div class="actions">
			<div class="ui grey deny button">
				Close
			</div>
		</div>
	</div>
@endsection