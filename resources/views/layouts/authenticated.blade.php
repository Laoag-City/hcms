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
			<a class="item" href="{{ url('/') }}">
				<i class="big icons" data-tooltip="Create A Health Certificate" data-position="bottom center">
					<i class="add square icon"></i>
				</i>
			</a>

			<!--<a class="item" href="{{-- url('health_certificate') --}}">
				<i class="big icons" data-tooltip="Health Certificates" data-position="bottom center">
					<i class="id card outline icon"></i>
				</i>
			</a>-->

			<a class="item" href="{{ url('applicant') }}">
				<i class="big icons" data-tooltip="Clients" data-position="bottom center">
					<i class="users icon"></i>
				</i>
			</a>

			<!--<a class="item" href="{{ url('applicant/bulk_print') }}">
				<i class="big icons" data-tooltip="Bulk-Print Health Certificates" data-position="bottom center">
					<i class="print icon"></i>
					<i class="corner address card outline icon"></i>
				</i>
			</a>-->

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
					<a class="item" href="{{ url('users') }}">
						<i class="big icons" data-tooltip="User Administration" data-position="bottom center">
							<i class="spy icon"></i>
						</i>
					</a>

					<!--<a class="item" href="{{ url('health_certificate_values') }}">
						<i class="big icons" data-tooltip="Health Certificate Values" data-position="bottom center">
							<i class="folder icon"></i>
						</i>
					</a>-->
				@endcan
    
    			<a class="item"  href="#" onclick="event.preventDefault(); document.getElementById('logout_form').submit();">
    				<i class="big icons" data-tooltip="Logout" data-position="bottom center">
						<i class="sign out icon"></i>
					</i>
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