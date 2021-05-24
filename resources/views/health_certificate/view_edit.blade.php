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
								<a href="{{ url("health_certificate/$health_certificate->health_certificate_id/preview") }}" target="_blank" class="ui inverted green button">Print Preview</a>
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
								<u>{{ $health_certificate->checkIfExpired() ? 'Expired' : 'Not Expired' }}</u>
							</h3>
						</div>
					</div>

					<div class="row">
						<div class="eight wide column">
							<h3>
								<i class="caret right icon"></i>
								<span style="font-weight: normal;">Certificate Validity:</span> 
								<u>{{ $health_certificate->duration }}</u>
							</h3>
						</div>

						<div class="eight wide column right aligned">
							<h3>
								<i class="caret right icon"></i>
								<span style="font-weight: normal;">Certificate Registration Number:</span> 
								<u>{{ $health_certificate->registration_number }}</u>
							</h3>
						</div>
					</div>
				</div>

				<div class="ui section divider"></div>

				<form method="POST" action="{{ url()->current() }}" class="ui form text_center {{ $errors->any() ? 'error' : 'success' }}">
					<h3 class="ui header">
						Edit Health Certificate
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
								<label><b>Edit Health Certificate</b></label>
								<input type="checkbox" name="update_mode" value="on" class="update_switches hidden" {{ !old('update_mode') ?: 'checked' }}>
							</div>
						</div>
					</div>

					<br>

					<div class="fields">
						<div class="one wide field"></div>

						<div class="two wide field
						{!! !$errors->has('age') ? '"' : ' error" data-content="' . $errors->first('age') . '" data-position="top center"' !!}>
							<label>Age:</label>
							<input type="number" name="age" value="{{ old('age') != null ? old('age') : $health_certificate->applicant->age }}" class="dynamic_input">
						</div>

						<div class="five wide field{!! !$errors->has('type_of_work') ? '"' : ' error" data-content="' . $errors->first('type_of_work') . '" data-position="top center"' !!}>
							<label>Type of Work:</label>
							<input type="text" name="type_of_work" value="{{ old('type_of_work') != null ? old('type_of_work') : $health_certificate->work_type }}" placeholder="Type of Work" class="dynamic_input">
						</div>

						<div class="seven wide field{!! !$errors->has('name_of_establishment') ? '"' : ' error" data-content="' . $errors->first('name_of_establishment') . '" data-position="top center"' !!}>
							<label>Name of Establishment:</label>
							<input type="text" name="name_of_establishment" value="{{ old('name_of_establishment') != null ? old('name_of_establishment') : $health_certificate->establishment }}" placeholder="Name of Establishment" class="dynamic_input">
						</div>
					</div>

					<br>

					<div class="fields">
						<div class="two wide field"></div>

						<div class="four wide field{!! !$errors->has('certificate_type') ? '"' : ' error" data-content="' . $errors->first('certificate_type') . '" data-position="top center"' !!}>
							<label>Certificate Type:</label>
							<select name="certificate_type" class="dynamic_input">
								<option value="" data-years="0" data-months="0" data-days="0"></option>

								@php
									if(old('certificate_type') != null)
										$type_value = old('certificate_type');
									else
										$type_value = $health_certificate->duration;
								@endphp

								@foreach($certificate_types as $type => $value)
									<option 
										value="{{ $value['string'] }}" {{ $type_value != $value['string'] ?: 'selected' }}
										data-years="{{ $value['years'] }}"
										data-months="{{ $value['months'] }}"
										data-days="{{ $value['days'] }}"
									>
										{{ "$type - {$value['string']}" }}
									</option>
								@endforeach
							</select>
						</div>

						<div class="four wide field{!! !$errors->has('date_of_issuance') ? '"' : ' error" data-content="' . $errors->first('date_of_issuance') . '" data-position="top center"' !!}>
				    		<label>Date of Issuance:</label>
				    		<input type="date" name="date_of_issuance" value="{{ old('date_of_issuance') != null ? old('date_of_issuance') : $health_certificate->dateToInput('issuance_date') }}" placeholder="Date of Issuance" class="dynamic_input">
				    	</div>

				    	<div class="four wide field{!! !$errors->has('date_of_expiration') ? '"' : ' error" data-content="' . $errors->first('date_of_expiration') . '" data-position="top center"' !!}>
				    		<label>Date of Expiration:</label>
				    		<input type="date" name="date_of_expiration" value="{{ old('date_of_expiration') != null ? old('date_of_expiration') : $health_certificate->dateToInput('expiration_date') }}" placeholder="Date of Issuance" class="dynamic_input">
				    	</div>
					</div>

					<br>

					@if($errors->has('general_table_error'))
						<div class="ui error message">
							<p>{{ $errors->first('general_table_error') }}</p>
						</div>
					@endif

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
							<tr>
								<td>1</td>

								@php
									if(isset($immunization[0]) && $immunization[0]->row_number == 1)
									{
										$immunization_date_1 = $immunization[0]->dateToInput('date');
										$immunization_kind_1 = $immunization[0]->kind;
										$immunization_date_of_expiration_1 = $immunization[0]->dateToInput('expiration_date');
									}

									elseif(isset($immunization[1]) && $immunization[1]->row_number == 1)
									{
										$immunization_date_1 = $immunization[1]->dateToInput('date');
										$immunization_kind_1 = $immunization[1]->kind;
										$immunization_date_of_expiration_1 = $immunization[1]->dateToInput('expiration_date');
									}

									else
									{
										$immunization_date_1 = null;
										$immunization_kind_1 = null;
										$immunization_date_of_expiration_1 = null;
									}
								@endphp

								<td class="field{!! !$errors->has('immunization_date_1') ? '"' : ' error" data-content="' . $errors->first('immunization_date_1') . '" data-position="top center"' !!}>
									<input type="date" name="immunization_date_1" value="{{ old('immunization_date_1') != null ? old('immunization_date_1') : $immunization_date_1 }}" class="dynamic_input">
								</td>

								<td class="field{!! !$errors->has('immunization_kind_1') ? '"' : ' error" data-content="' . $errors->first('immunization_kind_1') . '" data-position="top center"' !!}>
									<input type="text" name="immunization_kind_1" value="{{ old('immunization_kind_1') != null ? old('immunization_kind_1') : $immunization_kind_1 }}" class="dynamic_input">
								</td>

								<td class="field{!! !$errors->has('immunization_date_of_expiration_1')? '"' :' error" data-content="' . $errors->first('immunization_date_of_expiration_1') . '" data-position="top center"' !!}>
									<input type="date" name="immunization_date_of_expiration_1" value="{{ old('immunization_date_of_expiration_1') != null ? old('immunization_date_of_expiration_1') : $immunization_date_of_expiration_1 }}" class="dynamic_input">
								</td>
							</tr>

							<tr>
								<td>2</td>

								@php
									if(isset($immunization[0]) && $immunization[0]->row_number == 2)
									{
										$immunization_date_2 = $immunization[0]->dateToInput('date');
										$immunization_kind_2 = $immunization[0]->kind;
										$immunization_date_of_expiration_2 = $immunization[0]->dateToInput('expiration_date');
									}

									elseif(isset($immunization[1]) && $immunization[1]->row_number == 2)
									{
										$immunization_date_2 = $immunization[1]->dateToInput('date');
										$immunization_kind_2 = $immunization[1]->kind;
										$immunization_date_of_expiration_2 = $immunization[1]->dateToInput('expiration_date');
									}

									else
									{
										$immunization_date_2 = null;
										$immunization_kind_2 = null;
										$immunization_date_of_expiration_2 = null;
									}
								@endphp

								<td class="field{!! !$errors->has('immunization_date_2') ? '"' : ' error" data-content="' . $errors->first('immunization_date_2') . '" data-position="top center"' !!}>
									<input type="date" name="immunization_date_2" value="{{ old('immunization_date_2') != null ? old('immunization_date_2') : $immunization_date_2 }}" class="dynamic_input">
								</td>

								<td class="field{!! !$errors->has('immunization_kind_2') ? '"' : ' error" data-content="' . $errors->first('immunization_kind_2') . '" data-position="top center"' !!}>
									<input type="text" name="immunization_kind_2" value="{{ old('immunization_kind_2') != null ? old('immunization_kind_2') : $immunization_kind_2 }}" class="dynamic_input">
								</td>

								<td class="field{!! !$errors->has('immunization_date_of_expiration_2')? '"' :' error" data-content="' . $errors->first('immunization_date_of_expiration_2') . '" data-position="top center"' !!}>
									<input type="date" name="immunization_date_of_expiration_2" value="{{ old('immunization_date_of_expiration_2') != null ? old('immunization_date_of_expiration_2') : $immunization_date_of_expiration_2 }}" class="dynamic_input">
								</td>
							</tr>
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
							<tr>
								<td>1</td>

								@php
									if(isset($xray_sputum[0]) && $xray_sputum[0]->row_number == 1)
									{
										$xray_sputum_exam_date_1 = $xray_sputum[0]->dateToInput('date');
										$xray_sputum_exam_kind_1 = $xray_sputum[0]->kind;
										$xray_sputum_exam_result_1 = $xray_sputum[0]->result;
									}

									elseif(isset($xray_sputum[1]) && $xray_sputum[1]->row_number == 1)
									{
										$xray_sputum_exam_date_1 = $xray_sputum[1]->dateToInput('date');
										$xray_sputum_exam_kind_1 = $xray_sputum[1]->kind;
										$xray_sputum_exam_result_1 = $xray_sputum[1]->result;
									}

									else
									{
										$xray_sputum_exam_date_1 = null;
										$xray_sputum_exam_kind_1 = null;
										$xray_sputum_exam_result_1 = null;
									}
								@endphp

								<td class="field{!! !$errors->has('x-ray_sputum_exam_date_1') ? '"' : ' error" data-content="' . $errors->first('x-ray_sputum_exam_date_1') . '" data-posimmunization->ition="top center"' !!}>
									<input type="date" name="x-ray_sputum_exam_date_1" value="{{ old('x-ray_sputum_exam_date_1') != null ? old('x-ray_sputum_exam_date_1') : $xray_sputum_exam_date_1 }}" class="dynamic_input">
								</td>

								<td class="field{!! !$errors->has('x-ray_sputum_exam_kind_1') ? '"' : ' error" data-content="' . $errors->first('x-ray_sputum_exam_kind_1') . '" data-position="top center"' !!}>
									<input type="text" name="x-ray_sputum_exam_kind_1" value="SPUTUM{{-- old('x-ray_sputum_exam_kind_1') != null ? old('x-ray_sputum_exam_kind_1') : $xray_sputum_exam_kind_1 --}}" readonly="">
								</td>

								<td class="field{!! !$errors->has('x-ray_sputum_exam_result_1') ? '"' : ' error" data-content="' . $errors->first('x-ray_sputum_exam_result_1') . '" data-position="top center"' !!}>
									<input type="text" name="x-ray_sputum_exam_result_1" value="NEG ( - ){{-- old('x-ray_sputum_exam_result_1') != null ? old('x-ray_sputum_exam_result_1') : $xray_sputum_exam_result_1 --}}" readonly="">
								</td>
							</tr>

							<tr>
								<td>2</td>

								@php
									if(isset($xray_sputum[0]) && $xray_sputum[0]->row_number == 2)
									{
										$xray_sputum_exam_date_2 = $xray_sputum[0]->dateToInput('date');
										$xray_sputum_exam_kind_2 = $xray_sputum[0]->kind;
										$xray_sputum_exam_result_2 = $xray_sputum[0]->result;
									}

									elseif(isset($xray_sputum[1]) && $xray_sputum[1]->row_number == 2)
									{
										$xray_sputum_exam_date_2 = $xray_sputum[1]->dateToInput('date');
										$xray_sputum_exam_kind_2 = $xray_sputum[1]->kind;
										$xray_sputum_exam_result_2 = $xray_sputum[1]->result;
									}

									else
									{
										$xray_sputum_exam_date_2 = null;
										$xray_sputum_exam_kind_2 = null;
										$xray_sputum_exam_result_2 = null;
									}
								@endphp

								<td class="field{!! !$errors->has('x-ray_sputum_exam_date_2') ? '"' : ' error" data-content="' . $errors->first('x-ray_sputum_exam_date_2') . '" data-position="top center"' !!}>
									<input type="date" name="x-ray_sputum_exam_date_2" value="{{ old('x-ray_sputum_exam_date_2') != null ? old('x-ray_sputum_exam_date_2') : $xray_sputum_exam_date_2 }}" class="dynamic_input">
								</td>

								<td class="field{!! !$errors->has('x-ray_sputum_exam_kind_2') ? '"' : ' error" data-content="' . $errors->first('x-ray_sputum_exam_kind_2') . '" data-position="top center"' !!}>
									<input type="text" name="x-ray_sputum_exam_kind_2" value="{{ old('x-ray_sputum_exam_kind_2') != null ? old('x-ray_sputum_exam_kind_2') : $xray_sputum_exam_kind_2 }}" class="dynamic_input">
								</td>

								<td class="field{!! !$errors->has('x-ray_sputum_exam_result_2') ? '"' : ' error" data-content="' . $errors->first('x-ray_sputum_exam_result_2') . '" data-position="top center"' !!}>
									<input type="text" name="x-ray_sputum_exam_result_2" value="{{ old('x-ray_sputum_exam_result_2') != null ? old('x-ray_sputum_exam_result_2') : $xray_sputum_exam_result_2 }}" class="dynamic_input">
								</td>
							</tr>
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
							<tr>
								<td>1</td>

								@php
									if(isset($stool_and_others[0]) && $stool_and_others[0]->row_number == 1)
									{
										$stool_and_other_exam_date_1 = $stool_and_others[0]->dateToInput('date');
										$stool_and_other_exam_kind_1 = $stool_and_others[0]->kind;
										$stool_and_other_exam_result_1 = $stool_and_others[0]->result;
									}

									elseif(isset($stool_and_others[1]) && $stool_and_others[1]->row_number == 1)
									{
										$stool_and_other_exam_date_1 = $stool_and_others[1]->dateToInput('date');
										$stool_and_other_exam_kind_1 = $stool_and_others[1]->kind;
										$stool_and_other_exam_result_1 = $stool_and_others[1]->result;
									}

									else
									{
										$stool_and_other_exam_date_1 = null;
										$stool_and_other_exam_kind_1 = null;
										$stool_and_other_exam_result_1 = null;
									}
								@endphp

								<td class="field{!! !$errors->has('stool_and_other_exam_date_1') ? '"' : ' error" data-content="' . $errors->first('stool_and_other_exam_date_1') . '" data-position="top center"' !!}>
									<input type="date" name="stool_and_other_exam_date_1" value="{{ old('stool_and_other_exam_date_1') != null ? old('stool_and_other_exam_date_1') : $stool_and_other_exam_date_1 }}" class="dynamic_input">
								</td>

								<td class="field{!! !$errors->has('stool_and_other_exam_kind_1') ? '"' : ' error" data-content="' . $errors->first('stool_and_other_exam_kind_1') . '" data-position="top center"' !!}>
									<input type="text" name="stool_and_other_exam_kind_1" value="STOOL{{-- old('stool_and_other_exam_kind_1') != null ? old('stool_and_other_exam_kind_1') : $stool_and_other_exam_kind_1 --}}" readonly="">
								</td>

								<td class="field{!! !$errors->has('stool_and_other_exam_result_1') ? '"' : ' error" data-content="' . $errors->first('stool_and_other_exam_result_1') . '" data-position="top center"' !!}>
									<input type="text" name="stool_and_other_exam_result_1" value="NOPS{{-- old('stool_and_other_exam_result_1') != null ? old('stool_and_other_exam_result_1') : $stool_and_other_exam_result_1 --}}" readonly="">
								</td>
							</tr>

							<tr>
								<td>2</td>

								@php
									if(isset($stool_and_others[0]) && $stool_and_others[0]->row_number == 2)
									{
										$stool_and_other_exam_date_2 = $stool_and_others[0]->dateToInput('date');
										$stool_and_other_exam_kind_2 = $stool_and_others[0]->kind;
										$stool_and_other_exam_result_2 = $stool_and_others[0]->result;
									}

									elseif(isset($stool_and_others[1]) && $stool_and_others[1]->row_number == 2)
									{
										$stool_and_other_exam_date_2 = $stool_and_others[1]->dateToInput('date');
										$stool_and_other_exam_kind_2 = $stool_and_others[1]->kind;
										$stool_and_other_exam_result_2 = $stool_and_others[1]->result;
									}

									else
									{
										$stool_and_other_exam_date_2 = null;
										$stool_and_other_exam_kind_2 = null;
										$stool_and_other_exam_result_2 = null;
									}
								@endphp

								<td class="field{!! !$errors->has('stool_and_other_exam_date_2') ? '"' : ' error" data-content="' . $errors->first('stool_and_other_exam_date_2') . '" data-position="top center"' !!}>
									<input type="date" name="stool_and_other_exam_date_2" value="{{ old('stool_and_other_exam_date_2') != null ? old('stool_and_other_exam_date_2') : $stool_and_other_exam_date_2 }}" class="dynamic_input">
								</td>

								<td class="field{!! !$errors->has('stool_and_other_exam_kind_2') ? '"' : ' error" data-content="' . $errors->first('stool_and_other_exam_kind_2') . '" data-position="top center"' !!}>
									<input type="text" name="stool_and_other_exam_kind_2" value="URINE{{-- old('stool_and_other_exam_kind_2') != null ? old('stool_and_other_exam_kind_2') : $stool_and_other_exam_kind_2 --}}" readonly="">
								</td>

								<td class="field{!! !$errors->has('stool_and_other_exam_result_2') ? '"' : ' error" data-content="' . $errors->first('stool_and_other_exam_result_2') . '" data-position="top center"' !!}>
									<input type="text" name="stool_and_other_exam_result_2" value="NORMAL{{-- old('stool_and_other_exam_result_2') != null ? old('stool_and_other_exam_result_2') : $stool_and_other_exam_result_2 --}}" readonly="">
								</td>
							</tr>
						</tbody>
					</table>

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

<script src="{{ mix('/js/health_certificate_information.js') }}"></script>

@endsection