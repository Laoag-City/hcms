@extends('layouts.authenticated')

@section('sub_content')
<div class="sixteen wide column center aligned">
	<div class="ui attached message">
		<h2 class="ui header">
			{{ $title }}
		</h2>
	</div>

	<div class="ui attached segment">
		<div class="ui stackable centered grid">
			<div class="fourteen wide column center aligned">
				<form id="sanitary_permit_form" method="POST" action="{{ url()->current() }}" class="ui form {{ $errors->any() ? 'error' : 'success' }}">
					{{ csrf_field() }}

					<input type="hidden" name="id" class="dynamic_on_search" value="{{ old('id') }}">
					
					<br>

					<div class="fields">
						<div class="four wide field"></div>

						<div class="four wide inline field{!! !$errors->has('permit_type') ? '"' : ' error" data-content="' . $errors->first('permit_type') . '" data-position="top center"' !!}>
							<div class="ui toggle checkbox">
								<label><b>Individual Client</b></label>
								<input type="radio" name="permit_type" value="individual" {{ old('permit_type') == 'individual' ? 'checked' : '' }}>
							</div>
						</div>

						<div class="four wide inline field{!! !$errors->has('permit_type') ? '"' : ' error" data-content="' . $errors->first('permit_type') . '" data-position="top center"' !!}>
							<div class="ui toggle checkbox">
								<label><b>Business</b></label>
								<input type="radio" name="permit_type" value="business" {{ old('permit_type') == 'business' ? 'checked' : '' }}>
							</div>
						</div>
					</div>

					<br>

					<br>

					<div class="fields">
						<div class="three wide field"></div>

						<div id="searchPermitOwner" style="display: none" class="ten wide field ui fluid search{!! !$errors->has('permit_owner') 
							? '" data-content="Type a client\'s name and choose from the suggestions below."' 
							: ' error" data-content="' . $errors->first('permit_owner') . '"' !!} 
							data-position="top center">
								<label>Search Sanitary Permit Owner:</label>
								<input class="prompt" type="text" name="permit_owner" value="{{ old('permit_owner') }}" placeholder="Search Sanitary Permit Owner" required="">
								<div class="results"></div>
						</div>
					</div>

					<br>
					<br>

					<div class="fields field_individual">
						<div class="six wide field
						{!! !$errors->has('first_name') ? '"' : ' error" data-content="' . $errors->first('first_name') . '" data-position="top center"' !!}>
				    		<label>First Name:</label>
				    		<input type="text" name="first_name" value="{{ old('first_name') }}" class="field_individual" placeholder="First Name" readonly="">
				    	</div>

				    	<div class="four wide field
				    	{!! !$errors->has('middle_name') ? '"' : ' error" data-content="' . $errors->first('middle_name') . '" data-position="top center"' !!}>
				    		<label>Middle Name:</label>
				    		<input type="text" name="middle_name" value="{{ old('middle_name') }}" class="field_individual" placeholder="Middle Name" readonly="">
				    	</div>

				    	<div class="four wide field
				    	{!! !$errors->has('last_name') ? '"' : ' error" data-content="' . $errors->first('last_name') . '" data-position="top center"' !!}>
				    		<label>Last Name:</label>
				    		<input type="text" name="last_name" value="{{ old('last_name') }}" class="field_individual" placeholder="Last Name" readonly="">
				    	</div>

				    	<div class="two wide field
				    	{!! !$errors->has('suffix_name') ? '"' : ' error" data-content="' . $errors->first('suffix_name') . '" data-position="top center"' !!}>
				    		<label>Suffix:</label>
				    		<input type="text" name="suffix_name" value="{{ old('suffix_name') }}" class="field_individual" placeholder="Suffix Name" readonly="">
				    	</div>
					</div>

					<div class="fields field_business">
						<div class="four wide field"></div>

						<div class="eight wide field
						{!! !$errors->has('business_name') ? '"' : ' error" data-content="' . $errors->first('business_name') . '" data-position="top center"' !!}>
				    		<label>Business Name:</label>
				    		<input type="text" name="business_name" value="{{ old('business_name') }}" class="field_business" placeholder="Business Name" readonly="">
				    	</div>
					</div>


					<div class="fields field_individual">
						<div class="five wide field"></div>

						<div class="field_individual three wide field
						{!! !$errors->has('age') ? '"' : ' error" data-content="' . $errors->first('age') . '" data-position="top center"' !!}>
							<label>Age:</label>
							<input type="number" name="age" class="field_individual" value="{{ old('age') }}" min="" readonly="">
						</div>
						
						<div class="field_individual three wide field
						{!! !$errors->has('gender') ? '"' : ' error" data-content="' . $errors->first('gender') . '" data-position="top center"' !!}>
							<label>Gender:</label>
							<input type="text" name="gender" value="{{ old('gender') }}" class="field_individual" placeholder="Gender" readonly="">
						</div>
					</div>

					<br>

					<div class="fields">
						<div class="four wide field"></div>

						<div class="eight wide field
						{!! !$errors->has('establishment_type') ? '"' : ' error" data-content="' . $errors->first('establishment_type') . '" data-position="top center"' !!}>
				    		<label>Establishment Type:</label>
				    		<input type="text" name="establishment_type" value="{{ old('establishment_type') }}" placeholder="Establishment Type">
				    	</div>
					</div>

					<br>

					<div class="fields">
				    	<div class="eight wide field
				    	{!! !$errors->has('address') ? '"' : ' error" data-content="' . $errors->first('address') . '" data-position="top center"' !!}>
				    		<label>Address:</label>
				    		<input type="text" name="address" value="{{ old('address') }}" placeholder="Address">
				    	</div>

				    	<div class="four wide field{!! !$errors->has('date_of_issuance') ? '"' : ' error" data-content="' . $errors->first('date_of_issuance') . '" data-position="top center"' !!}>
				    		<label>Date of Issuance:</label>
				    		<input type="date" name="date_of_issuance" value="{{ old('date_of_issuance') ? old('date_of_issuance') : date('Y-m-d', strtotime('now')) }}">
				    	</div>

				    	<div class="four wide field{!! !$errors->has('date_of_expiration') ? '"' : ' error" data-content="' . $errors->first('date_of_expiration') . '" data-position="top center"' !!}>
				    		<label>Date of Expiration:</label>
				    		<input type="date" name="date_of_expiration" value="{{ date('Y', strtotime('now')) . '-12-31' }}" readonly="true">
				    	</div>
					</div>

					<br>

					<div class="fields">
						<div class="four wide field"></div>

				    	<div class="eight wide field
					    	{!! !$errors->has('sanitary_inspector') ? '"' : ' error" data-content="' . $errors->first('sanitary_inspector') . '" data-position="top center"' !!}>
				    		<label>Sanitary Inspector:</label>
				    		<input type="text" name="sanitary_inspector" value="{{ old('sanitary_inspector') }}" placeholder="Sanitary Inspector">
				    	</div>
					</div>

					<br>

					<button id="submit_sanitary_permit" class="ui fluid inverted blue button">
						Create Sanitary Permit
					</button>
				</form>
			</div>
		</div>			
	</div>
</div>
@endsection

@section('sub_custom_js')
	<script src="{{ mix('/js/new_sanitary_permit.js') }}"></script>
@endsection