@extends('layouts.authenticated')

@section('sub_content')
<div class="sixteen wide column center aligned">
	<div class="ui attached message">
		<h2 class="ui header">
			{{ $title }}
		</h2>
	</div>

	<div class="ui attached fluid segment" style="min-height: 300px;">
		<div class="ui stackable centered grid">
			<div class="fourteen wide column center aligned">
				<form method="POST" target="_blank" action="{{ url()->current() }}" class="ui form">
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
										<th></th>
									</tr>
								</thead>

								<tbody id="to_prints">
									
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
	</div>
</div>
@endsection

@section('sub_custom_js')
<script src="{{ mix('/js/bulk_print.js') }}"></script>
@endsection