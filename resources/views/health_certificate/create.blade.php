@extends('layouts.authenticated')

@section('sub_custom_css')

<link rel="stylesheet" href="{{ mix('/css/create_health_certificate.css') }}">

@endsection

@section('sub_content')
<div class="sixteen wide column center aligned">
	<div class="ui attached message">
		<h2 class="ui header">
			New Health Certificate Form
		</h2>
	</div>

	<div class="ui attached segment">
		<div class="ui stackable centered grid">
			<div class="fourteen wide column center aligned">
				<form id="health_certificate_form" method="POST" action="{{ url('/') }}" class="ui form {{ $errors->any() ? 'error' : 'success' }}">
					{{ csrf_field() }}
					
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
						<div class="two wide field
						{!! !$errors->has('age') ? '"' : ' error" data-content="' . $errors->first('age') . '" data-position="top center"' !!}>
							<label>Age:</label>
							<input type="number" name="age" value="{{ old('age') }}" min="">
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

						<div class="five wide field
						{!! !$errors->has('type_of_work') ? '"' : ' error" data-content="' . $errors->first('type_of_work') . '" data-position="top center"' !!}>
							<label>Type of Work:</label>
							<input type="text" name="type_of_work" value="{{ old('type_of_work') }}" placeholder="Type of Work">
						</div>

						<div class="seven wide field
						{!! !$errors->has('name_of_establishment') ? '"' : ' error" data-content="' . $errors->first('name_of_establishment') . '" data-position="top center"' !!}>
							<label>Name of Establishment:</label>
							<input type="text" name="name_of_establishment" value="{{ old('name_of_establishment') }}" placeholder="Name of Establishment">
						</div>
					</div>

					<br>

					<div class="fields">
						<div class="two wide field"></div>
						
						<div class="four wide field{!! !$errors->has('certificate_type') ? '"' : ' error" data-content="' . $errors->first('certificate_type') . '" data-position="top center"' !!}>
							<label>Certificate Type:</label>
							<select name="certificate_type">
								<option value="" data-years="0" data-months="0" data-days="0"></option>
								@foreach($certificate_types as $type => $value)
									<option 
										value="{{ $value['string'] }}" {{ old('certificate_type') != $value['string'] ?: 'selected' }}
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
				    		<input type="date" name="date_of_issuance" value="{{ old('date_of_issuance') ? old('date_of_issuance') : date('Y-m-d', strtotime('now')) }}">
				    	</div>

				    	<div class="four wide field{!! !$errors->has('date_of_expiration') ? '"' : ' error" data-content="' . $errors->first('date_of_expiration') . '" data-position="top center"' !!}>
				    		<label>Date of Expiration:</label>
				    		<input type="date" name="date_of_expiration" value="{{ old('date_of_expiration') }}">
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

								<td class="field{!! !$errors->has('immunization_date_1') ? '"' : ' error" data-content="' . $errors->first('immunization_date_1') . '" data-position="top center"' !!}>
									<input type="date" name="immunization_date_1" value="{{ old('immunization_date_1') }}">
								</td>

								<td class="field{!! !$errors->has('immunization_kind_1') ? '"' : ' error" data-content="' . $errors->first('immunization_kind_1') . '" data-position="top center"' !!}>
									<input type="text" name="immunization_kind_1" value="{{ old('immunization_kind_1') }}">
								</td>

								<td class="field{!! !$errors->has('immunization_date_of_expiration_1')? '"' :' error" data-content="' . $errors->first('immunization_date_of_expiration_1') . '" data-position="top center"' !!}>
									<input type="date" name="immunization_date_of_expiration_1" value="{{ old('immunization_date_of_expiration_1') }}">
								</td>
							</tr>

							<tr>
								<td>2</td>

								<td class="field{!! !$errors->has('immunization_date_2') ? '"' : ' error" data-content="' . $errors->first('immunization_date_2') . '" data-position="top center"' !!}>
									<input type="date" name="immunization_date_2" value="{{ old('immunization_date_2') }}">
								</td>

								<td class="field{!! !$errors->has('immunization_kind_2') ? '"' : ' error" data-content="' . $errors->first('immunization_kind_2') . '" data-position="top center"' !!}>
									<input type="text" name="immunization_kind_2" value="{{ old('immunization_kind_2') }}">
								</td>

								<td class="field{!! !$errors->has('immunization_date_of_expiration_2')? '"' :' error" data-content="' . $errors->first('immunization_date_of_expiration_2') . '" data-position="top center"' !!}>
									<input type="date" name="immunization_date_of_expiration_2" value="{{ old('immunization_date_of_expiration_2') }}">
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

								<td class="field{!! !$errors->has('x-ray_sputum_exam_date_1') ? '"' : ' error" data-content="' . $errors->first('x-ray_sputum_exam_date_1') . '" data-position="top center"' !!}>
									<input type="date" name="x-ray_sputum_exam_date_1" value="{{ old('x-ray_sputum_exam_date_1') ? old('x-ray_sputum_exam_date_1') : date('Y-m-d', strtotime('now')) }}">
								</td>

								<td class="field{!! !$errors->has('x-ray_sputum_exam_kind_1') ? '"' : ' error" data-content="' . $errors->first('x-ray_sputum_exam_kind_1') . '" data-position="top center"' !!}>
									<input type="text" name="x-ray_sputum_exam_kind_1" value="SPUTUM{{-- old('x-ray_sputum_exam_kind_1') --}}" readonly="">
								</td>

								<td class="field{!! !$errors->has('x-ray_sputum_exam_result_1') ? '"' : ' error" data-content="' . $errors->first('x-ray_sputum_exam_result_1') . '" data-position="top center"' !!}>
									<input type="text" name="x-ray_sputum_exam_result_1" value="NEG ( - ){{-- old('x-ray_sputum_exam_result_1') --}}" readonly="">
								</td>
							</tr>

							<tr>
								<td>2</td>

								<td class="field{!! !$errors->has('x-ray_sputum_exam_date_2') ? '"' : ' error" data-content="' . $errors->first('x-ray_sputum_exam_date_2') . '" data-position="top center"' !!}>
									<input type="date" name="x-ray_sputum_exam_date_2" value="{{ old('x-ray_sputum_exam_date_2') }}">
								</td>

								<td class="field{!! !$errors->has('x-ray_sputum_exam_kind_2') ? '"' : ' error" data-content="' . $errors->first('x-ray_sputum_exam_kind_2') . '" data-position="top center"' !!}>
									<input type="text" name="x-ray_sputum_exam_kind_2" value="{{ old('x-ray_sputum_exam_kind_2') }}">
								</td>

								<td class="field{!! !$errors->has('x-ray_sputum_exam_result_2') ? '"' : ' error" data-content="' . $errors->first('x-ray_sputum_exam_result_2') . '" data-position="top center"' !!}>
									<input type="text" name="x-ray_sputum_exam_result_2" value="{{ old('x-ray_sputum_exam_result_2') }}">
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

								<td class="field{!! !$errors->has('stool_and_other_exam_date_1') ? '"' : ' error" data-content="' . $errors->first('stool_and_other_exam_date_1') . '" data-position="top center"' !!}>
									<input type="date" name="stool_and_other_exam_date_1" value="{{ old('stool_and_other_exam_date_1') ? old('stool_and_other_exam_date_1') : date('Y-m-d', strtotime('now')) }}">
								</td>

								<td class="field{!! !$errors->has('stool_and_other_exam_kind_1') ? '"' : ' error" data-content="' . $errors->first('stool_and_other_exam_kind_1') . '" data-position="top center"' !!}>
									<input type="text" name="stool_and_other_exam_kind_1" value="STOOL{{-- old('stool_and_other_exam_kind_1') --}}" readonly="">
								</td>

								<td class="field{!! !$errors->has('stool_and_other_exam_result_1') ? '"' : ' error" data-content="' . $errors->first('stool_and_other_exam_result_1') . '" data-position="top center"' !!}>
									<input type="text" name="stool_and_other_exam_result_1" value="NOPS{{-- old('stool_and_other_exam_result_1') --}}" readonly="">
								</td>
							</tr>

							<tr>
								<td>2</td>

								<td class="field{!! !$errors->has('stool_and_other_exam_date_2') ? '"' : ' error" data-content="' . $errors->first('stool_and_other_exam_date_2') . '" data-position="top center"' !!}>
									<input type="date" name="stool_and_other_exam_date_2" value="{{ old('stool_and_other_exam_date_2') ? old('stool_and_other_exam_date_2') : date('Y-m-d', strtotime('now')) }}">
								</td>

								<td class="field{!! !$errors->has('stool_and_other_exam_kind_2') ? '"' : ' error" data-content="' . $errors->first('stool_and_other_exam_kind_2') . '" data-position="top center"' !!}>
									<input type="text" name="stool_and_other_exam_kind_2" value="URINE{{-- old('stool_and_other_exam_kind_2') --}}" readonly="">
								</td>

								<td class="field{!! !$errors->has('stool_and_other_exam_result_2') ? '"' : ' error" data-content="' . $errors->first('stool_and_other_exam_result_2') . '" data-position="top center"' !!}>
									<input type="text" name="stool_and_other_exam_result_2" value="NORMAL{{-- old('stool_and_other_exam_result_2') --}}" readonly="">
								</td>
							</tr>
						</tbody>
					</table>

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
<script src="{{ mix('/js/create_health_certificate.js') }}"></script>
@endsection