@extends('layouts.authenticated')

@section('sub_content')
<div class="sixteen wide column center aligned">
	<div class="ui attached message">
		<h2 class="ui header">
			Search Result(s) for <u>{{ $keyword }}</u>
		</h2>
	</div>

	<div class="ui attached fluid segment">
		<table class="ui striped selectable celled table">
			<thead>
				<tr class="center aligned">
					<th>Last Name</th>
					<th>First Name</th>
					<th class="collapsing">Middle Name</th>
					<th class="collapsing">Suffix</th>
					<th class="collapsing">Gender</th>
					<th class="collapsing">Age</th>
					<th class="collapsing">Health Cert. Reg. No.</th>
					<th></th>
				</tr>
			</thead>

			<tbody>
				@foreach($applicants as $app)
					<tr class="center aligned">
						<td>{{ $app->last_name }}</td>
						<td>{{ $app->first_name }}</td>
						<td class="collapsing">{{ $app->middle_name }}</td>
						<td class="collapsing">{{ $app->suffix_name }}</td>
						<td class="collapsing">{{ $app->getGender() }}</td>
						<td class="collapsing">{{ $app->age }}</td>
						<td class="collapsing">{{ $app->health_certificate ? $app->health_certificate->registration_number : '' }}</td>
						<td class="collapsing">
							<div class="ui small compact menu">
								<div class="ui simple dropdown item">
									<i class="list icon"></i>
									<i class="dropdown icon"></i>
									<div class="menu">
										<a href="{{ url("applicant/$app->applicant_id") }}" class="item">View Client</a>
									</div>
								</div>
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>

			<tfoot>
				<tr class="center aligned">
					<th colspan="8">{{ $applicants->links() }}</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
@endsection