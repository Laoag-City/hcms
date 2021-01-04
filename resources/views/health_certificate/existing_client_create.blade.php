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

					<div class="fields">
						<div class="sixteen wide field">
							<a href="{{ url()->previous() }}" class="ui inverted green fluid button">Back</a>
						</div>
					</div>

					<br>

					<div class="fields">
						<div class="five wide field"></div>

						<div class="six wide field">
							<label>Name:</label>
					    	<input type="text" value="{{ $applicant->formatName() }}" readonly="">
						</div>
					</div>

					<br>

					<div class="fields">
						<div class="two wide field"></div>

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
				    		<input type="date" name="date_of_issuance" value="{{ old('date_of_issuance') }}">
				    	</div>

				    	<div class="four wide field{!! !$errors->has('date_of_expiration') ? '"' : ' error" data-content="' . $errors->first('date_of_expiration') . '" data-position="top center"' !!}>
				    		<label>Date of Expiration:</label>
				    		<input type="date" name="date_of_expiration" value="{{ old('date_of_expiration') }}" readonly="true">
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
									<input type="date" name="x-ray_sputum_exam_date_1" value="{{ old('x-ray_sputum_exam_date_1') }}">
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
									<input type="date" name="stool_and_other_exam_date_1" value="{{ old('stool_and_other_exam_date_1') }}">
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
									<input type="date" name="stool_and_other_exam_date_2" value="{{ old('stool_and_other_exam_date_2') }}">
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