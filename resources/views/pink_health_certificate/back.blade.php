@php
	$records = $pink_health_certificate->cervical_smear_examinations;
	$table_divisions_count = $cervical_smear_max_rows / 3;
	$current_table_row_counter = $table_divisions_count;
	$i = 1;
@endphp

<div id="back_preview" class="pink_card block_center">
	<div class="card_column">
		<div class="contents">
			<h5 class="no_margin">Cervical Smear Exam</h5>

			<table>
				<thead>
					<tr>
						<th>Date</th>
						<th>Initial</th>
						<th>Next Exam Date</th>
					</tr>
				</thead>

				<tbody>
					@while($i <= $current_table_row_counter)
						@php
							$record = null;

							if($records != null)
								$record = $records->where('row_number', $i)->first();
						@endphp

						@if($record)
							<tr>
								<td>{{ $record->date_of_exam }}</td>
								<td>{{ $record->initial }}</td>
								<td>{{ $record->date_of_next_exam }}</td>
							</tr>
						@else
							<tr>
								<td class="empty_cell"></td>
								<td class="empty_cell"></td>
								<td class="empty_cell"></td>
							</tr>
						@endif

						@php
							$i++;
						@endphp
					@endwhile
				</tbody>
			</table>
		</div>
	</div>

	@php
		$current_table_row_counter = $current_table_row_counter + $table_divisions_count;
	@endphp

	<div class="card_column">
		<div class="contents">
			<h5 class="no_margin">Cervical Smear Exam</h5>

			<table>
				<thead>
					<tr>
						<th>Date</th>
						<th>Initial</th>
						<th>Next Exam Date</th>
					</tr>
				</thead>

				<tbody>
					@while($i <= $current_table_row_counter)
						@php
							$record = null;

							if($records != null)
								$record = $records->where('row_number', $i)->first();
						@endphp

						@if($record)
							<tr>
								<td>{{ $record->date_of_exam }}</td>
								<td>{{ $record->initial }}</td>
								<td>{{ $record->date_of_next_exam }}</td>
							</tr>
						@else
							<tr>
								<td class="empty_cell"></td>
								<td class="empty_cell"></td>
								<td class="empty_cell"></td>
							</tr>
						@endif

						@php
							$i++;
						@endphp
					@endwhile
				</tbody>
			</table>
		</div>
	</div>

	@php
		$current_table_row_counter = $current_table_row_counter + $table_divisions_count;
	@endphp

	<div class="card_column">
		<div class="contents">
			<h5 class="no_margin">Cervical Smear Exam</h5>

			<table>
				<thead>
					<tr>
						<th>Date</th>
						<th>Initial</th>
						<th>Next Exam Date</th>
					</tr>
				</thead>

				<tbody>
					@while($i <= $current_table_row_counter)
						@php
							$record = null;

							if($records != null)
								$record = $records->where('row_number', $i)->first();
						@endphp

						@if($record)
							<tr>
								<td>{{ $record->date_of_exam }}</td>
								<td>{{ $record->initial }}</td>
								<td>{{ $record->date_of_next_exam }}</td>
							</tr>
						@else
							<tr>
								<td class="empty_cell"></td>
								<td class="empty_cell"></td>
								<td class="empty_cell"></td>
							</tr>
						@endif

						@php
							$i++;
						@endphp
					@endwhile
				</tbody>
			</table>
		</div>
	</div>
</div>