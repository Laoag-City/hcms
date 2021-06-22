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
			<div class="sixteen wide column center aligned">
				<form id="pre-renew-form" method="GET" action="{{ url()->current() }}" class="ui form {{ $errors->any() ? 'error' : 'success' }}">
					<br>

					<div class="fields">
						<div class="four wide field"></div>

						<div class="eight wide field">
							<label>Permit Owner Name:</label>
							<div class="ui fluid action input">
								<input type="text" name="search" placeholder="Permit Owner Name" value="{{ Request::input('search') }}">
								<button class="ui button">Search</button>
							</div>
						</div>
					</div>

					@if($searches)
						@if($errors->has('password'))
							<div class="ui error message">
								<div class="header">
									Whoops! Something went wrong.
								</div>

								<div class="ui divider"></div>
								<div>
									<i class="pointing right icon"></i>
									{{ $errors->first('password') }}
								</div>
								
							</div>
						@endif

						<h3 style="text-align: left;">Search results for <u>{{ Request::input('search') }}</u></h3>

						<table class="ui striped selectable center aligned structured celled padded table">
							<thead>
								<tr>
									<th>Name</th>
									<th class="collapsing">Sanitary Permit No.</th>
									<th>Establishment Type</th>
									<th>Address</th>
									<th class="collapsing">Expired</th>
									<th class="collapsing">Issuance Date</th>
									<th class="collapsing">Expiration Date</th>
									<th class="collapsing">Renew</th>
									<th class="collapsing">Delete</th>
								</tr>
							</thead>

							<tbody>
								@foreach($searches as $search)
									@foreach($search->sanitary_permits as $sp)
										@php
											$expired = $sp->checkIfExpired();
										@endphp

										<tr>
											<td>{{ $search instanceof App\Applicant ? $search->formatName() : $search->business_name }}</td>
											<td>{{ $sp->sanitary_permit_number }}</td>
											<td>{{ $sp->establishment_type }}</td>
											<td>{{ $sp->address }}</td>
											@if($expired)
												<td class="error">Yes</td>
											@else
												<td>No</td>
											@endif
											<td>{{ $sp->issuance_date }}</td>
											<td>{{ $sp->expiration_date }}</td>

											<td>
												<input type="radio" name="id" value="{{ $sp->sanitary_permit_id }}" {{ Request::input('id') != $sp->sanitary_permit_id ?: 'checked'}}>
											</td>

											<td>
												<button type="button" class="ui mini red delete button" data-id="{{ $sp->sanitary_permit_id }}">Remove</button>
											</td>
										</tr>
									@endforeach
								@endforeach
							</tbody>
						</table>
					@endif
				</form>
			</div>

			@if($sanitary_permit)
				<div class="fourteen wide column center aligned">
					<h3 class="ui header">
						Renew Sanitary Permit Form
					</h3>

					<br>

					<div style="overflow: auto;">
						<div style="float: left;"><!--nested columns-->
							<h4>
								<i class="caret right icon"></i>
								<span style="font-weight: normal;">Name:</span> 
								<u>
									{{	$sanitary_permit instanceof App\Applicant 
											? $sanitary_permit->applicant->formatName()
											: $sanitary_permit->business->business_name 
									}}
								</u>
							</h4>
						</div>

						<div style="float: right;">
							<h4>
								<i class="caret right icon"></i>
								<span style="font-weight: normal;">Sanitary Permit Number:</span> 
								<u>{{ $sanitary_permit->sanitary_permit_number }}</u>
							</h4>
						</div>
					</div>

					<br>

					<form method="POST" action="{{ url()->full() }}" class="ui form text_center {{ $errors->any() ? 'error' : 'success' }}">
						{{ csrf_field() }}
						{{ method_field('PUT') }}

						@if(session('success') != NULL)
							<div class="ui success message">
								<div class="header">{{ session('success')['header'] }}</div>

								<p>{{ session('success')['message'] }}</p>
							</div>
						@endif

						<br>
						
						<div class="fields">
							<div class="four wide field"></div>

							@php
								if($sanitary_permit->applicant_id != null)
								{
									$switch_to_label = 'Change to Business';
									$switch_value = 'business';
								}

								else
								{
									$switch_to_label = 'Change to individual Client';
									$switch_value = 'individual';
								}
							@endphp

							<div id="switch_permit_type_field" class="eight wide inline field{!! !$errors->has('permit_type') ? '"' : ' error" data-content="' . $errors->first('permit_type') . '" data-position="top center"' !!}>
								<div class="ui checkbox">
									<label><b>{{ $switch_to_label }}</b></label>
									<input type="checkbox" name="permit_type" value="{{ $switch_value }}" {{ old('permit_type') == $switch_value ? 'checked' : '' }}>
								</div>
							</div>
						</div>

						<br>

						@php
							if($sanitary_permit->applicant_id != null)
							{
								$first_name = old('first_name') ? old('first_name') : $sanitary_permit->applicant->first_name;
								$middle_name = old('middle_name') ? old('middle_name') : $sanitary_permit->applicant->middle_name;
								$last_name = old('last_name') ? old('last_name') : $sanitary_permit->applicant->last_name;
								$suffix_name = old('suffix_name') ? old('suffix_name') : $sanitary_permit->applicant->suffix_name;
								$age = old('age') ? old('age') : $sanitary_permit->applicant->age;
								$gender = old('gender') ? old('gender') : $sanitary_permit->applicant->gender;

								$business_name = old('business_name');
							}

							else
							{
								$first_name = old('first_name');
								$middle_name = old('middle_name');
								$last_name = old('last_name');
								$suffix_name = old('suffix_name');
								$age = old('age');
								$gender = old('gender');

								$business_name = old('business_name') ? old('business_name') : $sanitary_permit->business->business_name;
							}
						@endphp

						<div class="fields field_individual">
							<div class="six wide field
							{!! !$errors->has('first_name') ? '"' : ' error" data-content="' . $errors->first('first_name') . '" data-position="top center"' !!}>
					    		<label>First Name:</label>
					    		<input type="text" name="first_name" value="{{ $first_name }}" class="field_individual" placeholder="First Name">
					    	</div>

					    	<div class="four wide field
					    	{!! !$errors->has('middle_name') ? '"' : ' error" data-content="' . $errors->first('middle_name') . '" data-position="top center"' !!}>
					    		<label>Middle Name:</label>
					    		<input type="text" name="middle_name" value="{{ $middle_name }}" class="field_individual" placeholder="Middle Name">
					    	</div>

					    	<div class="four wide field
					    	{!! !$errors->has('last_name') ? '"' : ' error" data-content="' . $errors->first('last_name') . '" data-position="top center"' !!}>
					    		<label>Last Name:</label>
					    		<input type="text" name="last_name" value="{{ $last_name }}" class="field_individual" placeholder="Last Name">
					    	</div>

					    	<div class="two wide field
					    	{!! !$errors->has('suffix_name') ? '"' : ' error" data-content="' . $errors->first('suffix_name') . '" data-position="top center"' !!}>
					    		<label>Suffix:</label>
					    		<select name="suffix_name" class="field_individual">
									<option value=""></option>
									<option value="Jr." {{ $suffix_name != 'Jr.' ?: 'selected' }}>Jr.</option>
									<option value="Sr." {{ $suffix_name != 'Sr.' ?: 'selected' }}>Sr.</option>
									<option value="I" {{ $suffix_name != 'I' ?: 'selected' }}>I</option>
									<option value="II" {{ $suffix_name != 'II' ?: 'selected' }}>II</option>
									<option value="III" {{ $suffix_name != 'III' ?: 'selected' }}>III</option>
									<option value="IV" {{ $suffix_name != 'IV' ?: 'selected' }}>IV</option>
									<option value="V" {{ $suffix_name != 'V' ?: 'selected' }}>V</option>
									<option value="VI" {{ $suffix_name != 'VI' ?: 'selected' }}>VI</option>
									<option value="VII" {{ $suffix_name != 'VII' ?: 'selected' }}>VII</option>
									<option value="VIII" {{ $suffix_name != 'VIII' ?: 'selected' }}>VIII</option>
									<option value="IX" {{ $suffix_name != 'IX' ?: 'selected' }}>IX</option>
									<option value="X" {{ $suffix_name != 'X' ?: 'selected' }}>X</option>
								</select>
					    	</div>
						</div>

						<br>

						<div class="fields field_individual">
							<div class="five wide field"></div>

							<div class="field_individual three wide field
							{!! !$errors->has('age') ? '"' : ' error" data-content="' . $errors->first('age') . '" data-position="top center"' !!}>
								<label>Age:</label>
								<input type="number" name="age" class="field_individual" value="{{ $age }}" min="">
							</div>
							
							<div class="field_individual three wide field
							{!! !$errors->has('gender') ? '"' : ' error" data-content="' . $errors->first('gender') . '" data-position="top center"' !!}>
								<label>Gender:</label>
								<select name="gender" class="field_individual">
									<option value=""></option>
									<option value="1" {{ (string)$gender != '1' ?: 'selected' }}>Male</option>
									<option value="0" {{ (string)$gender != '0' ?: 'selected' }}>Female</option>
								</select>
							</div>
						</div>

						<div class="fields field_business">
							<div class="four wide field"></div>

							<div class="eight wide field
							{!! !$errors->has('business_name') ? '"' : ' error" data-content="' . $errors->first('business_name') . '" data-position="top center"' !!}>
					    		<label>Business Name:</label>
					    		<input type="text" name="business_name" value="{{ $business_name }}" class="field_business" placeholder="Business Name">
					    	</div>
						</div>
						
						<br>

						<div class="fields">
							<div class="four wide field"></div>

							<div class="eight wide field
							{!! !$errors->has('establishment_type') ? '"' : ' error" data-content="' . $errors->first('establishment_type') . '" data-position="top center"' !!}>
					    		<label>Establishment Type:</label>
					    		<input type="text" name="establishment_type" value="{{ old('establishment_type') ? old('establishment_type') : $sanitary_permit->establishment_type }}" class="dynamic_input" placeholder="Establishment Type">
					    	</div>
						</div>

						<br>

						<div class="fields">
					    	<div class="eight wide field
					    	{!! !$errors->has('address') ? '"' : ' error" data-content="' . $errors->first('address') . '" data-position="top center"' !!}>
					    		<label>Address:</label>
					    		<input type="text" name="address" value="{{ old('address') ? old('address') : $sanitary_permit->address }}" class="dynamic_input" placeholder="Address">
					    	</div>

					    	<div class="four wide field{!! !$errors->has('date_of_issuance') ? '"' : ' error" data-content="' . $errors->first('date_of_issuance') . '" data-position="top center"' !!}>
					    		<label>Date of Issuance:</label>
					    		<input type="date" name="date_of_issuance" value="{{ old('date_of_issuance') ? old('date_of_issuance') : $sanitary_permit->dateToInput('issuance_date') }}" class="dynamic_input">
					    	</div>

					    	<div class="four wide field{!! !$errors->has('date_of_expiration') ? '"' : ' error" data-content="' . $errors->first('date_of_expiration') . '" data-position="top center"' !!}>
					    		<label>Date of Expiration:</label>
					    		<input type="date" name="date_of_expiration" value="{{ $sanitary_permit->dateToInput('expiration_date') }}" class="dynamic_input" readonly="true">
					    	</div>
						</div>

						<br>

						<div class="fields">
							<div class="four wide field"></div>

					    	<div class="eight wide field
						    	{!! !$errors->has('sanitary_inspector') ? '"' : ' error" data-content="' . $errors->first('sanitary_inspector') . '" data-position="top center"' !!}>
					    		<label>Sanitary Inspector:</label>
					    		<input type="text" name="sanitary_inspector" value="{{ old('sanitary_inspector') ? old('sanitary_inspector') : $sanitary_permit->sanitary_inspector }}" class="dynamic_input" placeholder="Sanitary Inspector">
					    	</div>
						</div>

						<div class="field">
							<button type="submit" id="update_button" class="ui fluid inverted blue button">
								Update
							</button>
						</div>
					</form>
				</div>
			@endif
		</div>
	</div>
</div>
@endsection

@section('sub_custom_js')

<script src="{{ mix('/js/renew_sanitary_permit.js') }}"></script>

@include('commons.delete_modal')

@endsection