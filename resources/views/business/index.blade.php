@extends('layouts.authenticated')

@section('sub_content')
<div class="sixteen wide column center aligned">
	<div class="ui attached message">
		<h2 class="ui header">
			Businesses
		</h2>
	</div>

	<div class="ui attached fluid segment">
		<table class="ui striped selectable celled table">
			<thead>
				<tr class="center aligned">
					<th>Business Name</th>
					<th></th>
				</tr>
			</thead>

			<tbody>
				@foreach($businesses as $business)
					<tr class="center aligned">
						<td>{{ $business->business_name }}</td>
						<td class="collapsing">
							<div class="ui small compact menu">
								<div class="ui simple dropdown item">
									<i class="list icon"></i>
									<i class="dropdown icon"></i>
									<div class="menu">
										<a href="{{ url("applicant/$business->business_id") }}" class="item">View Business</a>
									</div>
								</div>
							</div>
						</td>
					</tr>
				@endforeach
			</tbody>

			<tfoot>
				<tr class="center aligned">
					<th colspan="8">{{ $businesses->links() }}</th>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
@endsection