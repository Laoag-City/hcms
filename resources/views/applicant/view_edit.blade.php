@extends('layouts.authenticated')

@section('sub_content')
<div class="sixteen wide column center aligned">
	<div class="ui attached message">
		<h2 class="ui header">
			Client's Information
		</h2>
	</div>

	<div class="ui attached fluid segment">
		<form method="POST" action="{{ url()->current() }}" class="ui form {{ $errors->any() ? 'error' : 'success' }}">
			<div style="overflow: auto;">
				<a href="{{ url('applicants') }}" class="ui left floated blue inverted button">Back</a>
			</div>

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
		</form>

		<div class="ui section divider"></div>

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

		<div class="ui top attached tabular menu">
			<a class="item active" data-tab="first">Health Certificates</a>
			<a class="item" data-tab="second">Sanitary Permits</a>
		</div>

		<div class="ui bottom attached tab segment active" data-tab="first">
			<table class="ui attached striped selectable structured celled table">
				<thead>
					<tr class="center aligned">
						<th>Registration Number</th>
						<th>Type of Work</th>
						<th>Name of Establishment</th>
						<th class="collapsing">Expired</th>
						<th class="collapsing">Issuance Date</th>
						<th class="collapsing">Expiration Date</th>
						<th class="collapsing">Options</th>
					</tr>
				</thead>

				<tbody>
					@foreach($health_certificates as $hc)
						@php
							$expired = $hc->checkIfExpired();
						@endphp

						<tr class="center aligned">
							<td class="collapsing">{{ $hc->registration_number }}</td>
							<td>{{ $hc->work_type }}</td>
							<td>{{ $hc->establishment }}</td>
							@if($expired)
								<td class="error">Yes</td>
							@else
								<td>No</td>
							@endif
							<td>{{ $hc->issuance_date }}</td>
							<td>{{ $hc->expiration_date }}</td>
							<td class="collapsing">
								<div class="ui compact menu">
									<div class="ui simple dropdown item">
										<i class="options icon"></i>
										<i class="dropdown icon"></i>
										<div class="menu">
											<a class="item" href="{{ url("health_certificate/$hc->health_certificate_id") }}">Health Certificate Info</a>
											<a class="item" href="{{ url("health_certificate/$hc->health_certificate_id/preview") }}">Print Preview</a>
											<button type="button" class="item delete_button" data-type="hc" data-id="{{ $hc->health_certificate_id }}">Remove</button>
										</div>
									</div>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>

		<div class="ui bottom attached tab segment" data-tab="second">
			<table class="ui attached striped selectable structured celled table">
				<thead>
					<tr class="center aligned">
						<th class="collapsing">Sanitary Permit Number</th>
						<th>Establishment Type</th>
						<th>Address</th>
						<th class="collapsing">Expired</th>
						<th class="collapsing">Issuance Date</th>
						<th class="collapsing">Expiration Date</th>
						<th class="collapsing">Options</th>
					</tr>
				</thead>

				<tbody>
					@foreach($sanitary_permits as $sc)
						@php
							$expired = $sc->checkIfExpired();
						@endphp

						<tr class="center aligned">
							<td>{{ $sc->sanitary_permit_number }}</td>
							<td>{{ $sc->establishment_type }}</td>
							<td>{{ $sc->address }}</td>
							@if($expired)
								<td class="error">Yes</td>
							@else
								<td>No</td>
							@endif
							<td>{{ $sc->issuance_date }}</td>
							<td>{{ $sc->expiration_date }}</td>
							<td class="collapsing">
								<div class="ui compact menu">
									<div class="ui simple dropdown item">
										<i class="options icon"></i>
										<i class="dropdown icon"></i>
										<div class="menu">
											<a class="item" href="{{ url("sanitary_permit/$sc->sanitary_permit_id") }}">Sanitary Permit Info</a>
											<a class="item" href="{{ url("sanitary_permit/$sc->sanitary_permit_id/preview") }}">Print Preview</a>
											<button type="button" class="item delete_button" data-type="sp" data-id="{{ $sc->sanitary_permit_id }}">Remove</button>
										</div>
									</div>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection

@section('sub_custom_js')

<script src="{{ mix('/js/applicant_information.js') }}"></script>

@include('commons.delete_modal')

@endsection