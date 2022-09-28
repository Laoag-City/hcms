@extends('layouts.authenticated')

@section('sub_content')
<div class="sixteen wide column center aligned">
	<div class="ui attached message">
		<h2 class="ui header">
			Search Result(s) for <u>{{ $keyword }}</u> in <u>{{ $criteria }}</u>
		</h2>
	</div>

	<div class="ui attached fluid segment">
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
		
		<table class="ui striped selectable celled table">
			<thead>
				<tr class="center aligned">
					@if($criteria == 'Client Name')
						<th>Client Name</th>
						<th class="collapsing">Gender</th>
						<th class="collapsing">Age</th>
						<th></th>

					@elseif($criteria == 'Business Name')
						<th>Business</th>
						<th></th>

					@elseif($criteria == 'HC Reg. No.' || $criteria == 'Work Type' || $criteria == 'Establ. Name (HC)')
						<th>Registration Number</th>
						<th>Client Name</th>
						<th>Work Type</th>
						<th>Establishment Name</th>
						<th class="collapsing">Expired</th>
						<th class="collapsing">Issuance Date</th>
						<th class="collapsing">Expiration Date</th>
						<th class="collapsing"></th>

					@elseif($criteria == 'SP Number' || $criteria == 'Establ. Type (SP)')
						<th>Sanitary Permit No.</th>
						<th>Registered Name</th>
						<th>Establ. Type</th>
						<th>Address</th>
						<th>Expired</th>
						<th>Issuance Date</th>
						<th>Expiration Date</th>
						<th></th>
					@elseif($criteria == 'Pink Card Reg. No.' || $criteria == 'Place of Work (PC)')
						<th>Registration Number</th>
						<th>Client Name</th>
						<th>Occupation</th>
						<th>Place of Work</th>
						<th class="collapsing">Expired</th>
						<th class="collapsing">Issuance Date</th>
						<th class="collapsing">Expiration Date</th>
						<th class="collapsing"></th>
					@endif
				</tr>
			</thead>

			<tbody>
				@if($criteria == 'Client Name')
					@foreach($results as $result)
						<tr class="center aligned">
							<td>{{ $result->formatName() }}</td>
							<td class="collapsing">{{ $result->getGender() }}</td>
							<td class="collapsing">{{ $result->age }}</td>
							<td class="collapsing">
								<div class="ui small compact menu">
									<div class="ui simple dropdown item">
										<i class="list icon"></i>
										<i class="dropdown icon"></i>
										<div class="menu">
											<a href="{{ url("applicant/$result->applicant_id") }}" class="item">View Client</a>
										</div>
									</div>
								</div>
							</td>
						</tr>
					@endforeach

				@elseif($criteria == 'Business Name')
					@foreach($results as $result)
						<tr class="center aligned">
							<td>{{ $result->business_name }}</td>
							<td class="collapsing">
								<div class="ui small compact menu">
									<div class="ui simple dropdown item">
										<i class="list icon"></i>
										<i class="dropdown icon"></i>
										<div class="menu">
											<a href="{{ url("business/$result->business_id") }}" class="item">View Business</a>
										</div>
									</div>
								</div>
							</td>
						</tr>
					@endforeach

				@elseif($criteria == 'HC Reg. No.' || $criteria == 'Work Type' || $criteria == 'Establ. Name (HC)')
					@foreach($results as $result)
						@php
							$expired = $result->checkIfExpired();
						@endphp

						<tr class="center aligned">
							<td class="collapsing">{{ $result->registration_number }}</td>
							<td class="collapsing">{{ $result->applicant->formatName() }}</td>
							<td>{{ $result->work_type }}</td>
							<td>{{ $result->establishment }}</td>
							@if($expired)
								<td class="error">Yes</td>
							@else
								<td>No</td>
							@endif
							<td>{{ $result->issuance_date }}</td>
							<td>{{ $result->expiration_date }}</td>
							<td class="collapsing">
								<div class="ui compact menu">
									<div class="ui simple dropdown item">
										<i class="options icon"></i>
										<i class="dropdown icon"></i>
										<div class="menu">
											<a class="item" href="{{ url("health_certificate/$result->health_certificate_id") }}">Health Certificate Info</a>
											<a class="item" href="{{ url("health_certificate/$result->health_certificate_id/preview") }}">Print Preview</a>
											<button type="button" class="item delete_button" data-type="hc" data-id="{{ $result->health_certificate_id }}">Remove</button>
										</div>
									</div>
								</div>
							</td>
						</tr>
					@endforeach

				@elseif($criteria == 'SP Number' || $criteria == 'Establ. Type (SP)')
					@foreach($results as $result)
						@php
							$expired = $result->checkIfExpired();
						@endphp

						<tr class="center aligned">
							<td>{{ $result->sanitary_permit_number }}</td>
							<td>{{ $result->getRegisteredName() }}</td>
							<td>{{ $result->establishment_type }}</td>
							<td>{{ $result->address }}</td>
							@if($expired)
								<td class="error">Yes</td>
							@else
								<td>No</td>
							@endif
							<td>{{ $result->issuance_date }}</td>
							<td>{{ $result->expiration_date }}</td>
							<td class="collapsing">
								<div class="ui compact menu">
									<div class="ui simple dropdown item">
										<i class="options icon"></i>
										<i class="dropdown icon"></i>
										<div class="menu">
											<a class="item" href="{{ url("sanitary_permit/$result->sanitary_permit_id") }}">Sanitary Permit Info</a>
											<a class="item" href="{{ url("sanitary_permit/$result->sanitary_permit_id/preview") }}">Print Preview</a>
											<button type="button" class="item delete_button" data-type="sp" data-id="{{ $result->sanitary_permit_id }}">Remove</button>
										</div>
									</div>
								</div>
							</td>
						</tr>
					@endforeach

				@elseif($criteria == 'Pink Card Reg. No.' || $criteria == 'Place of Work (PC)')
					@foreach($results as $result)
						@php
							$expired = $result->checkIfExpired();
						@endphp

						<tr class="center aligned">
							<td class="collapsing">{{ $result->registration_number }}</td>
							<td class="collapsing">{{ $result->applicant->formatName() }}</td>
							<td>{{ $result->occupation }}</td>
							<td>{{ $result->place_of_work }}</td>
							@if($expired)
								<td class="error">Yes</td>
							@else
								<td>No</td>
							@endif
							<td>{{ $result->issuance_date }}</td>
							<td>{{ $result->expiration_date }}</td>
							<td class="collapsing">
								<div class="ui compact menu">
									<div class="ui simple dropdown item">
										<i class="options icon"></i>
										<i class="dropdown icon"></i>
										<div class="menu">
											<a class="item" href="{{ url("pink_card/$result->pink_health_certificate_id") }}">Pink Card Info</a>
											<a class="item" href="{{ url("pink_card/$result->pink_health_certificate_id/preview") }}">Print Preview</a>
											<button type="button" class="item delete_button" data-type="phc" data-id="{{ $result->pink_health_certificate_id }}">Remove</button>
										</div>
									</div>
								</div>
							</td>
						</tr>
					@endforeach
				@endif
			</tbody>

			<tfoot>
				<tr class="center aligned">
					<th colspan="8">{{ $results->links() }}</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
@endsection

@section('sub_custom_js')

<script src="{{ mix('/js/search_results.js') }}"></script>

@include('commons.delete_modal')

@endsection