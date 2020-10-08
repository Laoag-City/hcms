@extends('layouts.authenticated')

@section('sub_content')
<div class="sixteen wide column center aligned">
	<div class="ui attached message">
		<h2 class="ui header">
			Health Certificates
		</h2>
	</div>

	<div class="ui attached fluid segment">
		<table class="ui striped selectable structured celled table">
			<thead>
				<tr class="center aligned">
					<th>Registration Number</th>
					<th>Applicant</th>
					<th>Gender</th>
					<th>Age</th>
					<th>Options</th>
				</tr>
			</thead>

			<tbody>
				@foreach($health_certificates as $hc)
					<tr class="center aligned">
						<td>{{ $hc->registration_number }}</td>
						<td>{{ $hc->applicant->formatName() }}</td>
						<td>{{ $hc->applicant->getGender() }}</td>
						<td>{{ $hc->applicant->age }}</td>
						<td class="collapsing">
							<div class="ui compact menu">
								<div class="ui simple dropdown item">
									<i class="options icon"></i>
									<i class="dropdown icon"></i>
									<div class="menu">
										<a class="item" href="{{ url("health_certificate/$hc->health_certificate_id") }}">Health Certificate Info</a>
										<a class="item" href="{{ url("applicant/{$hc->applicant->applicant_id}") }}">Applicant Info</a>
										<a class="item" href="{{ url("health_certificate/$hc->health_certificate_id/preview") }}" target="_blank">Print Preview</a>
									</div>
								</div>
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>

			<tfoot>
				<tr class="center aligned">
					<th colspan="7">{{ $health_certificates->links() }}</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
@endsection