<div id="front_preview" class="pink_card block_center">
	<div class="card_column">
		<div class="contents">
			<div>
				<img id="logo" src="{{ $logo }}" class="pull_left">

				<h3 class="no_margin" style="letter-spacing: 3pt;"><b>DEPARTMENT OF HEALTH</b></h3>
				<p class="standard_font" style="margin-top: 5pt; letter-spacing: 0.5pt;"><b>Office of the City Health Officer</b></p>

				<div class="text_right" style="margin-top: 20pt;">
					<span class="label">Reg. No. </span>
					<b class="value" style="width: 80pt;">{{ $pink_health_certificate->registration_number }}</b>
				</div>
			</div>

			<div style="margin-top: 25pt;">
				<h3  style="margin-bottom: 0; letter-spacing: 1pt;">HEALTH CERTIFICATE</h3>
				<p class="text_justify standard_font">
					Pursuant to the provisions of P.D. 522 and 856 and City Ord. No. 1057 S 85, this certificate is issued to
				</p>
			</div>

			<div>
				<div class="field">
					<span class="label">Name: </span>
					<b class="value" style="width: 164pt;">{{ $pink_health_certificate->applicant->formatName() }}</b>
				</div>

				<div class="field">
					<span class="label">Occupation: </span>
					<b class="value" style="width: 146pt;">{{ $pink_health_certificate->occupation }}</b>
				</div>

				<div class="field">
					<span class="label">Age: </span>
					<b class="value" style="width: 14pt;">{{ $pink_health_certificate->applicant->age }}</b>
				</div>

				<div class="field">
					<span class="label">Sex: </span>
					<b class="value" style="width: 14pt;">
						{{ $pink_health_certificate->applicant->gender == 1 ? 'M' : 'F' }}
					</b>
				</div>

				<div class="field">
					<span class="label">Nationality: </span>
					<b class="value" style="width: 80pt;">{{ $pink_health_certificate->applicant->nationality }}</b>
				</div>

				<div class="field">
					<span class="label">Place of Work: </span>
					<b class="value" style="width: 137pt;">{{ $pink_health_certificate->place_of_work }}</b>
				</div>
			</div>

			<div style="margin-top: 30pt; overflow: auto;">
				<img {{ !$picture ?: "src=$picture"}} id="picture" class="pull_left">

				<div class="pull_right" style="width: 110pt; height: 90pt;">
					<div class="field">
						<b class="value" style="width: 105pt;"></b>
						<span class="standard_font">Signature</span>
					</div>

					<div style="margin-top: 25pt;">
						<b class="value" style="width: 105pt;">JOSEPH D. ADAYA, M.D.</b>
						<span class="standard_font">OIC - City Health Officer</span>
					</div>
				</div>
			</div>
		</div>
	</div>

	<div class="card_column">
		<div class="contents">
			<h4 style="margin-top: 0;">IMPORTANT</h4>

			<p class="smaller_font">
				THIS HEALTH CERTIFICATE IS NON-TRANSFERABLE. ALWAYS WEAR YOUR CERTIFICATE IN THE UPPER LEFT SIDE FRONT PORTION OF YOUR GARMENT WHILE WORKING. VALID ONLY UNTIL THE NEXT DATE OF EXAMINATION, AS INDICATED BELOW.
			</p>

			<div style="margin-top: 30pt; overflow: auto;">
				<div class="pull_left">
					<b class="value" style="width: 85pt;">{{ $pink_health_certificate->issuance_date }}</b>
					<p class="standard_font no_margin">Date of Issuance</p>
				</div>

				<div class="pull_right">
					<b class="value" style="width: 85pt;">{{ $pink_health_certificate->expiration_date }}</b>
					<p class="standard_font no_margin">Date of Expiration</p>
				</div>
			</div>

			<h5 style="margin-bottom: 5pt;">IMMUNIZATION</h5>

			<table>
				<thead>
					<tr>
						<th>Date</th>
						<th>Kind</th>
						<th>Date of Exp.</th>
					</tr>
				</thead>

				<tbody>
					@php
						$records = $pink_health_certificate->immunizations;
					@endphp

					@for($i = 1;$i <= $immunization_rows; $i++)
						@php
							$record = null;

							if($records != null)
								$record = $records->where('row_number', $i)->first();
						@endphp

						@if($record)
							<tr>
								<td>{{ $record->date }}</td>
								<td>{{ $record->kind }}</td>
								<td>{{ $record->expiration_date }}</td>
							</tr>
						@else
							<tr>
								<td class="empty_cell"></td>
								<td class="empty_cell"></td>
								<td class="empty_cell"></td>
							</tr>
						@endif
					@endfor
				</tbody>
			</table>

			<h5 style="margin-bottom: 5pt;">X-RAY/SPUTUM</h5>

			<table>
				<thead>
					<tr>
						<th>Date</th>
						<th>Kind</th>
						<th>Result</th>
					</tr>
				</thead>

				<tbody>
					@php
						$records = $pink_health_certificate->xray_sputums;
					@endphp

					@for($i = 1;$i <= $immunization_rows; $i++)
						@php
							$record = null;

							if($records != null)
								$record = $records->where('row_number', $i)->first();
						@endphp

						@if($record)
							<tr>
								<td>{{ $record->date }}</td>
								<td>{{ $record->kind }}</td>
								<td>{{ $record->result }}</td>
							</tr>
						@else
							<tr>
								<td class="empty_cell"></td>
								<td class="empty_cell"></td>
								<td class="empty_cell"></td>
							</tr>
						@endif
					@endfor
				</tbody>
			</table>

			<h5 style="margin-bottom: 5pt;">STOOL & OTHER EXAM</h5>

			<table>
				<thead>
					<tr>
						<th>Date</th>
						<th>Kind</th>
						<th>Result</th>
					</tr>
				</thead>

				<tbody>
					@php
						$records = $pink_health_certificate->stool_and_others;
					@endphp

					@for($i = 1;$i <= $immunization_rows; $i++)
						@php
							$record = null;

							if($records != null)
								$record = $records->where('row_number', $i)->first();
						@endphp

						@if($record)
							<tr>
								<td>{{ $record->date }}</td>
								<td>{{ $record->kind }}</td>
								<td>{{ $record->result }}</td>
							</tr>
						@else
							<tr>
								<td class="empty_cell"></td>
								<td class="empty_cell"></td>
								<td class="empty_cell"></td>
							</tr>
						@endif
					@endfor
				</tbody>
			</table>
		</div>
	</div>

	<div class="card_column">
		<div class="contents">
			<h5 style="margin-bottom: 5pt;">HIV EXAMINATION</h5>

			<table>
				<thead>
					<tr>
						<th>Date</th>
						<th>Result</th>
						<th>Next Exam Date</th>
					</tr>
				</thead>

				<tbody>
					@php
						$records = $pink_health_certificate->hiv_examinations;
					@endphp

					@for($i = 1;$i <= $immunization_rows; $i++)
						@php
							$record = null;

							if($records != null)
								$record = $records->where('row_number', $i)->first();
						@endphp

						@if($record)
							<tr>
								<td>{{ $record->date_of_exam }}</td>
								<td>{{ $record->result }}</td>
								<td>{{ $record->date_of_next_exam }}</td>
							</tr>
						@else
							<tr>
								<td class="empty_cell"></td>
								<td class="empty_cell"></td>
								<td class="empty_cell"></td>
							</tr>
						@endif
					@endfor
				</tbody>
			</table>

			<h5 style="margin-bottom: 5pt;">HBsAg EXAMINATION</h5>

			<table>
				<thead>
					<tr>
						<th>Date</th>
						<th>Result</th>
						<th>Next Exam Date</th>
					</tr>
				</thead>

				<tbody>
					@php
						$records = $pink_health_certificate->hbsag_examinations;
					@endphp

					@for($i = 1;$i <= $immunization_rows; $i++)
						@php
							$record = null;

							if($records != null)
								$record = $records->where('row_number', $i)->first();
						@endphp

						@if($record)
							<tr>
								<td>{{ $record->date_of_exam }}</td>
								<td>{{ $record->result }}</td>
								<td>{{ $record->date_of_next_exam }}</td>
							</tr>
						@else
							<tr>
								<td class="empty_cell"></td>
								<td class="empty_cell"></td>
								<td class="empty_cell"></td>
							</tr>
						@endif
					@endfor
				</tbody>
			</table>

			<h5 style="margin-bottom: 5pt;">VDRL EXAMINATION</h5>

			<table>
				<thead>
					<tr>
						<th>Date</th>
						<th>Result</th>
						<th>Next Exam Date</th>
					</tr>
				</thead>

				<tbody>
					@php
						$records = $pink_health_certificate->vdrl_examinations;
					@endphp

					@for($i = 1;$i <= $immunization_rows; $i++)
						@php
							$record = null;

							if($records != null)
								$record = $records->where('row_number', $i)->first();
						@endphp

						@if($record)
							<tr>
								<td>{{ $record->date_of_exam }}</td>
								<td>{{ $record->result }}</td>
								<td>{{ $record->date_of_next_exam }}</td>
							</tr>
						@else
							<tr>
								<td class="empty_cell"></td>
								<td class="empty_cell"></td>
								<td class="empty_cell"></td>
							</tr>
						@endif
					@endfor
				</tbody>
			</table>

			<div class="field" style="margin-top: 30pt;">
				<span class="label">Community Tax No.: </span>
				<b class="value" style="width: 119pt;">{{ $pink_health_certificate->community_tax_no }}</b>
			</div>

			<div class="field">
				<span class="label">Issued At: </span>
				<b class="value" style="width: 153pt;">{{ $pink_health_certificate->community_tax_issued_at }}</b>
			</div>

			<div class="field">
				<span class="label">Issued On: </span>
				<b class="value" style="width: 150pt;">{{ $pink_health_certificate->community_tax_issued_on }}</b>
			</div>
		</div>
	</div>
</div>