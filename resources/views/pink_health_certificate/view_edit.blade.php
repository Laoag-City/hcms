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
			<div class="fourteen wide column"><!--main column-->
				<div class="ui stackable centered grid">
					<div class="row">
						<div class="sixteen wide column">
							<div class="ui two buttons">
								<a href="{{ url()->previous() }}" class="ui inverted blue button">Back</a>
								<a href="{{ url("pink_card/$pink_health_certificate->pink_health_certificate_id/preview") }}" class="ui inverted green button">Print Preview</a>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="three wide column" style="text-align: center;">
							<img height="129" width="129" src="{{ $picture_url ? $picture_url : url("/noPicAvailable.png") }}">
						</div>
					</div>

					<div class="row">
						<div class="ten wide column"><!--nested columns-->
							<h3>
								<i class="caret right icon"></i>
								<span style="font-weight: normal;">Name:</span> 
								<u>{{ $applicant->formatName() }}</u>
							</h3>
						</div>

						<div class="six wide column right aligned">
							<h3>
								<i class="caret right icon"></i>
								<span style="font-weight: normal;">Certificate Status:</span> 
								<u>{{ $pink_health_certificate->checkIfExpired() ? 'Expired' : 'Not Expired' }}</u>
							</h3>
						</div>
					</div>

					<div class="row">
						<div class="eight wide column">
							<h3>
								<i class="caret right icon"></i>
								<span style="font-weight: normal;">Certificate Validity:</span> 
								<u>{{ $pink_health_certificate->validity_period }}</u>
							</h3>
						</div>

						<div class="eight wide column right aligned">
							<h3>
								<i class="caret right icon"></i>
								<span style="font-weight: normal;">Certificate Registration Number:</span> 
								<u>{{ $pink_health_certificate->registration_number }}</u>
							</h3>
						</div>
					</div>

					<div class="row">
						<div class="sixteen wide column">
							<h3>
								<i class="caret right icon"></i>
								<span style="font-weight: normal;">Nationality:</span> 
								<u>{{ $applicant->nationality }}</u>
							</h3>
						</div>
					</div>
				</div>

				<div class="ui section divider"></div>

				<form method="POST" action="{{ url()->current() }}" class="ui form text_center {{ $errors->any() ? 'error' : 'success' }}">
					<h3 class="ui header">
						Pink Card
					</h3>

					<br>

					{{ csrf_field() }}
					{{ method_field('PUT') }}

					@if(session('success') != NULL)
						<div class="ui success message">
							<div class="header">{{ session('success')['header'] }}</div>

							<p>{{ session('success')['message'] }}</p>
						</div>
					@endif

					<div class="fields">
						<div class="five wide field"></div>

						<div class="six wide inline field">
							<div class="ui toggle checkbox">
								<label><b>Edit Pink Card</b></label>
								<input type="checkbox" name="update_mode" value="on" class="update_switches hidden" {{ !old('update_mode') ?: 'checked' }}>
							</div>
						</div>
					</div>

					<br>

					<div class="fields">
						<div class="three wide field"></div>

						<div class="two wide field{!! !$errors->has('age') ? '"' : ' error" data-content="' . $errors->first('age') . '" data-position="top center"' !!}>
							<label>Age:</label>
							<input type="number" name="age" value="{{ old('age') ? old('age') : $pink_health_certificate->applicant->age }}" class="dynamic_input">
						</div>

						<div class="four wide field{!! !$errors->has('occupation') ? '"' : ' error" data-content="' . $errors->first('occupation') . '" data-position="top center"' !!}>
							<label>Occupation:</label>
							<input type="text" name="occupation" value="{{ old('occupation') ? old('occupation') : $pink_health_certificate->occupation }}" placeholder="Occupation" class="dynamic_input">
						</div>

						<div class="four wide field{!! !$errors->has('place_of_work') ? '"' : ' error" data-content="' . $errors->first('place_of_work') . '" data-position="top center"' !!}>
							<label>Place of Work:</label>
							<input type="text" name="place_of_work" value="{{ old('place_of_work') ? old('place_of_work') : $pink_health_certificate->place_of_work }}" placeholder="Place of Work" class="dynamic_input">
						</div>
					</div>

					<br>

					<div class="fields">
						<div class="four wide field"></div>

						<div class="four wide field{!! !$errors->has('date_of_issuance') ? '"' : ' error" data-content="' . $errors->first('date_of_issuance') . '" data-position="top center"' !!}>
				    		<label>Date of Issuance:</label>
				    		<input type="date" name="date_of_issuance" value="{{ old('date_of_issuance') ? old('date_of_issuance') : $pink_health_certificate->dateToInput('issuance_date') }}" placeholder="Date of Issuance" class="dynamic_input">
				    	</div>

				    	<div class="four wide field{!! !$errors->has('date_of_expiration') ? '"' : ' error" data-content="' . $errors->first('date_of_expiration') . '" data-position="top center"' !!}>
				    		<label>Date of Expiration:</label>
				    		<input type="date" name="date_of_expiration" value="{{ old('date_of_expiration') ? old('date_of_expiration') : $pink_health_certificate->dateToInput('expiration_date') }}" placeholder="Date of Issuance" class="dynamic_input">
				    	</div>
					</div>

					<br>

					<div class="fields">
						<div class="two wide field"></div>

						<div class="four wide field{!! !$errors->has('community_tax_no') ? '"' : ' error" data-content="' . $errors->first('community_tax_no') . '" data-position="top center"' !!}>
							<label>Community Tax No:</label>
							<input type="text" name="community_tax_no" value="{{ old('community_tax_no') ? old('community_tax_no') : $pink_health_certificate->community_tax_no }}" placeholder="Community Tax No" class="dynamic_input">
						</div>

						<div class="four wide field{!! !$errors->has('community_tax_issued_at') ? '"' : ' error" data-content="' . $errors->first('community_tax_issued_at') . '" data-position="top center"' !!}>
				    		<label>Community Tax Issued At:</label>
				    		<input type="text" name="community_tax_issued_at" value="{{ old('community_tax_issued_at') ? old('community_tax_issued_at') : $pink_health_certificate->community_tax_issued_at }}" placeholder="Community Tax Issued At" class="dynamic_input">
				    	</div>

				    	<div class="four wide field{!! !$errors->has('community_tax_issued_on') ? '"' : ' error" data-content="' . $errors->first('community_tax_issued_on') . '" data-position="top center"' !!}>
				    		<label>Community Tax Issued On:</label>
				    		<input type="date" name="community_tax_issued_on" value="{{ old('community_tax_issued_on') ? old('community_tax_issued_on') : $pink_health_certificate->community_tax_issued_on }}" class="dynamic_input">
				    	</div>
					</div>

					<br>

					<div class="ui horizontal divider">IMMUNIZATION</div>

					<table id="table_1" class="ui center aligned selectable celled definition table">
						<thead class="full-width">
							<tr>
								<th></th>
								<th>Date</th>
								<th>Kind</th>
								<th>Date of Expiration</th>
							</tr>
						</thead>

						<tbody>
							@foreach($immunizations as $immunization)
								<tr>
									@php
										if($immunization->immunization_id)
										{
											$column_one = old("immunization_date_$loop->iteration") ? old("immunization_date_$loop->iteration") : $immunization->dateToInput('date');
											$column_two = old("immunization_kind_$loop->iteration") ? old("immunization_kind_$loop->iteration") : $immunization->kind;
											$column_three = old("immunization_date_of_expiration_$loop->iteration") ? old("immunization_date_of_expiration_$loop->iteration") : $immunization->dateToInput('expiration_date');
										}
										else
										{
											$column_one = old("immunization_date_$loop->iteration");
											$column_two = old("immunization_kind_$loop->iteration");
											$column_three = old("immunization_date_of_expiration_$loop->iteration");
										}
									@endphp

									<td>{{ $loop->iteration }}</td>

									<td class="field{!! !$errors->has('immunization_date_' . $loop->iteration) ? '"' : ' error" data-content="' . $errors->first('immunization_date_' . $loop->iteration) . '" data-position="top center"' !!}>
										<input type="date" name="immunization_date_{{ $loop->iteration }}" value="{{ $column_one }}" class="dynamic_input">
									</td>

									<td class="field{!! !$errors->has('immunization_kind_' . $loop->iteration) ? '"' : ' error" data-content="' . $errors->first('immunization_kind_' . $loop->iteration) . '" data-position="top center"' !!}>
										<input type="text" name="immunization_kind_{{ $loop->iteration }}" value="{{ $column_two }}" class="dynamic_input">
									</td>

									<td class="field{!! !$errors->has('immunization_date_of_expiration_' . $loop->iteration) ? '"' :' error" data-content="' . $errors->first('immunization_date_of_expiration_' . $loop->iteration) . '" data-position="top center"' !!}>
										<input type="date" name="immunization_date_of_expiration_{{ $loop->iteration }}" value="{{ $column_three }}" class="dynamic_input">
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>

					<br>
					<div class="ui horizontal divider">X-RAY, SPUTUM EXAM</div>

					<table id="table_2" class="ui center aligned selectable celled definition table">
						<thead class="full-width">
							<tr>
								<th></th>
								<th>Date</th>
								<th>Kind</th>
								<th>Result</th>
							</tr>
						</thead>

						<tbody>
							@foreach($xray_sputums as $xray_sputum)
								<tr>
									@php
										if($xray_sputum->{'x-ray_sputum_id'})
										{
											$column_one = old("x-ray_sputum_exam_date_$loop->iteration") ? old("x-ray_sputum_exam_date_$loop->iteration") : $xray_sputum->dateToInput('date');
											$column_two = old("x-ray_sputum_exam_kind_$loop->iteration") ? old("x-ray_sputum_exam_kind_$loop->iteration") : $xray_sputum->kind;
											$column_three = old("x-ray_sputum_exam_result_$loop->iteration") ? old("x-ray_sputum_exam_result_$loop->iteration") : $xray_sputum->result;
										}
										else
										{
											$column_one = old("x-ray_sputum_exam_date_$loop->iteration");
											$column_two = old("x-ray_sputum_exam_kind_$loop->iteration");
											$column_three = old("x-ray_sputum_exam_result_$loop->iteration");
										}
									@endphp

									<td>{{ $loop->iteration }}</td>

									<td class="field{!! !$errors->has('x-ray_sputum_exam_date_' . $loop->iteration) ? '"' : ' error" data-content="' . $errors->first('x-ray_sputum_exam_date_' . $loop->iteration) . '" data-position="top center"' !!}>
										<input type="date" name="x-ray_sputum_exam_date_{{ $loop->iteration }}" value="{{ $column_one }}" class="dynamic_input">
									</td>

									<td class="field{!! !$errors->has('x-ray_sputum_exam_kind_' . $loop->iteration) ? '"' : ' error" data-content="' . $errors->first('x-ray_sputum_exam_kind_' . $loop->iteration) . '" data-position="top center"' !!}>
										<input type="text" name="x-ray_sputum_exam_kind_{{ $loop->iteration }}" value="{{ $column_two }}" class="dynamic_input">
									</td>

									<td class="field{!! !$errors->has('x-ray_sputum_exam_result_' . $loop->iteration) ? '"' : ' error" data-content="' . $errors->first('x-ray_sputum_exam_result_' . $loop->iteration) . '" data-position="top center"' !!}>
										<input type="text" name="x-ray_sputum_exam_result_{{ $loop->iteration }}" value="{{ $column_three }}" class="dynamic_input">
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>

					<br>
					<div class="ui horizontal divider">STOOL AND OTHER EXAM</div>

					<table id="table_3" class="ui center aligned selectable celled definition table">
						<thead class="full-width">
							<tr>
								<th></th>
								<th>Date</th>
								<th>Kind</th>
								<th>Result</th>
							</tr>
						</thead>

						<tbody>
							@foreach($stool_and_others as $stool_and_other)
								<tr>
									@php
										if($stool_and_other->stool_and_other_id)
										{
											$column_one = old("stool_and_other_exam_date_$loop->iteration") ? old("stool_and_other_exam_date_$loop->iteration") : $stool_and_other->dateToInput('date');
											$column_two = old("stool_and_other_exam_kind_$loop->iteration") ? old("stool_and_other_exam_kind_$loop->iteration") : $stool_and_other->kind;
											$column_three = old("stool_and_other_exam_result_$loop->iteration") ? old("stool_and_other_exam_result_$loop->iteration") : $stool_and_other->result;
										}
										else
										{
											$column_one = old("stool_and_other_exam_date_$loop->iteration");
											$column_two = old("stool_and_other_exam_kind_$loop->iteration");
											$column_three = old("stool_and_other_exam_result_$loop->iteration");
										}
									@endphp

									<td>{{ $loop->iteration }}</td>

									<td class="field{!! !$errors->has('stool_and_other_exam_date_' . $loop->iteration) ? '"' : ' error" data-content="' . $errors->first('stool_and_other_exam_date_' . $loop->iteration) . '" data-position="top center"' !!}>
										<input type="date" name="stool_and_other_exam_date_{{ $loop->iteration }}" value="{{ $column_one }}" class="dynamic_input">
									</td>

									<td class="field{!! !$errors->has('stool_and_other_exam_kind_' . $loop->iteration) ? '"' : ' error" data-content="' . $errors->first('stool_and_other_exam_kind_' . $loop->iteration) . '" data-position="top center"' !!}>
										<input type="text" name="stool_and_other_exam_kind_{{ $loop->iteration }}" value="{{ $column_two }}" class="dynamic_input">
									</td>

									<td class="field{!! !$errors->has('stool_and_other_exam_result_' . $loop->iteration) ? '"' : ' error" data-content="' . $errors->first('stool_and_other_exam_result_' . $loop->iteration) . '" data-position="top center"' !!}>
										<input type="text" name="stool_and_other_exam_result_{{ $loop->iteration }}" value="{{ $column_three }}" class="dynamic_input">
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					<!--pink card specific tables-->
					<br>
					<div class="ui horizontal divider">HIV Examination</div>

					<table id="table_4" class="ui center aligned selectable celled definition table">
						<thead class="full-width">
							<tr>
								<th></th>
								<th>Date</th>
								<th>Result</th>
								<th>Date of Next Exam</th>
							</tr>
						</thead>

						<tbody>
							@foreach($hivs as $hiv)
								<tr>
									@php
										if($hiv->hiv_examination_id)
										{
											$column_one = old("hiv_date_$loop->iteration") ? old("hiv_date_$loop->iteration") : $hiv->dateToInput('date_of_exam');
											$column_two = old("hiv_result_$loop->iteration") ? old("hiv_result_$loop->iteration") : $hiv->result;
											$column_three = old("hiv_date_of_next_exam_$loop->iteration") ? old("hiv_date_of_next_exam_$loop->iteration") : $hiv->dateToInput('date_of_next_exam');
										}
										else
										{
											$column_one = old("hiv_date_$loop->iteration");
											$column_two = old("hiv_result_$loop->iteration");
											$column_three = old("hiv_date_of_next_exam_$loop->iteration");
										}
									@endphp

									<td>{{ $loop->iteration }}</td>

									<td class="field{!! !$errors->has('hiv_date_' . $loop->iteration) ? '"' : ' error" data-content="' . $errors->first('hiv_date_' . $loop->iteration) . '" data-position="top center"' !!}>
										<input type="date" name="hiv_date_{{ $loop->iteration }}" value="{{ $column_one }}" class="dynamic_input">
									</td>

									<td class="field{!! !$errors->has('hiv_result_' . $loop->iteration) ? '"' : ' error" data-content="' . $errors->first('hiv_result_' . $loop->iteration) . '" data-position="top center"' !!}>
										<input type="text" name="hiv_result_{{ $loop->iteration }}" value="{{ $column_two }}" class="dynamic_input">
									</td>

									<td class="field{!! !$errors->has('hiv_date_of_next_exam_' . $loop->iteration) ? '"' :' error" data-content="' . $errors->first('hiv_date_of_next_exam_' . $loop->iteration) . '" data-position="top center"' !!}>
										<input type="date" name="hiv_date_of_next_exam_{{ $loop->iteration }}" value="{{ $column_three }}" class="dynamic_input">
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>

					<br>
					<div class="ui horizontal divider">HBsAg Examination</div>

					<table id="table_5" class="ui center aligned selectable celled definition table">
						<thead class="full-width">
							<tr>
								<th></th>
								<th>Date</th>
								<th>Result</th>
								<th>Date of Next Exam</th>
							</tr>
						</thead>

						<tbody>
							@foreach($hbsags as $hbsag)
								<tr>
									@php
										if($hbsag->hbsag_examination_id)
										{
											$column_one = old("hbsag_date_$loop->iteration") ? old("hbsag_date_$loop->iteration") : $hbsag->dateToInput('date_of_exam');
											$column_two = old("hbsag_result_$loop->iteration") ? old("hbsag_result_$loop->iteration") : $hbsag->result;
											$column_three = old("hbsag_date_of_next_exam_$loop->iteration") ? old("hbsag_date_of_next_exam_$loop->iteration") : $hbsag->dateToInput('date_of_next_exam');
										}
										else
										{
											$column_one = old("hbsag_date_$loop->iteration");
											$column_two = old("hbsag_result_$loop->iteration");
											$column_three = old("hbsag_date_of_next_exam_$loop->iteration");
										}
									@endphp

									<td>{{ $loop->iteration }}</td>

									<td class="field{!! !$errors->has('hbsag_date_' . $loop->iteration) ? '"' : ' error" data-content="' . $errors->first('hbsag_date_' . $loop->iteration) . '" data-position="top center"' !!}>
										<input type="date" name="hbsag_date_{{ $loop->iteration }}" value="{{ $column_one }}" class="dynamic_input">
									</td>

									<td class="field{!! !$errors->has('hbsag_result_' . $loop->iteration) ? '"' : ' error" data-content="' . $errors->first('hbsag_result_' . $loop->iteration) . '" data-position="top center"' !!}>
										<input type="text" name="hbsag_result_{{ $loop->iteration }}" value="{{ $column_two }}" class="dynamic_input">
									</td>

									<td class="field{!! !$errors->has('hbsag_date_of_next_exam_' . $loop->iteration) ? '"' :' error" data-content="' . $errors->first('hbsag_date_of_next_exam_' . $loop->iteration) . '" data-position="top center"' !!}>
										<input type="date" name="hbsag_date_of_next_exam_{{ $loop->iteration }}" value="{{ $column_three }}" class="dynamic_input">
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>

					<br>
					<div class="ui horizontal divider">VDRL Examination</div>

					<table id="table_6" class="ui center aligned selectable celled definition table">
						<thead class="full-width">
							<tr>
								<th></th>
								<th>Date</th>
								<th>Result</th>
								<th>Date of Next Exam</th>
							</tr>
						</thead>

						<tbody>
							@foreach($vdrls as $vdrl)
								<tr>
									@php
										if($vdrl->vdrl_examination_id)
										{
											$column_one = old("vdrl_date_$loop->iteration") ? old("vdrl_date_$loop->iteration") : $vdrl->dateToInput('date_of_exam');
											$column_two = old("vdrl_result_$loop->iteration") ? old("vdrl_result_$loop->iteration") : $vdrl->result;
											$column_three = old("vdrl_date_of_next_exam_$loop->iteration") ? old("vdrl_date_of_next_exam_$loop->iteration") : $vdrl->dateToInput('date_of_next_exam');
										}
										else
										{
											$column_one = old("vdrl_date_$loop->iteration");
											$column_two = old("vdrl_result_$loop->iteration");
											$column_three = old("vdrl_date_of_next_exam_$loop->iteration");
										}
									@endphp

									<td>{{ $loop->iteration }}</td>

									<td class="field{!! !$errors->has('vdrl_date_' . $loop->iteration) ? '"' : ' error" data-content="' . $errors->first('vdrl_date_' . $loop->iteration) . '" data-position="top center"' !!}>
										<input type="date" name="vdrl_date_{{ $loop->iteration }}" value="{{ $column_one }}" class="dynamic_input">
									</td>

									<td class="field{!! !$errors->has('vdrl_result_' . $loop->iteration) ? '"' : ' error" data-content="' . $errors->first('vdrl_result_' . $loop->iteration) . '" data-position="top center"' !!}>
										<input type="text" name="vdrl_result_{{ $loop->iteration }}" value="{{ $column_two }}" class="dynamic_input">
									</td>

									<td class="field{!! !$errors->has('vdrl_date_of_next_exam_' . $loop->iteration) ? '"' :' error" data-content="' . $errors->first('vdrl_date_of_next_exam_' . $loop->iteration) . '" data-position="top center"' !!}>
										<input type="date" name="vdrl_date_of_next_exam_{{ $loop->iteration }}" value="{{ $column_three }}" class="dynamic_input">
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>

					<br>
					<div class="ui horizontal divider">Cervical Smear Examination</div>

					<div style="max-height: 500px; overflow: scroll;">
						<table id="table_7" class="ui center aligned selectable celled definition table">
							<thead class="full-width">
								<tr>
									<th></th>
									<th>Date</th>
									<th>Initial</th>
									<th>Date of Next Exam</th>
								</tr>
							</thead>

							<tbody>
								@foreach($cervical_smears as $cervical_smear)
									<tr>
										@php
											if($cervical_smear->cervical_smear_examination_id)
											{
												$column_one = old("cervical_smear.$loop->iteration.date") ? old("cervical_smear.$loop->iteration.date") : $cervical_smear->dateToInput('date_of_exam');
												$column_two = old("cervical_smear.$loop->iteration.initial") ? old("cervical_smear.$loop->iteration.initial") : $cervical_smear->initial;
												$column_three = old("cervical_smear.$loop->iteration.date_of_next_exam") ? old("cervical_smear.$loop->iteration.date_of_next_exam") : $cervical_smear->dateToInput('date_of_next_exam');
											}
											else
											{
												$column_one = old("cervical_smear.$loop->iteration.date");
												$column_two = old("cervical_smear.$loop->iteration.initial");
												$column_three = old("cervical_smear.$loop->iteration.date_of_next_exam");
											}
										@endphp

										<td>{{ $loop->iteration }}</td>

										<td class="field{!! !$errors->has('cervical_smear.' . $loop->iteration . '.date') ? '"' : ' error" data-content="' . $errors->first('cervical_smear.' . $loop->iteration . '.date') . '" data-position="top center"' !!}>
											<input type="date" name="cervical_smear[{{ $loop->iteration }}][date]" value="{{ $column_one }}" class="dynamic_input">
										</td>

										<td class="field{!! !$errors->has('cervical_smear.' . $loop->iteration . '.initial') ? '"' : ' error" data-content="' . $errors->first('cervical_smear.' . $loop->iteration . '.initial') . '" data-position="top center"' !!}>
											<input type="text" name="cervical_smear[{{ $loop->iteration }}][initial]" value="{{ $column_two }}" class="dynamic_input">
										</td>

										<td class="field{!! !$errors->has('cervical_smear.' . $loop->iteration . '.date_of_next_exam')? '"' :' error" data-content="' . $errors->first('cervical_smear.' . $loop->iteration . '.date_of_next_exam') . '" data-position="top center"' !!}>
											<input type="date" name="cervical_smear[{{ $loop->iteration }}][date_of_next_exam]" value="{{ $column_three }}" class="dynamic_input">
										</td>
									</tr>
								@endforeach
							</tbody>
						</table>
					</div>
					
					<br>

					<div class="field">
						<button type="submit" id="update_button" class="ui fluid inverted blue button">
							Update
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@section('sub_custom_js')
<script>
	var validity = {!! $validity_period !!};
</script>
<script src="{{ mix('/js/pink_health_certificate_information.js') }}"></script>

@endsection