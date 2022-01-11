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
				<div class="ui stackable grid">
					<div class="row">
						<div class="sixteen wide column">
							<div class="ui two buttons">
								<a href="{{ url()->previous() }}" class="ui inverted blue button">Back</a>
								<a href="{{ url("sanitary_permit/$permit->sanitary_permit_id/preview") }}" class="ui inverted green button">Print Preview</a>
							</div>
						</div>
					</div>

					<br>

					<div class="row">
						<div class="ten wide column"><!--nested columns-->
							<h3>
								<i class="caret right icon"></i>
								<span style="font-weight: normal;">Registered Name:</span> 
								<u>{{ $permit->getRegisteredName() }}</u>
							</h3>
						</div>

						<div class="six wide column right aligned">
							<h3>
								<i class="caret right icon"></i>
								<span style="font-weight: normal;">Permit Status:</span> 
								<u>{{ $permit->checkIfExpired() ? 'Expired' : 'Not Expired' }}</u>
							</h3>
						</div>
					</div>

					<div class="row">
						<div class="eight wide column">
							<h3>
								<i class="caret right icon"></i>
								<span style="font-weight: normal;">Permit Registration Number:</span> 
								<u>{{ $permit->sanitary_permit_number }}</u>
							</h3>
						</div>
					</div>
				</div>

				<div class="ui section divider"></div>

				<form method="POST" action="{{ url()->current() }}" class="ui form text_center {{ $errors->any() ? 'error' : 'success' }}">
					<h3 class="ui header">
						Sanitary Permit
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

						<div class="six wide inline field{!! !$errors->has('update_mode') ? '"' : ' error" data-content="' . $errors->first('update_mode') . '" data-position="top center"' !!}>
							<div class="ui toggle checkbox">
								<label><b>Edit Sanitary Permit</b></label>
								<input type="checkbox" name="update_mode" value="on" class="update_switches hidden" {{ !old('update_mode') ?: 'checked' }}>
							</div>
						</div>
					</div>
					
					<br>
					<br>
					<br>

					<div class="fields">
						<div class="four wide field"></div>

						@php
							if($permit->applicant_id != null)
							{
								$switch_to_label = 'Change to Business';
								$switch_value = 'business';
							}

							else
							{
								$switch_to_label = 'Change to Individual Client';
								$switch_value = 'individual';
							}
						@endphp

						<div id="switch_permit_type_field" class="eight wide inline field{!! !$errors->has('permit_type') ? '"' : ' error" data-content="' . $errors->first('permit_type') . '" data-position="top center"' !!}>
							<div class="ui checkbox">
								<label><b>{{ $switch_to_label }}</b></label>
								<input type="checkbox" name="permit_type" value="{{ $switch_value }}" {{ old('permit_type') == $switch_value ? 'checked' : '' }}>
							</div>
						</div>
					</div>

					<br>

					@php
						if($permit->applicant_id != null)
						{
							$first_name = old('first_name') ? old('first_name') : $permit->applicant->first_name;
							$middle_name = old('middle_name') ? old('middle_name') : $permit->applicant->middle_name;
							$last_name = old('last_name') ? old('last_name') : $permit->applicant->last_name;
							$suffix_name = old('suffix_name') ? old('suffix_name') : $permit->applicant->suffix_name;
							$age = old('age') ? old('age') : $permit->applicant->age;
							$gender = old('gender') ? old('gender') : $permit->applicant->gender;

							$business_name = old('business_name');
						}

						else
						{
							$first_name = old('first_name');
							$middle_name = old('middle_name');
							$last_name = old('last_name');
							$suffix_name = old('suffix_name');
							$age = old('age');
							$gender = old('gender');

							$business_name = old('business_name') ? old('business_name') : $permit->business->business_name;
						}

						$brgy = old('brgy') ? old('brgy') : $permit->brgy;
					@endphp

					<div class="fields field_individual">
						<div class="six wide field
						{!! !$errors->has('first_name') ? '"' : ' error" data-content="' . $errors->first('first_name') . '" data-position="top center"' !!}>
				    		<label>First Name:</label>
				    		<input type="text" name="first_name" value="{{ $first_name }}" class="field_individual" placeholder="First Name">
				    	</div>

				    	<div class="four wide field
				    	{!! !$errors->has('middle_name') ? '"' : ' error" data-content="' . $errors->first('middle_name') . '" data-position="top center"' !!}>
				    		<label>Middle Name:</label>
				    		<input type="text" name="middle_name" value="{{ $middle_name }}" class="field_individual" placeholder="Middle Name">
				    	</div>

				    	<div class="four wide field
				    	{!! !$errors->has('last_name') ? '"' : ' error" data-content="' . $errors->first('last_name') . '" data-position="top center"' !!}>
				    		<label>Last Name:</label>
				    		<input type="text" name="last_name" value="{{ $last_name }}" class="field_individual" placeholder="Last Name">
				    	</div>

				    	<div class="two wide field
				    	{!! !$errors->has('suffix_name') ? '"' : ' error" data-content="' . $errors->first('suffix_name') . '" data-position="top center"' !!}>
				    		<label>Suffix:</label>
				    		<select name="suffix_name" class="field_individual">
								<option value=""></option>
								<option value="Jr." {{ $suffix_name != 'Jr.' ?: 'selected' }}>Jr.</option>
								<option value="Sr." {{ $suffix_name != 'Sr.' ?: 'selected' }}>Sr.</option>
								<option value="I" {{ $suffix_name != 'I' ?: 'selected' }}>I</option>
								<option value="II" {{ $suffix_name != 'II' ?: 'selected' }}>II</option>
								<option value="III" {{ $suffix_name != 'III' ?: 'selected' }}>III</option>
								<option value="IV" {{ $suffix_name != 'IV' ?: 'selected' }}>IV</option>
								<option value="V" {{ $suffix_name != 'V' ?: 'selected' }}>V</option>
								<option value="VI" {{ $suffix_name != 'VI' ?: 'selected' }}>VI</option>
								<option value="VII" {{ $suffix_name != 'VII' ?: 'selected' }}>VII</option>
								<option value="VIII" {{ $suffix_name != 'VIII' ?: 'selected' }}>VIII</option>
								<option value="IX" {{ $suffix_name != 'IX' ?: 'selected' }}>IX</option>
								<option value="X" {{ $suffix_name != 'X' ?: 'selected' }}>X</option>
							</select>
				    	</div>
					</div>

					<br>

					<div class="fields field_individual">
						<div class="five wide field"></div>

						<div class="field_individual three wide field
						{!! !$errors->has('age') ? '"' : ' error" data-content="' . $errors->first('age') . '" data-position="top center"' !!}>
							<label>Age:</label>
							<input type="number" name="age" class="field_individual" value="{{ $age }}" min="">
						</div>
						
						<div class="field_individual three wide field
						{!! !$errors->has('gender') ? '"' : ' error" data-content="' . $errors->first('gender') . '" data-position="top center"' !!}>
							<label>Gender:</label>
							<select name="gender" class="field_individual">
								<option value=""></option>
								<option value="1" {{ (string)$gender != '1' ?: 'selected' }}>Male</option>
								<option value="0" {{ (string)$gender != '0' ?: 'selected' }}>Female</option>
							</select>
						</div>
					</div>

					<div class="fields field_business">
						<div class="four wide field"></div>

						<div class="eight wide field
						{!! !$errors->has('business_name') ? '"' : ' error" data-content="' . $errors->first('business_name') . '" data-position="top center"' !!}>
				    		<label>Business Name:</label>
				    		<input type="text" name="business_name" value="{{ $business_name }}" class="field_business" placeholder="Business Name">
				    	</div>
					</div>
					
					<br>

					<div class="fields">
						<div class="three wide field"></div>

						<div class="eight wide field
						{!! !$errors->has('establishment_type') ? '"' : ' error" data-content="' . $errors->first('establishment_type') . '" data-position="top center"' !!}>
				    		<label>Establishment Type:</label>
				    		<input type="text" name="establishment_type" value="{{ old('establishment_type') ? old('establishment_type') : $permit->establishment_type }}" class="dynamic_input" placeholder="Establishment Type">
				    	</div>

				    	<div class="two wide field
						{!! !$errors->has('total_employees') ? '"' : ' error" data-content="' . $errors->first('total_employees') . '" data-position="top center"' !!}>
				    		<label>Total Employees:</label>
				    		<input type="number" name="total_employees" value="{{ old('total_employees') ? old('total_employees') : $permit->total_employees }}">
				    	</div>
					</div>

					<br>

					<div class="fields">
						<div class="five wide field
				    	{!! !$errors->has('brgy') ? '"' : ' error" data-content="' . $errors->first('brgy') . '" data-position="top center"' !!}>
				    		<label>Brgy:</label>
				    		<select class="ui search dropdown" name="brgy">
								<option value=""></option>
								<option value="Brgy. 1" {{ $brgy != 'Brgy. 1' ?: 'selected' }}>1, San Lorenzo</option>
								<option value="Brgy. 2" {{ $brgy != 'Brgy. 2' ?: 'selected' }}>2, Santa Joaquina</option>
								<option value="Brgy. 3" {{ $brgy != 'Brgy. 3' ?: 'selected' }}>3, Nuestra Señora del Rosario</option>
								<option value="Brgy. 4" {{ $brgy != 'Brgy. 4' ?: 'selected' }}>4, San Guillermo</option>
								<option value="Brgy. 5" {{ $brgy != 'Brgy. 5' ?: 'selected' }}>5, San Pedro</option>
								<option value="Brgy. 6" {{ $brgy != 'Brgy. 6' ?: 'selected' }}>6, San Agustin</option>
								<option value="Brgy. 7-A" {{ $brgy != 'Brgy. 7-A' ?: 'selected' }}>7-A, Nuestra Señora del Natividad</option>
								<option value="Brgy. 7-B" {{ $brgy != 'Brgy. 7-B' ?: 'selected' }}>7-B, Nuestra Señora del Natividad</option>
								<option value="Brgy. 8" {{ $brgy != 'Brgy. 8' ?: 'selected' }}>8, San Vicente</option>
								<option value="Brgy. 9" {{ $brgy != 'Brgy. 9' ?: 'selected' }}>9, Santa Angela</option>
								<option value="Brgy. 10" {{ $brgy != 'Brgy. 10' ?: 'selected' }}>10, San Jose</option>
								<option value="Brgy. 11" {{ $brgy != 'Brgy. 11' ?: 'selected' }}>11, Santa Balbina</option>
								<option value="Brgy. 12" {{ $brgy != 'Brgy. 12' ?: 'selected' }}>12, San Isidro</option>
								<option value="Brgy. 13" {{ $brgy != 'Brgy. 13' ?: 'selected' }}>13, Nuestra Señora de Visitacion</option>
								<option value="Brgy. 14" {{ $brgy != 'Brgy. 14' ?: 'selected' }}>14, Santo Tomas</option>
								<option value="Brgy. 15" {{ $brgy != 'Brgy. 15' ?: 'selected' }}>15, San Guillermo</option>
								<option value="Brgy. 16" {{ $brgy != 'Brgy. 16' ?: 'selected' }}>16, San Jacinto</option>
								<option value="Brgy. 17" {{ $brgy != 'Brgy. 17' ?: 'selected' }}>17, San Francisco</option>
								<option value="Brgy. 18" {{ $brgy != 'Brgy. 18' ?: 'selected' }}>18, San Quirino</option>
								<option value="Brgy. 19" {{ $brgy != 'Brgy. 19' ?: 'selected' }}>19, Santa Marcela</option>
								<option value="Brgy. 20" {{ $brgy != 'Brgy. 20' ?: 'selected' }}>20, San Miguel</option>
								<option value="Brgy. 21" {{ $brgy != 'Brgy. 21' ?: 'selected' }}>21, San Pedro</option>
								<option value="Brgy. 22" {{ $brgy != 'Brgy. 22' ?: 'selected' }}>22, San Andres</option>
								<option value="Brgy. 23" {{ $brgy != 'Brgy. 23' ?: 'selected' }}>23, San Matias</option>
								<option value="Brgy. 24" {{ $brgy != 'Brgy. 24' ?: 'selected' }}>24, Nuestra Señora de Consolacion</option>
								<option value="Brgy. 25" {{ $brgy != 'Brgy. 25' ?: 'selected' }}>25, Santa Cayetana</option>
								<option value="Brgy. 26" {{ $brgy != 'Brgy. 26' ?: 'selected' }}>26, San Marcelino</option>
								<option value="Brgy. 27" {{ $brgy != 'Brgy. 27' ?: 'selected' }}>27, Nuestra Señora de Soledad</option>
								<option value="Brgy. 28" {{ $brgy != 'Brgy. 28' ?: 'selected' }}>28, San Bernardo</option>
								<option value="Brgy. 29" {{ $brgy != 'Brgy. 29' ?: 'selected' }}>29, Santo Tomas</option>
								<option value="Brgy. 30-A" {{ $brgy != 'Brgy. 30-A' ?: 'selected' }}>30-A, Suyo</option>
								<option value="Brgy. 30-B" {{ $brgy != 'Brgy. 30-B' ?: 'selected' }}>30-B, Santa Maria</option>
								<option value="Brgy. 31" {{ $brgy != 'Brgy. 31' ?: 'selected' }}>31, Talingaan</option>
								<option value="Brgy. 32-A" {{ $brgy != 'Brgy. 32-A' ?: 'selected' }}>32-A, La Paz East</option>
								<option value="Brgy. 32-B" {{ $brgy != 'Brgy. 32-B' ?: 'selected' }}>32-B, La Paz West</option>
								<option value="Brgy. 32-C" {{ $brgy != 'Brgy. 32-C' ?: 'selected' }}>32-C, La Paz East</option>
								<option value="Brgy. 33-A" {{ $brgy != 'Brgy. 33-A' ?: 'selected' }}>33-A, La Paz Proper</option>
								<option value="Brgy. 33-B" {{ $brgy != 'Brgy. 33-B' ?: 'selected' }}>33-B, La Paz Proper</option>
								<option value="Brgy. 34-A" {{ $brgy != 'Brgy. 34-A' ?: 'selected' }}>34-A, Gabu Norte West</option>
								<option value="Brgy. 34-B" {{ $brgy != 'Brgy. 34-B' ?: 'selected' }}>34-B, Gabu Norte East</option>
								<option value="Brgy. 35" {{ $brgy != 'Brgy. 35' ?: 'selected' }}>35, Gabu Sur</option>
								<option value="Brgy. 36" {{ $brgy != 'Brgy. 36' ?: 'selected' }}>36, Araniw</option>
								<option value="Brgy. 37" {{ $brgy != 'Brgy. 37' ?: 'selected' }}>37, Calayab</option>
								<option value="Brgy. 38-A" {{ $brgy != 'Brgy. 38-A' ?: 'selected' }}>38-A, Mangato East</option>
								<option value="Brgy. 38-B" {{ $brgy != 'Brgy. 38-B' ?: 'selected' }}>38-B, Mangato West</option>
								<option value="Brgy. 39" {{ $brgy != 'Brgy. 39' ?: 'selected' }}>39, Santa Rosa</option>
								<option value="Brgy. 40" {{ $brgy != 'Brgy. 40' ?: 'selected' }}>40, Balatong</option>
								<option value="Brgy. 41" {{ $brgy != 'Brgy. 41' ?: 'selected' }}>41, Balacad</option>
								<option value="Brgy. 42" {{ $brgy != 'Brgy. 42' ?: 'selected' }}>42, Apaya</option>
								<option value="Brgy. 43" {{ $brgy != 'Brgy. 43' ?: 'selected' }}>43, Cavit</option>
								<option value="Brgy. 44" {{ $brgy != 'Brgy. 44' ?: 'selected' }}>44, Zamboanga</option>
								<option value="Brgy. 45" {{ $brgy != 'Brgy. 45' ?: 'selected' }}>45, Tangid</option>
								<option value="Brgy. 46" {{ $brgy != 'Brgy. 46' ?: 'selected' }}>46, Nalbo</option>
								<option value="Brgy. 47" {{ $brgy != 'Brgy. 47' ?: 'selected' }}>47, Bengcag</option>
								<option value="Brgy. 48-A" {{ $brgy != 'Brgy. 48-A' ?: 'selected' }}>48-A, Cabungaan North</option>
								<option value="Brgy. 48-B" {{ $brgy != 'Brgy. 48-B' ?: 'selected' }}>48-B, Cabungaan South</option>
								<option value="Brgy. 49-A" {{ $brgy != 'Brgy. 49-A' ?: 'selected' }}>49-A, Darayday</option>
								<option value="Brgy. 49-B" {{ $brgy != 'Brgy. 49-B' ?: 'selected' }}>49-B, Raraburan</option>
								<option value="Brgy. 50" {{ $brgy != 'Brgy. 50' ?: 'selected' }}>50, Buttong</option>
								<option value="Brgy. 51-A" {{ $brgy != 'Brgy. 51-A' ?: 'selected' }}>51-A, Nangalisan East</option>
								<option value="Brgy. 51-B" {{ $brgy != 'Brgy. 51-B' ?: 'selected' }}>51-B, Nangalisan West</option>
								<option value="Brgy. 52-A" {{ $brgy != 'Brgy. 52-A' ?: 'selected' }}>52-A, San Mateo</option>
								<option value="Brgy. 52-B" {{ $brgy != 'Brgy. 52-B' ?: 'selected' }}>52-B, Lataag</option>
								<option value="Brgy. 53" {{ $brgy != 'Brgy. 53' ?: 'selected' }}>53, Rioeng</option>
								<option value="Brgy. 54-A" {{ $brgy != 'Brgy. 54-A' ?: 'selected' }}>54-A, Camangaan</option>
								<option value="Brgy. 54-B" {{ $brgy != 'Brgy. 54-B' ?: 'selected' }}>54-B, Lagui-Sail</option>
								<option value="Brgy. 55-A" {{ $brgy != 'Brgy. 55-A' ?: 'selected' }}>55-A, Barit-Pandan</option>
								<option value="Brgy. 55-B" {{ $brgy != 'Brgy. 55-B' ?: 'selected' }}>55-B, Salet-Bulangon</option>
								<option value="Brgy. 55-C" {{ $brgy != 'Brgy. 55-C' ?: 'selected' }}>55-C, Vira</option>
								<option value="Brgy. 56-A" {{ $brgy != 'Brgy. 56-A' ?: 'selected' }}>56-A, Bacsil North</option>
								<option value="Brgy. 56-B" {{ $brgy != 'Brgy. 56-B' ?: 'selected' }}>56-B, Bacsil South</option>
								<option value="Brgy. 57" {{ $brgy != 'Brgy. 57' ?: 'selected' }}>57, Pila</option>
								<option value="Brgy. 58" {{ $brgy != 'Brgy. 58' ?: 'selected' }}>58, Casili</option>
								<option value="Brgy. 59-A" {{ $brgy != 'Brgy. 59-A' ?: 'selected' }}>59-A, Dibua South</option>
								<option value="Brgy. 59-B" {{ $brgy != 'Brgy. 59-B' ?: 'selected' }}>59-B, Dibua North</option>
								<option value="Brgy. 60-A" {{ $brgy != 'Brgy. 60-A' ?: 'selected' }}>60-A, Caaoacan</option>
								<option value="Brgy. 60-B" {{ $brgy != 'Brgy. 60-B' ?: 'selected' }}>60-B, Madiladig</option>
								<option value="Brgy. 61" {{ $brgy != 'Brgy. 61' ?: 'selected' }}>61, Cataban</option>
								<option value="Brgy. 62-A" {{ $brgy != 'Brgy. 62-A' ?: 'selected' }}>62-A, Navotas North</option>
								<option value="Brgy. 62-B" {{ $brgy != 'Brgy. 62-B' ?: 'selected' }}>62-B, Navotas South</option>
							</select>
				    	</div>

				    	<div class="seven wide field
				    	{!! !$errors->has('street') ? '"' : ' error" data-content="' . $errors->first('street') . '" data-position="top center"' !!}>
				    		<label>Street:</label>
				    		<input type="text" name="street" value="{{ old('street') ? old('street') : $permit->street }}" class="dynamic_input" placeholder="Street">
				    	</div>

				    	<div class="three wide field{!! !$errors->has('date_of_issuance') ? '"' : ' error" data-content="' . $errors->first('date_of_issuance') . '" data-position="top center"' !!}>
				    		<label>Date of Issuance:</label>
				    		<input type="date" name="date_of_issuance" value="{{ old('date_of_issuance') ? old('date_of_issuance') : $permit->dateToInput('issuance_date') }}" class="dynamic_input">
				    	</div>

				    	<div class="three wide field{!! !$errors->has('date_of_expiration') ? '"' : ' error" data-content="' . $errors->first('date_of_expiration') . '" data-position="top center"' !!}>
				    		<label>Date of Expiration:</label>
				    		<input type="date" name="date_of_expiration" value="{{ old('date_of_expiration') ? old('date_of_expiration') : $permit->dateToInput('expiration_date') }}" class="dynamic_input">
				    	</div>
					</div>

					<br>

					<div class="fields">
						<div class="four wide field"></div>

				    	<div class="eight wide field
					    	{!! !$errors->has('sanitary_inspector') ? '"' : ' error" data-content="' . $errors->first('sanitary_inspector') . '" data-position="top center"' !!}>
				    		<label>Sanitary Inspector:</label>
				    		<input type="text" name="sanitary_inspector" value="{{ old('sanitary_inspector') ? old('sanitary_inspector') : $permit->sanitary_inspector }}" class="dynamic_input" placeholder="Sanitary Inspector">
				    	</div>
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
	<script src="{{ mix('/js/sanitary_permit_information.js') }}"></script>
@endsection