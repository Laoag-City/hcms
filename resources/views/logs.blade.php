@extends('layouts.authenticated')

@section('sub_content')
<div class="sixteen wide column center aligned">
	<div class="ui attached message">
		<h2 class="ui header">
			{{ $title }}
		</h2>
	</div>

	<div class="ui attached segment">
		<br>
		<div class="ui stackable centered grid">
			<div class="sxiteen wide column">
				<table class="ui compact selectable center aligned table">
					<thead>
						<tr>
							<th>Log No.</th>
							<th>Encoder</th>
							<th>Description</th>
							<th class="collapsing">Date/Time</th>
							<th class="collapsing"></th>
						</tr>
					</thead>

					<tbody>
						@foreach($logs as $log)
							@php
								if($log->loggable instanceof App\Applicant)
									$link = "applicant";

								elseif($log->loggable instanceof App\Business)
									$link = "business";

								elseif($log->loggable instanceof App\HealthCertificate)
									$link = "health_certificate";

								elseif($log->loggable instanceof App\SanitaryPermit)
									$link = "sanitary_permit";

								elseif($log->loggable instanceof App\PinkHealthCertificate)
									$link = "pink_card";

								$link = "$link/{$log->loggable_id}"
							@endphp

							<tr>
								<td>{{ $log->log_id }}</td>
								<td>{{ $log->user->full_name }}</td>
								<td>{{ $log->description }}</td>
								<td class="collapsing">{{ date('M d, Y h:i:s A', strtotime($log->created_at)) }}</td>
								<td class="collapsing"><a href="{{ $link }}" class="ui basic mini blue button">View Record</a></td>
							</tr>
						@endforeach
					</tbody>
				</table>

				<br>

				<div class="text_center">{{ $logs->links() }}</div>
			</div>
		</div>
	</div>
</div>
@endsection