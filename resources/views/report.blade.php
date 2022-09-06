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
			<div class="row">
				<div class="seven wide column center aligned">
					<div class="ui statistic">
						<div class="value">
							<i class="user icon"></i>
							{{ $total_applicants }}
						</div>
						<div class="label">
							Clients
						</div>
					</div>
				</div>

				<div class="seven wide column center aligned">
					<div class="ui statistic">
						<div class="value">
							<i class="building outline icon"></i>
							{{ $total_businesses }}
						</div>
						<div class="label">
							Businesses
						</div>
					</div>
				</div>
			</div>

			<div class="ui divider"></div>

			<div class="row">
				<div class="ui center aligned seven wide column">
					<h2 class="ui header">
						<i class="address card outline icon"></i>
						Health Certificate
					</h2>

					<div class="ui large labels">
						<div class="ui basic yellow label">
							Yellow HC
							<div class="detail">{{ $total_yellow_health_certificates }}</div>
						</div>

						<div class="ui basic green label">
							Green HC
							<div class="detail">{{ $total_green_health_certificates }}</div>
						</div>
					</div>

					<table class="ui attached striped selectable structured celled center aligned table">
						<thead>
							<tr>
								<th colspan="2">Registered HC each year</th>
							</tr>
							<tr>
								<th>Year</th>
								<th>Total</th>
							</tr>
						</thead>

						<tbody>
							@foreach($total_registered_hc_for_each_year as $year => $total)
								<tr>
									<td>{{ $year }}</td>
									<td>{{ $total }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>

				<div class="ui center aligned seven wide column">
					<h2 class="ui header">
						<i class="file outline icon"></i>
						Sanitary Permit
					</h2>

					<div class="ui large labels">
						<div class="ui basic red label">
							Sanitary Permit (Food)
							<div class="detail">{{ $total_food_sanitary_permits }}</div>
						</div>

						<div class="ui basic blue label">
							Sanitary Permit (Non-food)
							<div class="detail">{{ $total_nonfood_sanitary_permits }}</div>
						</div>
					</div>

					<table class="ui attached striped selectable structured celled center aligned table">
						<thead>
							<tr>
								<th colspan="2">Registered SP each year</th>
							</tr>
							<tr>
								<th>Year</th>
								<th>Total</th>
							</tr>
						</thead>

						<tbody>
							@foreach($total_registered_sp_for_each_year as $year => $total)
								<tr>
									<td>{{ $year }}</td>
									<td>{{ $total }}</td>
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