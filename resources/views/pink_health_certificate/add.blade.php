@extends('layouts.authenticated')

@section('sub_custom_css')

<link rel="stylesheet" href="{{ mix('/css/create_health_certificate.css') }}">

@endsection

@section('sub_content')
<div class="sixteen wide column center aligned">
	<div class="ui attached message">
		<h2 class="ui header">
			{{ $title }}
		</h2>
	</div>

	<div class="ui attached segment">
		<div class="ui stackable centered grid">
			<div class="fourteen wide column center aligned">
				<form id="health_certificate_form" method="POST" action="{{ url()->current() }}" class="ui form {{ $errors->any() ? 'error' : 'success' }}">
					{{ csrf_field() }}
					
					<br>

					<input type="hidden" name="id" class="dynamic_on_search" value="{{ old('id') }}">

					<div class="fields">
						<div class="two wide field"></div>

						<div class="three wide field">
							<div class="ui check checkbox">
								<label><b>Add Pink Card to Existing Client</b></label>
								<input type="checkbox" name="existing_client" {{ old('existing_client') == null ?: 'checked' }}>
							</div>
						</div>

						<div id="searchApplicant" class="six wide field ui fluid search{!! !$errors->has('whole_name') 
							? '" data-content="Type a client\'s name and choose from the suggestions below."' 
							: ' error" data-content="' . $errors->first('whole_name') . '"' !!} 
							data-position="top center">
								<label>Whole Name:</label>
								<input class="prompt" type="text" name="whole_name" value="{{ old('whole_name') }}" placeholder="Whole Name" {{ old('existing_client') == null ? 'disabled' : 'required' }}>
								<div class="results"></div>
						</div>
					</div>

					<br>

					<div class="fields">
							<div class="six wide field
							{!! !$errors->has('first_name') ? '"' : ' error" data-content="' . $errors->first('first_name') . '" data-position="top center"' !!}>
					    		<label>First Name:</label>
					    		<input type="text" name="first_name" value="{{ old('first_name') }}" class="dynamic_on_search dynamic_input" placeholder="First Name">
					    	</div>

					    	<div class="four wide field
					    	{!! !$errors->has('middle_name') ? '"' : ' error" data-content="' . $errors->first('middle_name') . '" data-position="top center"' !!}>
					    		<label>Middle Name:</label>
					    		<input type="text" name="middle_name" value="{{ old('middle_name') }}" class="dynamic_on_search dynamic_input" placeholder="Middle Name">
					    	</div>

					    	<div class="four wide field
					    	{!! !$errors->has('last_name') ? '"' : ' error" data-content="' . $errors->first('last_name') . '" data-position="top center"' !!}>
					    		<label>Last Name:</label>
					    		<input type="text" name="last_name" value="{{ old('last_name') }}" class="dynamic_on_search dynamic_input" placeholder="Last Name">
					    	</div>

					    	<div class="two wide field
					    	{!! !$errors->has('suffix_name') ? '"' : ' error" data-content="' . $errors->first('suffix_name') . '" data-position="top center"' !!}>
					    		<label>Suffix:</label>
					    		<select name="suffix_name" class="dynamic_on_search dynamic_select">
									<option value=""></option>
									<option value="Jr." {{ old('suffix_name') != 'Jr.' ?: 'selected' }}>Jr.</option>
									<option value="Sr." {{ old('suffix_name') != 'Sr.' ?: 'selected' }}>Sr.</option>
									<option value="I" {{ old('suffix_name') != 'I' ?: 'selected' }}>I</option>
									<option value="II" {{ old('suffix_name') != 'II' ?: 'selected' }}>II</option>
									<option value="III" {{ old('suffix_name') != 'III' ?: 'selected' }}>III</option>
									<option value="IV" {{ old('suffix_name') != 'IV' ?: 'selected' }}>IV</option>
									<option value="V" {{ old('suffix_name') != 'V' ?: 'selected' }}>V</option>
									<option value="VI" {{ old('suffix_name') != 'VI' ?: 'selected' }}>VI</option>
									<option value="VII" {{ old('suffix_name') != 'VII' ?: 'selected' }}>VII</option>
									<option value="VIII" {{ old('suffix_name') != 'VIII' ?: 'selected' }}>VIII</option>
									<option value="IX" {{ old('suffix_name') != 'IX' ?: 'selected' }}>IX</option>
									<option value="X" {{ old('suffix_name') != 'X' ?: 'selected' }}>X</option>
								</select>
					    	</div>
					</div>

					<br>

					<div class="fields">
						<div class="two wide field"></div>

						<div class="two wide field
						{!! !$errors->has('age') ? '"' : ' error" data-content="' . $errors->first('age') . '" data-position="top center"' !!}>
							<label>Age:</label>
							<input type="number" name="age" class="dynamic_on_search" value="{{ old('age') }}" min="15" max="100">
						</div>
						
						<div class="two wide field
						{!! !$errors->has('gender') ? '"' : ' error" data-content="' . $errors->first('gender') . '" data-position="top center"' !!}>
							<label>Gender:</label>
							<select name="gender" class="dynamic_on_search dynamic_select">
								<option value=""></option>
								<option value="1" {{ (string)old('gender') != '1' ?: 'selected' }}>Male</option>
								<option value="0" {{ (string)old('gender') != '0' ?: 'selected' }}>Female</option>
							</select>
						</div>

						<div class="four wide field
						{!! !$errors->has('occupation') ? '"' : ' error" data-content="' . $errors->first('occupation') . '" data-position="top center"' !!}>
							<label>Occupation:</label>
							<input type="text" name="occupation" value="{{ old('occupation') }}" placeholder="Occupation">
						</div>

						<div class="four wide field
						{!! !$errors->has('nationality') ? '"' : ' error" data-content="' . $errors->first('nationality') . '" data-position="top center"' !!}>
							<label>Nationality:</label>
							<input type="text" name="nationality" value="{{ old('nationality') ? old('nationality') : 'Filipino' }}" class="dynamic_on_search" placeholder="Nationality">
						</div>
					</div>

					<br>

					<div class="fields">
						<div class="one wide field"></div>

						<div class="six wide field
						{!! !$errors->has('place_of_work') ? '"' : ' error" data-content="' . $errors->first('place_of_work') . '" data-position="top center"' !!}>
							<label>Place of Work:</label>
							<input type="text" name="place_of_work" value="{{ old('place_of_work') }}" placeholder="Place of Work">
						</div>

				    	<div class="four wide field
				    	{!! !$errors->has('date_of_issuance') ? '"' : ' error" data-content="' . $errors->first('date_of_issuance') . '" data-position="top center"' !!}>
				    		<label>Date of Issuance:</label>
				    		<input type="date" name="date_of_issuance" value="{{ old('date_of_issuance') ? old('date_of_issuance') : date('Y-m-d', strtotime('now')) }}">
				    	</div>

				    	<div class="four wide field
				    	{!! !$errors->has('date_of_expiration') ? '"' : ' error" data-content="' . $errors->first('date_of_expiration') . '" data-position="top center"' !!}>
				    		<label>Date of Expiration:</label>
				    		<input type="date" name="date_of_expiration" value="{{ old('date_of_expiration') }}" readonly="">
				    	</div>
					</div>

					<br>

					<div class="fields">
						<div class="two wide field"></div>

						<div class="four wide field
						{!! !$errors->has('community_tax_no') ? '"' : ' error" data-content="' . $errors->first('community_tax_no') . '" data-position="top center"' !!}>
							<label>Community Tax No:</label>
							<input type="text" name="community_tax_no" value="{{ old('community_tax_no') }}" placeholder="Community Tax No">
						</div>

						<div class="four wide field
						{!! !$errors->has('community_tax_issued_at') ? '"' : ' error" data-content="' . $errors->first('community_tax_issued_at') . '" data-position="top center"' !!}>
				    		<label>Community Tax Issued At:</label>
				    		<input type="text" name="community_tax_issued_at" value="{{ old('community_tax_issued_at') ? old('community_tax_issued_at') : 'Laoag City' }}" placeholder="Community Tax Issued At">
				    	</div>

				    	<div class="four wide field
				    	{!! !$errors->has('community_tax_issued_on') ? '"' : ' error" data-content="' . $errors->first('community_tax_issued_on') . '" data-position="top center"' !!}>
				    		<label>Community Tax Issued On:</label>
				    		<input type="date" name="community_tax_issued_on" value="{{ old('community_tax_issued_on') }}">
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
							@for($i = 1; $i <= $immunization_rows; $i++)
								<tr>
									<td>{{ $i }}</td>

									<td class="field{!! !$errors->has('immunization_date_' . $i) ? '"' : ' error" data-content="' . $errors->first('immunization_date_' . $i) . '" data-position="top center"' !!}>
										<input type="date" name="immunization_date_{{ $i }}" value="{{ old('immunization_date_' . $i) }}">
									</td>

									<td class="field{!! !$errors->has('immunization_kind_' . $i) ? '"' : ' error" data-content="' . $errors->first('immunization_kind_' . $i) . '" data-position="top center"' !!}>
										<input type="text" name="immunization_kind_{{ $i }}" value="{{ old('immunization_kind_' . $i) }}">
									</td>

									<td class="field{!! !$errors->has('immunization_date_of_expiration_' . $i) ? '"' :' error" data-content="' . $errors->first('immunization_date_of_expiration_' . $i) . '" data-position="top center"' !!}>
										<input type="date" name="immunization_date_of_expiration_{{ $i }}" value="{{ old('immunization_date_of_expiration_' . $i) }}">
									</td>
								</tr>
							@endfor
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
							@for($i = 1; $i <= $xray_sputum_rows; $i++)
								<tr>
									<td>{{ $i }}</td>

									<td class="field{!! !$errors->has('x-ray_sputum_exam_date_' . $i) ? '"' : ' error" data-content="' . $errors->first('x-ray_sputum_exam_date_' . $i) . '" data-position="top center"' !!}>
										<input type="date" name="x-ray_sputum_exam_date_{{ $i }}" value="{{ old('x-ray_sputum_exam_date_' . $i) }}">
									</td>

									<td class="field{!! !$errors->has('x-ray_sputum_exam_kind_' . $i) ? '"' : ' error" data-content="' . $errors->first('x-ray_sputum_exam_kind_' . $i) . '" data-position="top center"' !!}>
										<input type="text" name="x-ray_sputum_exam_kind_{{ $i }}" value="{{ old('x-ray_sputum_exam_kind_' . $i) }}">
									</td>

									<td class="field{!! !$errors->has('x-ray_sputum_exam_result_' . $i) ? '"' : ' error" data-content="' . $errors->first('x-ray_sputum_exam_result_' . $i) . '" data-position="top center"' !!}>
										<input type="text" name="x-ray_sputum_exam_result_{{ $i }}" value="{{ old('x-ray_sputum_exam_result_' . $i) }}">
									</td>
								</tr>
							@endfor
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
							@for($i = 1; $i <= $stool_and_other_rows; $i++)
								<tr>
									<td>{{ $i }}</td>

									<td class="field{!! !$errors->has('stool_and_other_exam_date_' . $i) ? '"' : ' error" data-content="' . $errors->first('stool_and_other_exam_date_' . $i) . '" data-position="top center"' !!}>
										<input type="date" name="stool_and_other_exam_date_{{ $i }}" value="{{ old('stool_and_other_exam_date_' . $i) }}">
									</td>

									<td class="field{!! !$errors->has('stool_and_other_exam_kind_' . $i) ? '"' : ' error" data-content="' . $errors->first('stool_and_other_exam_kind_' . $i) . '" data-position="top center"' !!}>
										<input type="text" name="stool_and_other_exam_kind_{{ $i }}" value="{{ old('stool_and_other_exam_kind_' . $i) }}">
									</td>

									<td class="field{!! !$errors->has('stool_and_other_exam_result_' . $i) ? '"' : ' error" data-content="' . $errors->first('stool_and_other_exam_result_' . $i) . '" data-position="top center"' !!}>
										<input type="text" name="stool_and_other_exam_result_{{ $i }}" value="{{ old('stool_and_other_exam_result_' . $i) }}">
									</td>
								</tr>
							@endfor
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
							@for($i = 1; $i <= $hiv_rows; $i++)
								<tr>
									<td>{{ $i }}</td>

									<td class="field{!! !$errors->has('hiv_date_' . $i) ? '"' : ' error" data-content="' . $errors->first('hiv_date_' . $i) . '" data-position="top center"' !!}>
										<input type="date" name="hiv_date_{{ $i }}" value="{{ old('hiv_date_' . $i) }}">
									</td>

									<td class="field{!! !$errors->has('hiv_result_' . $i) ? '"' : ' error" data-content="' . $errors->first('hiv_result_' . $i) . '" data-position="top center"' !!}>
										<input type="text" name="hiv_result_{{ $i }}" value="{{ old('hiv_result_' . $i) }}">
									</td>

									<td class="field{!! !$errors->has('hiv_date_of_next_exam_' . $i) ? '"' :' error" data-content="' . $errors->first('hiv_date_of_next_exam_' . $i) . '" data-position="top center"' !!}>
										<input type="date" name="hiv_date_of_next_exam_{{ $i }}" value="{{ old('hiv_date_of_next_exam_' . $i) }}">
									</td>
								</tr>
							@endfor
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
							@for($i = 1; $i <= $hbsag_rows; $i++)
								<tr>
									<td>{{ $i }}</td>

									<td class="field{!! !$errors->has('hbsag_date_' . $i) ? '"' : ' error" data-content="' . $errors->first('hbsag_date_' . $i) . '" data-position="top center"' !!}>
										<input type="date" name="hbsag_date_{{ $i }}" value="{{ old('hbsag_date_' . $i) }}">
									</td>

									<td class="field{!! !$errors->has('hbsag_result_' . $i) ? '"' : ' error" data-content="' . $errors->first('hbsag_result_' . $i) . '" data-position="top center"' !!}>
										<input type="text" name="hbsag_result_{{ $i }}" value="{{ old('hbsag_result_' . $i) }}">
									</td>

									<td class="field{!! !$errors->has('hbsag_date_of_next_exam_' . $i) ? '"' :' error" data-content="' . $errors->first('hbsag_date_of_next_exam_' . $i) . '" data-position="top center"' !!}>
										<input type="date" name="hbsag_date_of_next_exam_{{ $i }}" value="{{ old('hbsag_date_of_next_exam_' . $i) }}">
									</td>
								</tr>
							@endfor
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
							@for($i = 1; $i <= $vdrl_rows; $i++)
								<tr>
									<td>{{ $i }}</td>

									<td class="field{!! !$errors->has('vdrl_date_' . $i) ? '"' : ' error" data-content="' . $errors->first('vdrl_date_' . $i) . '" data-position="top center"' !!}>
										<input type="date" name="vdrl_date_{{ $i }}" value="{{ old('vdrl_date_' . $i) }}">
									</td>

									<td class="field{!! !$errors->has('vdrl_result_' . $i) ? '"' : ' error" data-content="' . $errors->first('vdrl_result_' . $i) . '" data-position="top center"' !!}>
										<input type="text" name="vdrl_result_{{ $i }}" value="{{ old('vdrl_result_' . $i) }}">
									</td>

									<td class="field{!! !$errors->has('vdrl_date_of_next_exam_' . $i) ? '"' :' error" data-content="' . $errors->first('vdrl_date_of_next_exam_' . $i) . '" data-position="top center"' !!}>
										<input type="date" name="vdrl_date_of_next_exam_{{ $i }}" value="{{ old('vdrl_date_of_next_exam_' . $i) }}">
									</td>
								</tr>
							@endfor
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
								@for($i = 1; $i <= $cervical_smear_max_rows; $i++)
									<tr>
										<td>{{ $i }}</td>

										<td class="field{!! !$errors->has('cervical_smear.' . $i . '.date') ? '"' : ' error" data-content="' . $errors->first('cervical_smear.' . $i . '.date') . '" data-position="top center"' !!}>
											<input type="date" name="cervical_smear[{{ $i }}][date]" value="{{ old('cervical_smear.' . $i . '.date') }}">
										</td>

										<td class="field{!! !$errors->has('cervical_smear.' . $i . '.initial') ? '"' : ' error" data-content="' . $errors->first('cervical_smear.' . $i . '.initial') . '" data-position="top center"' !!}>
											<input type="text" name="cervical_smear[{{ $i }}][initial]" value="{{ old('cervical_smear.' . $i . '.initial') }}">
										</td>

										<td class="field{!! !$errors->has('cervical_smear.' . $i . '.date_of_next_exam')? '"' :' error" data-content="' . $errors->first('cervical_smear.' . $i . '.date_of_next_exam') . '" data-position="top center"' !!}>
											<input type="date" name="cervical_smear[{{ $i }}][date_of_next_exam]" value="{{ old('cervical_smear.' . $i . '.date_of_next_exam') }}">
										</td>
									</tr>
								@endfor
							</tbody>
						</table>
					</div>
					
					<br>

					<button id="submit_health_certificate" class="ui animated fluid inverted blue fade button" tabindex="0">
						<div class="visible content">
							<i class="big icons">
								<i class="id card outline icon"></i>
								<i class="corner add icon"></i>
							</i>	
						</div>

						<div class="hidden content">
							Create Health Certificate
						</div>
					</button>
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
<script src="{{ mix('/js/create_pink_health_certificate.js') }}"></script>
@endsection