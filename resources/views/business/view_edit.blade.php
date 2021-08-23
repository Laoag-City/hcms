@extends('layouts.authenticated')

@section('sub_content')
<div class="sixteen wide column center aligned">
	<div class="ui attached message">
		<h2 class="ui header">
			Business' Information
		</h2>
	</div>

	<div class="ui attached fluid segment">
		<form method="POST" action="{{ url()->current() }}" class="ui form {{ $errors->any() ? 'error' : 'success' }}">
			<div style="overflow: auto;">
				<a href="{{ url('businesses') }}" class="ui left floated blue inverted button">Back</a>
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
					<div class="eight wide field" style="display: flex; align-items: center;">
						<div class="ui toggle checkbox block_center">
							<input type="checkbox" name="edit_mode" class="hidden" {{ old('edit_mode') != 'on' ?: 'checked' }}>
							<label>Edit Business' Information</label>
						</div>
					</div>
				</div>

				<br>

				<div class="fields">
					<div class="four wide field"></div>

					<div class="eight wide field{!! !$errors->has('business_name') ? '"' : ' error" data-content="' . $errors->first('business_name') . '" data-position="top center"' !!}>
						<label>Business Name:</label>
						<input type="text" name="business_name" class="dynamic_input" value="{{ old('business_name') != null ? old('business_name') : $business->business_name }}">
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
			<a class="item active" data-tab="first">Sanitary Permits</a>
		</div>

		<div class="ui bottom attached tab segment active" data-tab="first">
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
											<button type="button" class="item delete_button" data-id="{{ $sc->sanitary_permit_id }}">Remove</button>
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

<script src="{{ mix('/js/business_information.js') }}"></script>

@include('commons.delete_modal')

@endsection