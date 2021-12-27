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
				    		<input type="number" min="1" name="total_employees" value="{{ old('total_employees') ? old('total_employees') : $permit->total_employees }}">
				    	</div>
					</div>

					<br>

					<div class="fields">
						<div class="five wide field
				    	{!! !$errors->has('brgy') ? '"' : ' error" data-content="' . $errors->first('brgy') . '" data-position="top center"' !!}>
				    		<label>Brgy:</label>
				    		<select class="ui search dropdown" name="brgy">
								<option value=""></option>
								<option value="1, San Lorenzo" {{ $brgy != '1, San Lorenzo' ?: 'selected' }}>1, San Lorenzo</option>
								<option value="2, Santa Joaquina" {{ $brgy != '2, Santa Joaquina' ?: 'selected' }}>2, Santa Joaquina</option>
								<option value="3, Nuestra Señora del Rosario" {{ $brgy != '3, Nuestra Señora del Rosario' ?: 'selected' }}>3, Nuestra Señora del Rosario</option>
								<option value="4, San Guillermo" {{ $brgy != '4, San Guillermo' ?: 'selected' }}>4, San Guillermo</option>
								<option value="5, San Pedro" {{ $brgy != '5, San Pedro' ?: 'selected' }}>5, San Pedro</option>
								<option value="6, San Agustin" {{ $brgy != '6, San Agustin' ?: 'selected' }}>6, San Agustin</option>
								<option value="7-A, Nuestra Señora del Natividad" {{ $brgy != '7-A, Nuestra Señora del Natividad' ?: 'selected' }}>7-A, Nuestra Señora del Natividad</option>
								<option value="7-B, Nuestra Señora del Natividad" {{ $brgy != '7-B, Nuestra Señora del Natividad' ?: 'selected' }}>7-B, Nuestra Señora del Natividad</option>
								<option value="8, San Vicente" {{ $brgy != '8, San Vicente' ?: 'selected' }}>8, San Vicente</option>
								<option value="9, Santa Angela" {{ $brgy != '9, Santa Angela' ?: 'selected' }}>9, Santa Angela</option>
								<option value="10, San Jose" {{ $brgy != '10, San Jose' ?: 'selected' }}>10, San Jose</option>
								<option value="11, Santa Balbina" {{ $brgy != '11, Santa Balbina' ?: 'selected' }}>11, Santa Balbina</option>
								<option value="12, San Isidro" {{ $brgy != '12, San Isidro' ?: 'selected' }}>12, San Isidro</option>
								<option value="13, Nuestra Señora de Visitacion" {{ $brgy != '13, Nuestra Señora de Visitacion' ?: 'selected' }}>13, Nuestra Señora de Visitacion</option>
								<option value="14, Santo Tomas" {{ $brgy != '14, Santo Tomas' ?: 'selected' }}>14, Santo Tomas</option>
								<option value="15, San Guillermo" {{ $brgy != '15, San Guillermo' ?: 'selected' }}>15, San Guillermo</option>
								<option value="16, San Jacinto" {{ $brgy != '16, San Jacinto' ?: 'selected' }}>16, San Jacinto</option>
								<option value="17, San Francisco" {{ $brgy != '17, San Francisco' ?: 'selected' }}>17, San Francisco</option>
								<option value="18, San Quirino" {{ $brgy != '18, San Quirino' ?: 'selected' }}>18, San Quirino</option>
								<option value="19, Santa Marcela" {{ $brgy != '19, Santa Marcela' ?: 'selected' }}>19, Santa Marcela</option>
								<option value="20, San Miguel" {{ $brgy != '20, San Miguel' ?: 'selected' }}>20, San Miguel</option>
								<option value="21, San Pedro" {{ $brgy != '21, San Pedro' ?: 'selected' }}>21, San Pedro</option>
								<option value="22, San Andres" {{ $brgy != '22, San Andres' ?: 'selected' }}>22, San Andres</option>
								<option value="23, San Matias" {{ $brgy != '23, San Matias' ?: 'selected' }}>23, San Matias</option>
								<option value="24, Nuestra Señora de Consolacion" {{ $brgy != '24, Nuestra Señora de Consolacion' ?: 'selected' }}>24, Nuestra Señora de Consolacion</option>
								<option value="25, Santa Cayetana" {{ $brgy != '25, Santa Cayetana' ?: 'selected' }}>25, Santa Cayetana</option>
								<option value="26, San Marcelino" {{ $brgy != '26, San Marcelino' ?: 'selected' }}>26, San Marcelino</option>
								<option value="27, Nuestra Señora de Soledad" {{ $brgy != '27, Nuestra Señora de Soledad' ?: 'selected' }}>27, Nuestra Señora de Soledad</option>
								<option value="28, San Bernardo" {{ $brgy != '28, San Bernardo' ?: 'selected' }}>28, San Bernardo</option>
								<option value="29, Santo Tomas" {{ $brgy != '29, Santo Tomas' ?: 'selected' }}>29, Santo Tomas</option>
								<option value="30-A, Suyo" {{ $brgy != '30-A, Suyo' ?: 'selected' }}>30-A, Suyo</option>
								<option value="30-B, Santa Maria" {{ $brgy != '30-B, Santa Maria' ?: 'selected' }}>30-B, Santa Maria</option>
								<option value="31, Talingaan" {{ $brgy != '31, Talingaan' ?: 'selected' }}>31, Talingaan</option>
								<option value="32-A, La Paz East" {{ $brgy != '32-A, La Paz East' ?: 'selected' }}>32-A, La Paz East</option>
								<option value="32-B, La Paz West" {{ $brgy != '32-B, La Paz West' ?: 'selected' }}>32-B, La Paz West</option>
								<option value="32-C, La Paz East" {{ $brgy != '32-C, La Paz East' ?: 'selected' }}>32-C, La Paz East</option>
								<option value="33-A, La Paz Proper" {{ $brgy != '33-A, La Paz Proper' ?: 'selected' }}>33-A, La Paz Proper</option>
								<option value="33-B, La Paz Proper" {{ $brgy != '33-B, La Paz Proper' ?: 'selected' }}>33-B, La Paz Proper</option>
								<option value="34-A, Gabu Norte West" {{ $brgy != '34-A, Gabu Norte West' ?: 'selected' }}>34-A, Gabu Norte West</option>
								<option value="34-B, Gabu Norte East" {{ $brgy != '34-B, Gabu Norte East' ?: 'selected' }}>34-B, Gabu Norte East</option>
								<option value="35, Gabu Sur" {{ $brgy != '35, Gabu Sur' ?: 'selected' }}>35, Gabu Sur</option>
								<option value="36, Araniw" {{ $brgy != '36, Araniw' ?: 'selected' }}>36, Araniw</option>
								<option value="37, Calayab" {{ $brgy != '37, Calayab' ?: 'selected' }}>37, Calayab</option>
								<option value="38-A, Mangato East" {{ $brgy != '38-A, Mangato East' ?: 'selected' }}>38-A, Mangato East</option>
								<option value="38-B, Mangato West" {{ $brgy != '38-B, Mangato West' ?: 'selected' }}>38-B, Mangato West</option>
								<option value="39, Santa Rosa" {{ $brgy != '39, Santa Rosa' ?: 'selected' }}>39, Santa Rosa</option>
								<option value="40, Balatong" {{ $brgy != '40, Balatong' ?: 'selected' }}>40, Balatong</option>
								<option value="41, Balacad" {{ $brgy != '41, Balacad' ?: 'selected' }}>41, Balacad</option>
								<option value="42, Apaya" {{ $brgy != '42, Apaya' ?: 'selected' }}>42, Apaya</option>
								<option value="43, Cavit" {{ $brgy != '43, Cavit' ?: 'selected' }}>43, Cavit</option>
								<option value="44, Zamboanga" {{ $brgy != '44, Zamboanga' ?: 'selected' }}>44, Zamboanga</option>
								<option value="45, Tangid" {{ $brgy != '45, Tangid' ?: 'selected' }}>45, Tangid</option>
								<option value="46, Nalbo" {{ $brgy != '46, Nalbo' ?: 'selected' }}>46, Nalbo</option>
								<option value="47, Bengcag" {{ $brgy != '47, Bengcag' ?: 'selected' }}>47, Bengcag</option>
								<option value="48-A, Cabungaan North" {{ $brgy != '48-A, Cabungaan North' ?: 'selected' }}>48-A, Cabungaan North</option>
								<option value="48-B, Cabungaan South" {{ $brgy != '48-B, Cabungaan South' ?: 'selected' }}>48-B, Cabungaan South</option>
								<option value="49-A, Darayday" {{ $brgy != '49-A, Darayday' ?: 'selected' }}>49-A, Darayday</option>
								<option value="49-B, Raraburan" {{ $brgy != '49-B, Raraburan' ?: 'selected' }}>49-B, Raraburan</option>
								<option value="50, Buttong" {{ $brgy != '50, Buttong' ?: 'selected' }}>50, Buttong</option>
								<option value="51-A, Nangalisan East" {{ $brgy != '51-A, Nangalisan East' ?: 'selected' }}>51-A, Nangalisan East</option>
								<option value="51-B, Nangalisan West" {{ $brgy != '51-B, Nangalisan West' ?: 'selected' }}>51-B, Nangalisan West</option>
								<option value="52-A, San Mateo" {{ $brgy != '52-A, San Mateo' ?: 'selected' }}>52-A, San Mateo</option>
								<option value="52-B, Lataag" {{ $brgy != '52-B, Lataag' ?: 'selected' }}>52-B, Lataag</option>
								<option value="53, Rioeng" {{ $brgy != '53, Rioeng' ?: 'selected' }}>53, Rioeng</option>
								<option value="54-A, Camangaan" {{ $brgy != '54-A, Camangaan' ?: 'selected' }}>54-A, Camangaan</option>
								<option value="54-B, Lagui-Sail" {{ $brgy != '54-B, Lagui-Sail' ?: 'selected' }}>54-B, Lagui-Sail</option>
								<option value="55-A, Barit-Pandan" {{ $brgy != '55-A, Barit-Pandan' ?: 'selected' }}>55-A, Barit-Pandan</option>
								<option value="55-B, Salet-Bulangon" {{ $brgy != '55-B, Salet-Bulangon' ?: 'selected' }}>55-B, Salet-Bulangon</option>
								<option value="55-C, Vira" {{ $brgy != '55-C, Vira' ?: 'selected' }}>55-C, Vira</option>
								<option value="56-A, Bacsil North" {{ $brgy != '56-A, Bacsil North' ?: 'selected' }}>56-A, Bacsil North</option>
								<option value="56-B, Bacsil South" {{ $brgy != '56-B, Bacsil South' ?: 'selected' }}>56-B, Bacsil South</option>
								<option value="57, Pila" {{ $brgy != '57, Pila' ?: 'selected' }}>57, Pila</option>
								<option value="58, Casili" {{ $brgy != '58, Casili' ?: 'selected' }}>58, Casili</option>
								<option value="59-A, Dibua South" {{ $brgy != '59-A, Dibua South' ?: 'selected' }}>59-A, Dibua South</option>
								<option value="59-B, Dibua North" {{ $brgy != '59-B, Dibua North' ?: 'selected' }}>59-B, Dibua North</option>
								<option value="60-A, Caaoacan" {{ $brgy != '60-A, Caaoacan' ?: 'selected' }}>60-A, Caaoacan</option>
								<option value="60-B, Madiladig" {{ $brgy != '60-B, Madiladig' ?: 'selected' }}>60-B, Madiladig</option>
								<option value="61, Cataban" {{ $brgy != '61, Cataban' ?: 'selected' }}>61, Cataban</option>
								<option value="62-A, Navotas North" {{ $brgy != '62-A, Navotas North' ?: 'selected' }}>62-A, Navotas North</option>
								<option value="62-B, Navotas South" {{ $brgy != '62-B, Navotas South' ?: 'selected' }}>62-B, Navotas South</option>
							</select>
				    	</div>

				    	<div class="seven wide field
				    	{!! !$errors->has('address') ? '"' : ' error" data-content="' . $errors->first('address') . '" data-position="top center"' !!}>
				    		<label>Address:</label>
				    		<input type="text" name="address" value="{{ old('address') ? old('address') : $permit->address }}" class="dynamic_input" placeholder="Address">
				    	</div>

				    	<div class="three wide field{!! !$errors->has('date_of_issuance') ? '"' : ' error" data-content="' . $errors->first('date_of_issuance') . '" data-position="top center"' !!}>
				    		<label>Date of Issuance:</label>
				    		<input type="date" name="date_of_issuance" value="{{ old('date_of_issuance') ? old('date_of_issuance') : $permit->dateToInput('issuance_date') }}" class="dynamic_input">
				    	</div>

				    	<div class="three wide field{!! !$errors->has('date_of_expiration') ? '"' : ' error" data-content="' . $errors->first('date_of_expiration') . '" data-position="top center"' !!}>
				    		<label>Date of Expiration:</label>
				    		<input type="date" name="date_of_expiration" value="{{ $permit->dateToInput('expiration_date') }}" class="dynamic_input" readonly="true">
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