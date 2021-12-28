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

				<table class="ui center aligned striped celled table">
					<thead>
						<tr>
							<th>Establishment Type</th>
							<th>Address</th>
							<th>Permit Number</th>
							<th>Issuance Date</th>
							<th>Expiration Date</th>
							<th>Sanitary Inspector</th>
							<th>Expired</th>
							<th></th>
						</tr>
					</thead>

					<tbody>
						@foreach($sanitary_permits as $permit)
							<tr>
								<td>{{ $permit->establishment_type }}</td>
								<td>{{ $permit->address }}</td>
								<td>{{ $permit->sanitary_permit_number }}</td>
								<td class="collapsing">{{ $permit->issuance_date }}</td>
								<td class="collapsing">{{ $permit->expiration_date }}</td>
								<td>{{ $permit->sanitary_inspector }}</td>
								<td class="collapsing">{{ $permit->checkIfExpired() == true ? 'Yes' : 'No' }}</td>
								<td class="collapsing">
									<div class="ui small compact menu">
										<div class="ui simple dropdown item">
											<i class="list icon"></i>
											<i class="dropdown icon"></i>
											<div class="menu">
												<a class="item" href="{{ url("sanitary_permit/$permit->sanitary_permit_id") }}">Update/Renew</a>
												<a class="item" href="{{ url("sanitary_permit/$permit->sanitary_permit_id/preview") }}">Print Preview</a>
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
</div>
@endsection