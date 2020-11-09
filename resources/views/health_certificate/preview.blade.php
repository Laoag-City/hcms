<!DOCTYPE html>
<html>
<head>
	<meta name="author" content="Russell James F. Bello">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>window.Laravel = {!! json_encode(['csrfToken' => csrf_token(), ]) !!};</script>
	<title>Health Certificate - Front</title>

	<link rel="stylesheet" href="{{ mix('/css/camera.css') }}">
</head>
<body>
	@php
		$picture = $health_certificate->applicant->picture;
		$url = url("applicant/{$health_certificate->applicant->applicant_id}/picture");
	@endphp

	<div class="no-print">
		<br>
		<button onclick="window.location.replace('{{ url()->previous() }}')">GO BACK</button>
		<button id="print_back" class="pull_right print hidden" style="margin-left: 10px;">PRINT (BACK)</button>
		<button id="print_front" class="pull_right print hidden">PRINT (FRONT)</button>
		<br>
		<br>
		<button id="take_picture" class="hidden">TAKE PICTURE</button>
		<button id="retake_picture" class="hidden">RETAKE PICTURE</button>
		<button id="save_picture" class="pull_right hidden">SAVE PICTURE</button>
		<hr>

		<h3 class="text-center camera_certificate_header">Camera Output</h3>
		<div id="camera"></div>
	</div>

	<div id="certificates-wrapper" class="text-center">
		<div style="display: inline-block;">
			<div style="float: left;">
				<h3 class="text-center no-print camera_certificate_header">Front Preview</h3>
				<div id="front_preview" class="health_certificate">
					<div id="outer_border">
						<div id="inner_border">
							<div id="contents">
								<div id="header_1">
									<img id="logo" src="/doh_logo.png" class="pull_left">

									<p class="text_right standard_font"><b>EHS Form No. 102-A-B</b></p>
									<p class="text_right" style="font-size: 10.9pt;"><b>DEPARTMENT OF HEALTH</b></p>
									<p class="text-center standard_font"><b>Office of the City Health Officer</b></p>
									<p class="text-center standard_font"><b>LAOAG CITY</b></p>
									<div style="margin: 0pt auto 0pt auto; width: 124pt; border-top: .5625pt solid black; overflow: auto;"></div>
								</div>

								<div id="header_2" class="text_right">
									<div class="label smaller_font">Reg. No.</div><div id="reg_number" class="smaller_font field">{{ $health_certificate->registration_number }}</div>
									<h4 id="h4_front" class="no_margin text-center" style="margin-top: 4.5pt;">HEALTH CERTIFICATE</h4>
								</div>

								<div>
									<p class="text-justify no_margin" style="margin-top: 4.5pt; font-size: 8.45pt;">
										Pursuant to the provisions of P. D. 522 and 856 and City Ord. No 1057 S 85, this certificate is issued to
									</p>
								</div>

								<div style="margin-top: 4.5pt;">
									<div class="label smaller_font">Name</div><div id="name" class="smaller_font field">{{ $health_certificate->applicant->formatName() }}</div>
								</div>

								<div style="margin-top: 4.5pt;">
									<div class="label smaller_font">Age</div><div id="age" class="smaller_font field">{{ $health_certificate->applicant->age }}</div>
									<div class="label smaller_font">Sex</div><div id="sex" class="smaller_font field">{{ $health_certificate->applicant->gender == 1 ? 'M' : 'F' }}</div>
									<div class="label smaller_font">Work Type</div><div id="work_type" class="smaller_font field">{{ $health_certificate->work_type }}</div>
								</div>

								<div style="margin-top: 4.5pt;">
									<div class="label smaller_font">Establishment</div><div id="establishment" class="smaller_font field">{{ $health_certificate->establishment }}</div>
								</div>

								<div style="margin-top: 9pt;">
									<img {{ $picture == null ?: "src=$url"}} id="picture" class="pull_left">

									<div class="pull_right" style="margin-top: 4.5pt;">
										<div id="signature_si_in_charge" class="standard_font field" style="border-bottom: 0.7625pt solid black;"></div>
										<i class="label standard_font text-center" style="display: block;">Signature</i>
									</div>

									<div class="pull_right" style="margin-top: 9pt;">
										<div id="signature_si_in_charge" class="standard_font field" style="border-bottom: 0.7625pt solid black;"></div>
										<i class="label standard_font text-center" style="display: block;">CSO/SI In-Charge</i>
									</div>

									<div class="pull_right" style="margin-top: 9pt;">
										<b class="label standard_font text-center" style="display: block; width: 110pt;">RENATO R. MATEO, M.D.</b>
										<div class="label standard_font text-center" style="display: block;">City Health Officer</div>
									</div>
								</div>

								<div class="standard_font" style="clear: left; margin-left: 15pt;">CHO-054-&#216;</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="no-print" style="width: 50px; height: 1px; float: left;"></div>
			
			<div style="float: left;">
				<h3 class="text-center no-print camera_certificate_header">Back Preview</h3>
				<div id="back_preview" class="health_certificate">
					<div id="outer_border">
						<div id="inner_border">
							<div id="contents">
								<div>
									<h4 id="h4_back" class="block_center text-center">IMPORTANT</h4>
								</div>

								<div>
									<p class="text-center standard_font no_margin" style="margin-top: 13.5pt;">
										THIS HEALTH CERTIFICATE IS NON-TRANSFERABLE. ALWAYS WEAR YOUR CERTIFICATE IN THE UPPER LEFT SIDE FRONT PORTION IN THE UPPER LEFT SIDE FRONT PORTION VALID ONLY UNTIL THE NEXT DATE OF EXAMINATION, AS INDICATED BELOW.
									</p>
								</div>

								<div class="text-center">
									<div style="display: inline-block;">
										<div class="field standard_font dates" style="margin-top: 15pt;">
											{{ $health_certificate->issuance_date }}
										</div>

										<div class="standard_font">
											Date of Issuance
										</div>
									</div>
									

									<div style="display: inline-block;">
										<div class="field standard_font dates" style="margin-top: 15pt;">
											{{ $health_certificate->expiration_date }}
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
			</div>
		</div>
	</div>
	
</body>
<script>
	var picture = '{{ $picture == null ?: "#print_front" }}';
	var id = {{ $health_certificate->health_certificate_id }};
</script>
<script src="/webcamjs/webcam.js"></script>
<script src="{{ mix('/js/app.js') }}"></script>
<script src="{{ mix('/js/camera.js') }}"></script>
</html>