@extends('layouts.authenticated')

@section('sub_content')
<div class="sixteen wide column center aligned">
	<div class="ui attached message">
		<h2 class="ui header">
			Client's Information
		</h2>
	</div>

	<form method="POST" action="{{ url()->current() }}" class="ui form attached fluid segment {{ $errors->any() ? 'error' : 'success' }}">
		@if($applicant->health_certificate != null)
			<div>
				<h3 class="ui left floated header left aligned">
					<u>Health Certificate Registration Number:
						<div class="ui large labels" style="margin-top: 5px">
							<a class="ui {{ $applicant->health_certificate->getColor() }} label">
								{{ $applicant->health_certificate->registration_number }}
							</a>
							@if($applicant->health_certificate->checkIfExpired())
								<a class="ui red label">
									<i class="exclamation circle icon"></i>
									EXPIRED
								</a>
							@endif
						</div>
					</u>
				</h3>
			</div>
		@endif

		<div style="clear: both;">
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

				<div class="four wide field">
					<img height="129" width="129" src="{{ $picture_url ? $picture_url : url("/noPicAvailable.png") }}">
				</div>

				<div class="three wide field" style="display: flex; align-items: center;">
					<div class="ui toggle checkbox">
						<input type="checkbox" name="edit_mode" class="hidden" {{ old('edit_mode') != 'on' ?: 'checked' }}>
						<label>Edit Applicant's Information</label>
					</div>
				</div>
			</div>

			<br>

			<div class="fields">
				<div class="four wide field"></div>

				<div class="four wide field{!! !$errors->has('first_name') ? '"' : ' error" data-content="' . $errors->first('first_name') . '" data-position="top center"' !!}>
					<label>First Name:</label>
					<input type="text" name="first_name" class="dynamic_input" value="{{ old('first_name') != null ? old('first_name') : $applicant->first_name }}">
				</div>

				<div class="four wide field">
					<label>Middle Name:</label>
					<input type="text" name="middle_name" class="dynamic_input" value="{{ old('middle_name') != null ? old('middle_name') : $applicant->middle_name }}">
				</div>
			</div>

			<div class="fields">
				<div class="four wide field"></div>

				<div class="four wide field{!! !$errors->has('last_name') ? '"' : ' error" data-content="' . $errors->first('last_name') . '" data-position="top center"' !!}>
					<label>Last Name:</label>
					<input type="text" name="last_name" class="dynamic_input" value="{{ old('last_name') != null ? old('last_name') : $applicant->last_name }}">
				</div>

				@php
					$checker = new App\Custom\FieldStateChecker();
					$selected_suffix_name = $checker->dropdown_select_check(old('suffix_name'), $applicant->suffix_name, ['Jr.', 'Sr.', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X'])
				@endphp

				<div class="four wide field{!! !$errors->has('suffix_name') ? '"' : ' error" data-content="' . $errors->first('suffix_name') . '" data-position="top center"' !!}>
					<label>Suffix:</label>

					<input value="{{ $selected_suffix_name }}" class="view_only" readonly>

					<select name="suffix_name" class="dynamic_select">
						<option value=""></option>
						<option value="Jr." {{ $selected_suffix_name != 'Jr.' ?: 'selected' }}>Jr.</option>
						<option value="Sr." {{ $selected_suffix_name != 'Sr.' ?: 'selected' }}>Sr.</option>
						<option value="I" {{ $selected_suffix_name != 'I' ?: 'selected' }}>I</option>
						<option value="II" {{ $selected_suffix_name != 'II' ?: 'selected' }}>II</option>
						<option value="III" {{ $selected_suffix_name != 'III' ?: 'selected' }}>III</option>
						<option value="IV" {{ $selected_suffix_name != 'IV' ?: 'selected' }}>IV</option>
						<option value="V" {{ $selected_suffix_name != 'V' ?: 'selected' }}>V</option>
						<option value="VI" {{ $selected_suffix_name != 'VI' ?: 'selected' }}>VI</option>
						<option value="VII" {{ $selected_suffix_name != 'VII' ?: 'selected' }}>VII</option>
						<option value="VIII" {{ $selected_suffix_name != 'VIII' ?: 'selected' }}>VIII</option>
						<option value="IX" {{ $selected_suffix_name != 'IX' ?: 'selected' }}>IX</option>
						<option value="X" {{ $selected_suffix_name != 'X' ?: 'selected' }}>X</option>
					</select>
				</div>
			</div>

			<div class="fields">
				<div class="four wide field"></div>

				<div class="four wide field{!! !$errors->has('age') ? '"' : ' error" data-content="' . $errors->first('age') . '" data-position="top center"' !!}>
					<label>Age:</label>
					<input type="number" name="age" class="dynamic_input" value="{{ old('age') != null ? old('age') : $applicant->age }}" min="">
				</div>

				@php
					$selected_gender = $checker->dropdown_select_check(old('gender'), $applicant->gender, ['0', '1'])
				@endphp
					
				<div class="four wide field{!! !$errors->has('gender') ? '"' : ' error" data-content="' . $errors->first('gender') . '" data-position="top center"' !!}>
					<label>Gender:</label>

					<input value="{{ $selected_gender == 1 ? 'Male' : 'Female' }}" class="view_only" readonly>

					<select name="gender" class="dynamic_select">
						<option value=""></option>
						<option value="1" {{ (string)$selected_gender != '1' ?: 'selected' }}>Male</option>
						<option value="0" {{ (string)$selected_gender != '0' ?: 'selected' }}>Female</option>
					</select>
				</div>
			</div>

			<div class="fields">
				<div class="four wide field"></div>

				<div class="eight wide field">
					<button type="submit" id="update_button" class="ui fluid inverted blue button" style="margin-top: 23.5px; visibility: {{ old('edit_mode') != 'on' ? 'hidden' : 'visible' }};">
						Update
					</button>
				</div>
			</div>
		</div>

		<div class="ui section divider"></div>

		<div class="ui attached message">
			<h3 class="ui header">
				Health Certificates
			</h3>
		</div>

		<table class="ui attached striped selectable structured celled table">
			<thead>
				<tr class="center aligned">
					<th>Registration Number</th>
					<th>Type of Work</th>
					<th>Name of Establishment</th>
					<th>Issuance Date</th>
					<th>Expiration Date</th>
					<th>Options</th>
				</tr>
			</thead>

			<tbody>
				@foreach($health_certificates as $hc)
					<tr class="center aligned">
						<td>{{ $hc->registration_number }}</td>
						<td>{{ $hc->work_type }}</td>
						<td>{{ $hc->establishment }}</td>
						<td>{{ $hc->issuance_date }}</td>
						<td>{{ $hc->expiration_date }}</td>
						<td class="collapsing">
							<div class="ui compact menu">
								<div class="ui simple dropdown item">
									<i class="options icon"></i>
									<i class="dropdown icon"></i>
									<div class="menu">
										<a class="item" href="{{ url("health_certificate/$hc->health_certificate_id") }}">Health Certificate Info</a>
										<a class="item" href="{{ url("health_certificate/$hc->health_certificate_id/preview") }}" target="_blank">Print Preview</a>
									</div>
								</div>
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</form>
</div>
@endsection

@section('sub_custom_js')

<script src="{{ mix('/js/applicant_information.js') }}"></script>

@endsection