@extends('layouts.authenticated')

@section('sub_content')
<div class="sixteen wide column center aligned">
	<div class="ui attached message">
		<h2 class="ui header">
			Search Result(s) for <u>{{ $keyword }}</u>
		</h2>
	</div>

	<div class="ui attached fluid segment">
		<table class="ui striped selectable structured celled table">
			<thead>
				<tr class="center aligned">
					<th>Last Name</th>
					<th>First Name</th>
					<th>Middle Name</th>
					<th>Suffix</th>
					<th>Gender</th>
					<th>Age</th>
					<th></th>
				</tr>
			</thead>

			<tbody>
				@foreach($applicants as $app)
					<tr class="center aligned">
						<td>{{ $app->last_name }}</td>
						<td>{{ $app->first_name }}</td>
						<td>{{ $app->middle_name }}</td>
						<td>{{ $app->suffix_name }}</td>
						<td>{{ $app->getGender() }}</td>
						<td>{{ $app->age }}</td>
						<td class="collapsing">
							<a href="{{ url("applicant/$app->applicant_id") }}" class="ui mini inverted blue button">Applicant Info</a>
						</td>
					</tr>
				@endforeach
			</tbody>

			<tfoot>
				<tr class="center aligned">
					<th colspan="7">{{ $applicants->links() }}</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
@endsection