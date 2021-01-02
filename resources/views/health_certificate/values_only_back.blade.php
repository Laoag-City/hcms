<div id="back_preview" class="health_certificate no_main_border">
	<div id="outer_border" class="no_outer_border">
		<div id="inner_border" class="no_inner_border">
			<div id="contents">
				<div>
					<h4 id="h4_back" class="block_center text-center invisible_on_print">IMPORTANT</h4>
				</div>

				<div>
					<p class="text-center standard_font no_margin invisible_on_print" style="margin-top: 13.5pt; font-size: 7pt;">
						THIS HEALTH CERTIFICATE IS NON-TRANSFERABLE. ALWAYS WEAR YOUR CERTIFICATE IN THE UPPER LEFT SIDE FRONT PORTION OF YOUR GARMENT WHILE WORKING. VALID ONLY UNTIL THE NEXT DATE OF EXAMINATION, AS INDICATED BELOW.
					</p>
				</div>

				<div class="text-center">
					<div style="display: inline-block;">
						<div class="field dates no_border_on_print larger_font" style="margin-top: 10pt;">
							{{ $health_certificate->issuance_date }}
						</div>

						<div class="standard_font invisible_on_print">
							Date of Issuance
						</div>
					</div>
					

					<div style="display: inline-block;">
						<div class="field dates no_border_on_print larger_font" style="margin-top: 10pt;">
							{{ $health_certificate->expiration_date }}
						</div>

						<div class="standard_font invisible_on_print">
							Date of Expiration
						</div>
					</div>
				</div>

				<div class="table_wrapper text-center">
					<div class="standard_font invisible_on_print"><b>IMMUNIZATION</b></div>

					<table class="no_borders">
						<thead>
							<tr class="invisible_on_print">
								<th class="larger_font">DATE</th>
								<th class="larger_font">KIND</th>
								<th class="larger_font">DATE OF EXP.</th>
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

								<td class="{{ $immunization_date_1 != null ? 'larger_font' : 'empty_cell_large' }}">{{ $immunization_date_1 }}</td>
								<td class="{{ $immunization_kind_1 != null ? 'larger_font' : 'empty_cell_large' }}">{{ $immunization_kind_1 }}</td>
								<td class="{{ $immunization_date_of_expiration_1 != null ? 'larger_font' : 'empty_cell_large' }}">{{ $immunization_date_of_expiration_1 }}</td>
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

								<td class="{{ $immunization_date_2 != null ? 'larger_font' : 'empty_cell_large' }}">{{ $immunization_date_2 }}</td>
								<td class="{{ $immunization_kind_2 != null ? 'larger_font' : 'empty_cell_large' }}">{{ $immunization_kind_2 }}</td>
								<td class="{{ $immunization_date_of_expiration_2 != null ? 'larger_font' : 'empty_cell_large' }}">{{ $immunization_date_of_expiration_2 }}</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="table_wrapper text-center">
					<div class="standard_font invisible_on_print"><b>X-RAY, SPUTUM EXAM</b></div>

					<table class="no_borders">
						<thead>
							<tr class="invisible_on_print">
								<th class="larger_font">DATE</th>
								<th class="larger_font">KIND</th>
								<th class="larger_font">RESULT</th>
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

								<td class="{{ $xray_sputum_exam_date_1 != null ? 'larger_font' : 'empty_cell_large' }}">{{ $xray_sputum_exam_date_1 }}</td>
								<td class="{{ $xray_sputum_exam_kind_1 != null ? 'larger_font' : 'empty_cell_large' }}">{{-- $xray_sputum_exam_kind_1 --}}</td>
								<td class="{{ $xray_sputum_exam_result_1 != null ? 'larger_font' : 'empty_cell_large' }}">{{-- $xray_sputum_exam_result_1 --}}</td>
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

								<td class="{{ $xray_sputum_exam_date_2 != null ? 'larger_font' : 'empty_cell_large' }}">{{ $xray_sputum_exam_date_2 }}</td>
								<td class="{{ $xray_sputum_exam_kind_2 != null ? 'larger_font' : 'empty_cell_large' }}">{{ $xray_sputum_exam_kind_2 }}</td>
								<td class="{{ $xray_sputum_exam_result_2 != null ? 'larger_font' : 'empty_cell_large' }}">{{ $xray_sputum_exam_result_2 }}</td>
							</tr>
						</tbody>
					</table>
				</div>

				<div class="table_wrapper text-center">
					<div class="standard_font invisible_on_print"><b>STOOL AND OTHER EXAM</b></div>

					<table class="no_borders">
						<thead>
							<tr class="invisible_on_print">
								<th class="larger_font">DATE</th>
								<th class="larger_font">KIND</th>
								<th class="larger_font">RESULT</th>
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

								<td class="{{ $stool_and_other_exam_date_1 != null ? 'larger_font' : 'empty_cell_large' }}">{{ $stool_and_other_exam_date_1 }}</td>
								<td class="{{ $stool_and_other_exam_kind_1 != null ? 'larger_font' : 'empty_cell_large' }}">{{-- $stool_and_other_exam_kind_1 --}}</td>
								<td class="{{ $stool_and_other_exam_result_1 != null ? 'larger_font' : 'empty_cell_large' }}">{{-- $stool_and_other_exam_result_1 --}}</td>
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

								<td class="{{ $stool_and_other_exam_date_2 != null ? 'larger_font' : 'empty_cell_large' }}">{{ $stool_and_other_exam_date_2 }}</td>
								<td class="{{ $stool_and_other_exam_kind_2 != null ? 'larger_font' : 'empty_cell_large' }}">{{-- $stool_and_other_exam_kind_2 --}}</td>
								<td class="{{ $stool_and_other_exam_result_2 != null ? 'larger_font' : 'empty_cell_large' }}">{{-- $stool_and_other_exam_result_2 --}}</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>