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

					<div class="fields field_individual">
						<div class="six wide field
						{!! !$errors->has('first_name') ? '"' : ' error" data-content="' . $errors->first('first_name') . '" data-position="top center"' !!}>
				    		<label>First Name:</label>
				    		<input type="text" name="first_name" value="{{ old('first_name') }}" class="field_individual" placeholder="First Name">
				    	</div>

				    	<div class="four wide field
				    	{!! !$errors->has('middle_name') ? '"' : ' error" data-content="' . $errors->first('middle_name') . '" data-position="top center"' !!}>
				    		<label>Middle Name:</label>
				    		<input type="text" name="middle_name" value="{{ old('middle_name') }}" class="field_individual" placeholder="Middle Name">
				    	</div>

				    	<div class="four wide field
				    	{!! !$errors->has('last_name') ? '"' : ' error" data-content="' . $errors->first('last_name') . '" data-position="top center"' !!}>
				    		<label>Last Name:</label>
				    		<input type="text" name="last_name" value="{{ old('last_name') }}" class="field_individual" placeholder="Last Name">
				    	</div>

				    	<div class="two wide field
				    	{!! !$errors->has('suffix_name') ? '"' : ' error" data-content="' . $errors->first('suffix_name') . '" data-position="top center"' !!}>
				    		<label>Suffix:</label>
				    		<select name="suffix_name" class="field_individual">
								<option value=""></option>
								<option value="Jr." {{ old('suffix_name') != 'Jr.' ?: 'selected' }}>Jr.</option>
								<option value="Sr." {{ old('suffix_name') != 'Sr.' ?: 'selected' }}>Sr.</option>
								<option value="I" {{ old('suffix_name') != 'I' ?: 'selected' }}>I</option>
								<option value="II" {{ old('suffix_name') != 'II' ?: 'selected' }}>II</option>
								<option value="III" {{ old('suffix_name') != 'III' ?: 'selected' }}>III</option>
								<option value="IV" {{ old('suffix_name') != 'IV' ?: 'selected' }}>IV</option>
								<option value="V" {{ old('suffix_name') != 'V' ?: 'selected' }}>V</option>
								<option value="VI" {{ old('suffix_name') != 'VI' ?: 'selected' }}>VI</option>
								<option value="VII" {{ old('suffix_name') != 'VII' ?: 'selected' }}>VII</option>
								<option value="VIII" {{ old('suffix_name') != 'VIII' ?: 'selected' }}>VIII</option>
								<option value="IX" {{ old('suffix_name') != 'IX' ?: 'selected' }}>IX</option>
								<option value="X" {{ old('suffix_name') != 'X' ?: 'selected' }}>X</option>
							</select>
				    	</div>
					</div>

					<div class="fields field_business">
						<div class="four wide field"></div>

						<div class="eight wide field
						{!! !$errors->has('business_name') ? '"' : ' error" data-content="' . $errors->first('business_name') . '" data-position="top center"' !!}>
				    		<label>Business Name:</label>
				    		<input type="text" name="business_name" value="{{ old('business_name') }}" class="field_business" placeholder="Business Name">
				    	</div>
					</div>


					<div class="fields field_individual">
						<div class="five wide field"></div>

						<div class="field_individual three wide field
						{!! !$errors->has('age') ? '"' : ' error" data-content="' . $errors->first('age') . '" data-position="top center"' !!}>
							<label>Age:</label>
							<input type="number" name="age" class="field_individual" value="{{ old('age') }}" min="">
						</div>
						
						<div class="field_individual three wide field
						{!! !$errors->has('gender') ? '"' : ' error" data-content="' . $errors->first('gender') . '" data-position="top center"' !!}>
							<label>Gender:</label>
							<select name="gender" class="field_individual">
								<option value=""></option>
								<option value="1" {{ (string)old('gender') != '1' ?: 'selected' }}>Male</option>
								<option value="0" {{ (string)old('gender') != '0' ?: 'selected' }}>Female</option>
							</select>
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

					<button class="ui fluid inverted blue button">
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