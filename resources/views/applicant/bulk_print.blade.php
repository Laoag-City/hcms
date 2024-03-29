@extends('layouts.authenticated')

@section('sub_content')
<div class="sixteen wide column center aligned">
	<div class="ui attached message">
		<h2 class="ui header">
			{{ $title }}
		</h2>
	</div>

	<div class="ui attached fluid segment" style="min-height: 300px;">
		@if(session()->has($bulk_print_session_ids_name))
		<div style="overflow: auto;">
			<a class="ui right floated small red button" href="#" onclick="event.preventDefault(); document.getElementById('clear_ids_form').submit();">
				Clear Bulk Print List
			</a>
		</div>

			<form id="clear_ids_form" action="{{ url($bulk_print_clear_url) }}" method="POST" style="display: none;">
				{{ csrf_field() }}
			</form>
		@endif

		<form method="POST" action="{{ url()->current() }}" class="ui form">
			{{ csrf_field() }}
			<div class="fields">
				<div class="four wide field"></div>

				<div id="searchApplicant" class="eight wide field ui fluid search" data-content="Type an applicant name and choose from the suggestions below." data-position="top center">
						<label>Whole Name:</label>
						<input id="search_applicant" class="prompt" type="text" placeholder="Search Name">
						<div class="results"></div>
				</div>
			</div>

			<br>

			<div class="fields">
				<div class="two wide field"></div>

				<div class="twelve wide field">
					<table class="ui celled striped center aligned selectable table">
						<thead>
							<tr>
								<th>Name</th>
								<th>Registration No.</th>
								<th></th>
							</tr>
						</thead>

						<tbody id="to_prints">
							@if(session()->has($bulk_print_session_ids_name))
								@foreach(session($bulk_print_session_ids_name) as $id)
									<tr data-id="{{ $id }}">
										<input type="hidden" name="ids[]" value="{{ $id }}">

										<td>
											{{ $certificates->where($certificate_primary_key_name, $id)->first()->applicant->formatName() }}
										</td>

										<td>
											{{ $certificates->where($certificate_primary_key_name, $id)->first()->registration_number }}
										</td>

										<td>
											<button type="button" class="ui mini red button remove_button" onclick="removeRow({{ $id }})">Remove</button>
										</td>
									</tr>
								@endforeach
							@endif
						</tbody>
					</table>
				</div>
			</div>

			<div class="fields">
				<div class="two wide field"></div>

				<div class="twelve wide field">
					<button id="submit_button" type="submit" class="ui blue inverted fluid button">Print Selected</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endsection

@section('sub_custom_js')
	<script>
		var to_print_ids = {!! json_encode(session()->get($bulk_print_session_ids_name, [])) !!};
		var search_url = "{!! $search_certificates_url !!}";
	</script>

	<script src="{{ mix('/js/bulk_print.js') }}"></script>
@endsection