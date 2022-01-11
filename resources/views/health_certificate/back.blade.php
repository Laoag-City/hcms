<div id="back_preview" class="health_certificate">
	<div id="outer_border">
		<div id="inner_border">
			<div id="contents">
				<div>
					<h4 id="h4_back" class="block_center text-center">IMPORTANT</h4>
				</div>

				<div>
					<p class="text-center smaller_font no_margin" style="margin-top: 13.5pt;">
						THIS HEALTH CERTIFICATE IS NON-TRANSFERABLE. ALWAYS WEAR YOUR CERTIFICATE IN THE UPPER LEFT SIDE FRONT PORTION OF YOUR GARMENT WHILE WORKING. VALID ONLY UNTIL THE NEXT DATE OF EXAMINATION, AS INDICATED BELOW.
					</p>
				</div>

				<div class="text-center">
					<div style="display: inline-block;">
						<div class="field standard_font dates" style="margin-top: 10pt;">
							<b>{{ $health_certificate->issuance_date }}</b>
						</div>

						<div class="standard_font">
							Date of Issuance
						</div>
					</div>
					

					<div style="display: inline-block;">
						<div class="field standard_font dates" style="margin-top: 10pt;">
							<b>{{ $health_certificate->expiration_date }}</b>
						</div>

						<div class="standard_font">
							Date of Expiration
						</div>
					</div>
				</div>

				<div class="table_wrapper text-center">
					<div class="standard_font"><b>IMMUNIZATION</b></div>

					<table>
						<thead>
							<tr>
								<th>DATE</th>
								<th>KIND</th>
								<th>DATE OF EXP.</th>
							</tr>
						</thead>

						<tbody>
							<tr>
								@php
									if(isset($health_certificate->immunizations[0]) && $health_certificate->immunizations[0]->row_number == 1)
									{
										$immunization_date_1 = $health_certificate->immunizations[0]->date;
										$immunization_kind_1 = $health_certificate->immunizations[0]->kind;
										$immunization_date_of_expiration_1 = $health_certificate->immunizations[0]->expiration_date;
									}

									elseif(isset($health_certificate->immunizations[1]) && $health_certificate->immunizations[1]->row_number == 1)
									{
										$immunization_date_1 = $health_certificate->immunizations[1]->date;
										$immunization_kind_1 = $health_certificate->immunizations[1]->kind;
										$immunization_date_of_expiration_1 = $health_certificate->immunizations[1]->expiration_date;
									}

									else
									{
										$immunization_date_1 = null;
										$immunization_kind_1 = null;
										$immunization_date_of_expiration_1 = null;
									}
								@endphp

								<td class="{{ $immunization_date_1 != null ?: 'empty_cell' }}">{{ $immunization_date_1 }}</td>
								<td class="{{ $immunization_kind_1 != null ?: 'empty_cell' }}">{{ $immunization_kind_1 }}</td>
								<td class="{{ $immunization_date_of_expiration_1 != null ?: 'empty_cell' }}">{{ $immunization_date_of_expiration_1 }}</td>
							</tr>

							<tr>
								@php
									if(isset($health_certificate->immunizations[0]) && $health_certificate->immunizations[0]->row_number == 2)
									{
										$immunization_date_2 = $health_certificate->immunizations[0]->date;
										$immunization_kind_2 = $health_certificate->immunizations[0]->kind;
										$immunization_date_of_expiration_2 = $health_certificate->immunizations[0]->expiration_date;
									}

									elseif(isset($health_certificate->immunizations[1]) && $health_certificate->immunizations[1]->row_number == 2)
									{
										$immunization_date_2 = $health_certificate->immunizations[1]->date;
										$immunization_kind_2 = $health_certificate->immunizations[1]->kind;
										$immunization_date_of_expiration_2 = $health_certificate->immunizations[1]->expiration_date;
									}

									else
									{
										$immunization_date_2 = null;
										$immunization_kind_2 = null;
										$immunization_date_of_expiration_2 = null;
									}
								@endphp

								<td class="{{ $immunization_date_2 != null ?: 'empty_cell' }}">{{ $immunization_date_2 }}</td>
								<td class="{{ $immunization_kind_2 != null ?: 'empty_cell' }}">{{ $immunization_kind_2 }}</td>
								<td class="{{ $immunization_date_of_expiration_2 != null ?: 'empty_cell' }}">{{ $immunization_date_of_expiration_2 }}</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="table_wrapper text-center">
					<div class="standard_font"><b>X-RAY, SPUTUM EXAM</b></div>

					<table>
						<thead>
							<tr>
								<th>DATE</th>
								<th>KIND</th>
								<th>RESULT</th>
							</tr>
						</thead>

						<tbody>
							<tr>
								@php
									if(isset($health_certificate->xray_sputums[0]) && $health_certificate->xray_sputums[0]->row_number == 1)
									{
										$xray_sputum_exam_date_1 = $health_certificate->xray_sputums[0]->date;
										$xray_sputum_exam_kind_1 = $health_certificate->xray_sputums[0]->kind;
										$xray_sputum_exam_result_1 = $health_certificate->xray_sputums[0]->result;
									}

									elseif(isset($health_certificate->xray_sputums[1]) && $health_certificate->xray_sputums[1]->row_number == 1)
									{
										$xray_sputum_exam_date_1 = $health_certificate->xray_sputums[1]->date;
										$xray_sputum_exam_kind_1 = $health_certificate->xray_sputums[1]->kind;
										$xray_sputum_exam_result_1 = $health_certificate->xray_sputums[1]->result;
									}

									else
									{
										$xray_sputum_exam_date_1 = null;
										$xray_sputum_exam_kind_1 = null;
										$xray_sputum_exam_result_1 = null;
									}
								@endphp

								<td class="{{ $xray_sputum_exam_date_1 != null ?: 'empty_cell' }}">{{ $xray_sputum_exam_date_1 }}</td>
								<td class="{{ $xray_sputum_exam_kind_1 != null ?: 'empty_cell' }}">{{ $xray_sputum_exam_kind_1 }}</td>
								<td class="{{ $xray_sputum_exam_result_1 != null ?: 'empty_cell' }}">{{ $xray_sputum_exam_result_1 }}</td>
							</tr>

							<tr>
								@php
									if(isset($health_certificate->xray_sputums[0]) && $health_certificate->xray_sputums[0]->row_number == 2)
									{
										$xray_sputum_exam_date_2 = $health_certificate->xray_sputums[0]->date;
										$xray_sputum_exam_kind_2 = $health_certificate->xray_sputums[0]->kind;
										$xray_sputum_exam_result_2 = $health_certificate->xray_sputums[0]->result;
									}

									elseif(isset($health_certificate->xray_sputums[1]) && $health_certificate->xray_sputums[1]->row_number == 2)
									{
										$xray_sputum_exam_date_2 = $health_certificate->xray_sputums[1]->date;
										$xray_sputum_exam_kind_2 = $health_certificate->xray_sputums[1]->kind;
										$xray_sputum_exam_result_2 = $health_certificate->xray_sputums[1]->result;
									}

									else
									{
										$xray_sputum_exam_date_2 = null;
										$xray_sputum_exam_kind_2 = null;
										$xray_sputum_exam_result_2 = null;
									}
								@endphp

								<td class="{{ $xray_sputum_exam_date_2 != null ?: 'empty_cell' }}">{{ $xray_sputum_exam_date_2 }}</td>
								<td class="{{ $xray_sputum_exam_kind_2 != null ?: 'empty_cell' }}">{{ $xray_sputum_exam_kind_2 }}</td>
								<td class="{{ $xray_sputum_exam_result_2 != null ?: 'empty_cell' }}">{{ $xray_sputum_exam_result_2 }}</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="table_wrapper text-center">
					<div class="standard_font"><b>STOOL AND OTHER EXAM</b></div>

					<table>
						<thead>
							<tr>
								<th>DATE</th>
								<th>KIND</th>
								<th>RESULT</th>
							</tr>
						</thead>

						<tbody>
							<tr>
								@php
									if(isset($health_certificate->stool_and_others[0]) && $health_certificate->stool_and_others[0]->row_number == 1)
									{
										$stool_and_other_exam_date_1 = $health_certificate->stool_and_others[0]->date;
										$stool_and_other_exam_kind_1 = $health_certificate->stool_and_others[0]->kind;
										$stool_and_other_exam_result_1 = $health_certificate->stool_and_others[0]->result;
									}

									elseif(isset($health_certificate->stool_and_others[1]) && $health_certificate->stool_and_others[1]->row_number == 1)
									{
										$stool_and_other_exam_date_1 = $health_certificate->stool_and_others[1]->date;
										$stool_and_other_exam_kind_1 = $health_certificate->stool_and_others[1]->kind;
										$stool_and_other_exam_result_1 = $health_certificate->stool_and_others[1]->result;
									}

									else
									{
										$stool_and_other_exam_date_1 = null;
										$stool_and_other_exam_kind_1 = null;
										$stool_and_other_exam_result_1 = null;
									}
								@endphp

								<td class="{{ $stool_and_other_exam_date_1 != null ?: 'empty_cell' }}">{{ $stool_and_other_exam_date_1 }}</td>
								<td class="{{ $stool_and_other_exam_kind_1 != null ?: 'empty_cell' }}">{{ $stool_and_other_exam_kind_1 }}</td>
								<td class="{{ $stool_and_other_exam_result_1 != null ?: 'empty_cell' }}">{{ $stool_and_other_exam_result_1 }}</td>
							</tr>

							<tr>
								@php
									if(isset($health_certificate->stool_and_others[0]) && $health_certificate->stool_and_others[0]->row_number == 2)
									{
										$stool_and_other_exam_date_2 = $health_certificate->stool_and_others[0]->date;
										$stool_and_other_exam_kind_2 = $health_certificate->stool_and_others[0]->kind;
										$stool_and_other_exam_result_2 = $health_certificate->stool_and_others[0]->result;
									}

									elseif(isset($health_certificate->stool_and_others[1]) && $health_certificate->stool_and_others[1]->row_number == 2)
									{
										$stool_and_other_exam_date_2 = $health_certificate->stool_and_others[1]->date;
										$stool_and_other_exam_kind_2 = $health_certificate->stool_and_others[1]->kind;
										$stool_and_other_exam_result_2 = $health_certificate->stool_and_others[1]->result;
									}

									else
									{
										$stool_and_other_exam_date_2 = null;
										$stool_and_other_exam_kind_2 = null;
										$stool_and_other_exam_result_2 = null;
									}
								@endphp

								<td class="{{ $stool_and_other_exam_date_2 != null ?: 'empty_cell' }}">{{ $stool_and_other_exam_date_2 }}</td>
								<td class="{{ $stool_and_other_exam_kind_2 != null ?: 'empty_cell' }}">{{ $stool_and_other_exam_kind_2 }}</td>
								<td class="{{ $stool_and_other_exam_result_2 != null ?: 'empty_cell' }}">{{ $stool_and_other_exam_result_2 }}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>