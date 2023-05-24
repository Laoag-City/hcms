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

			<div class="ui divider"></div>

			<div class="row">
				<div class="ui center aligned five wide column">
					<h2 class="ui header">
						<i class="address card outline icon"></i>
						Health Certificate
					</h2>

					<table class="ui attached striped selectable structured celled center aligned table">
						<thead>
							<tr>
								<th>Year</th>
								@foreach($hc_categories as $category)
									<th>{{ $category->category }}</th>
								@endforeach
							</tr>
						</thead>

						<tbody>
							@foreach($total_registered_hc_for_each_year as $year => $stats)
								<tr>
									<td>{{ $year }}</td>
									@foreach($hc_categories as $category)
										@php
											$current_record = $stats->where('category', $category->category)->first();
										@endphp

										@if($current_record != null && $current_record->counts != 0)
											<td>{{ $stats->where('category', $category->category)->first()->counts }}</td>
										@else
											<td></td>
										@endif
									@endforeach
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				<div class="ui center aligned eleven wide column">
					<h2 class="ui header">
						<i class="file outline icon"></i>
						Sanitary Permit
					</h2>

					<table class="ui attached striped selectable structured celled center aligned table">
						<thead>
							<tr>
								<th>Year</th>
								@foreach($sp_categories as $category)
									<th>{{ $category->category }}</th>
								@endforeach
							</tr>
						</thead>

						<tbody>
							@foreach($total_registered_sp_for_each_year as $year => $stats)
								<tr>
									<td>{{ $year }}</td>
									@foreach($sp_categories as $category)
										@php
											$current_record = $stats->where('category', $category->category)->first();
										@endphp

										@if($current_record != null && $current_record->counts != 0)
											<td>{{ $stats->where('category', $category->category)->first()->counts }}</td>
										@else
											<td></td>
										@endif
									@endforeach
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>

			<div class="row">
				<div class="ui center aligned seven wide column">
					<br>
					<h2 class="ui header">
						<i class="address card outline icon"></i>
						Pink Card
					</h2>

					<table class="ui attached striped selectable structured celled center aligned table">
						<thead>
							<tr>
								<th>Year</th>
								@foreach($pc_categories as $category)
									<th>{{ $category->category }}</th>
								@endforeach
							</tr>
						</thead>

						<tbody>
							@foreach($total_registered_pc_for_each_year as $year => $stats)
								<tr>
									<td>{{ $year }}</td>
									@foreach($pc_categories as $category)
										@php
											$current_record = $stats->where('category', $category->category)->first();
										@endphp

										@if($current_record != null && $current_record->counts != 0)
											<td>{{ $stats->where('category', $category->category)->first()->counts }}</td>
										@else
											<td></td>
										@endif
									@endforeach
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection