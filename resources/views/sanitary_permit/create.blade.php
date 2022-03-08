@extends('layouts.authenticated')

@section('sub_custom_css')

<!--borrowed from health certificate-->
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
				<form id="sanitary_permit_form" method="POST" action="{{ url()->current() }}" class="ui form {{ $errors->any() ? 'error' : 'success' }}">
					{{ csrf_field() }}
					
					<br>

					<input type="hidden" name="id" value="{{ old('id') }}">

					<div class="fields">
						<div class="four wide field"></div>

						<div class="four wide inline field{!! !$errors->has('permit_type') ? '"' : ' error" data-content="' . $errors->first('permit_type') . '" data-position="top center"' !!}>
							<div class="ui toggle checkbox">
								<label><b>Individual Client</b></label>
								<input type="radio" name="permit_type" value="individual" {{ old('permit_type') == 'individual' ? 'checked' : '' }}>
							</div>
						</div>

						<div class="four wide inline field{!! !$errors->has('permit_type') ? '"' : ' error" data-content="' . $errors->first('permit_type') . '" data-position="top center"' !!}>
							<div class="ui toggle checkbox">
								<label><b>Business</b></label>
								<input type="radio" name="permit_type" value="business" {{ old('permit_type') == 'business' ? 'checked' : '' }}>
							</div>
						</div>
					</div>

					<br>

					<div class="fields">
						<div class="two wide field"></div>

						<div class="three wide field field_existing">
							<div class="ui check checkbox">
								<label><b>Issue Sanitary Permit to an existing Client or Business</b></label>
								<input type="checkbox" name="has_existing_registered_name" class="field_existing" {{ old('has_existing_registered_name') == null ?: 'checked' }}>
							</div>
						</div>

						<div id="searchPermitOwner" class="six wide field field_existing ui fluid search{!! !$errors->has('existing_registered_name') 
							? '" data-content="Type a client\'s name and choose from the suggestions below."' 
							: ' error" data-content="' . $errors->first('existing_registered_name') . '"' !!} data-position="top center">
								<label>Existing Registered Name:</label>
								<input class="prompt field_existing" type="text" name="existing_registered_name" value="{{ old('existing_registered_name') }}" placeholder="Existing Registered Name">
								<div class="results"></div>
						</div>
					</div>

					<div class="fields field_individual">
						<div class="six wide field
						{!! !$errors->has('first_name') ? '"' : ' error" data-content="' . $errors->first('first_name') . '" data-position="top center"' !!}>
				    		<label>First Name:</label>
				    		<input type="text" name="first_name" value="{{ old('first_name') }}" class="field_individual dynamic_input" placeholder="First Name">
				    	</div>

				    	<div class="four wide field
				    	{!! !$errors->has('middle_name') ? '"' : ' error" data-content="' . $errors->first('middle_name') . '" data-position="top center"' !!}>
				    		<label>Middle Name:</label>
				    		<input type="text" name="middle_name" value="{{ old('middle_name') }}" class="field_individual dynamic_input" placeholder="Middle Name">
				    	</div>

				    	<div class="four wide field
				    	{!! !$errors->has('last_name') ? '"' : ' error" data-content="' . $errors->first('last_name') . '" data-position="top center"' !!}>
				    		<label>Last Name:</label>
				    		<input type="text" name="last_name" value="{{ old('last_name') }}" class="field_individual dynamic_input" placeholder="Last Name">
				    	</div>

				    	<div class="two wide field
				    	{!! !$errors->has('suffix_name') ? '"' : ' error" data-content="' . $errors->first('suffix_name') . '" data-position="top center"' !!}>
				    		<label>Suffix:</label>
				    		<select name="suffix_name" class="field_individual dynamic_select">
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

					<div class="fields field_business">
						<div class="four wide field"></div>

						<div class="eight wide field
						{!! !$errors->has('business_name') ? '"' : ' error" data-content="' . $errors->first('business_name') . '" data-position="top center"' !!}>
				    		<label>Business Name:</label>
				    		<input type="text" name="business_name" value="{{ old('business_name') }}" class="field_business dynamic_input" placeholder="Business Name">
				    	</div>
					</div>


					<div class="fields field_individual">
						<div class="five wide field"></div>

						<div class="field_individual three wide field
						{!! !$errors->has('age') ? '"' : ' error" data-content="' . $errors->first('age') . '" data-position="top center"' !!}>
							<label>Age:</label>
							<input type="number" name="age" class="field_individual" value="{{ old('age') }}" min="">
						</div>
						
						<div class="field_individual three wide field
						{!! !$errors->has('gender') ? '"' : ' error" data-content="' . $errors->first('gender') . '" data-position="top center"' !!}>
							<label>Gender:</label>
							<select name="gender" class="field_individual dynamic_select">
								<option value=""></option>
								<option value="1" {{ (string)old('gender') != '1' ?: 'selected' }}>Male</option>
								<option value="0" {{ (string)old('gender') != '0' ?: 'selected' }}>Female</option>
							</select>
						</div>
					</div>

					<br>

					<div class="fields">
						<div class="three wide field"></div>

						<div class="eight wide field
						{!! !$errors->has('establishment_type') ? '"' : ' error" data-content="' . $errors->first('establishment_type') . '" data-position="top center"' !!}>
				    		<label>Establishment Type:</label>
				    		<input type="text" name="establishment_type" value="{{ old('establishment_type') }}" placeholder="Establishment Type">
				    	</div>

				    	<div class="two wide field
						{!! !$errors->has('total_employees') ? '"' : ' error" data-content="' . $errors->first('total_employees') . '" data-position="top center"' !!}>
				    		<label>Total Employees:</label>
				    		<input type="number" name="total_employees" value="{{ old('total_employees') }}">
				    	</div>
					</div>

					<br>

					<div class="fields">
						<div class="five wide field
				    	{!! !$errors->has('brgy') ? '"' : ' error" data-content="' . $errors->first('brgy') . '" data-position="top center"' !!}>
				    		<label>Brgy:</label>
				    		<select class="ui search dropdown" name="brgy">
								<option value=""></option>
								<option value="Brgy. 1" {{ old('brgy') != 'Brgy. 1' ?: 'selected' }}>1, San Lorenzo</option>
								<option value="Brgy. 2" {{ old('brgy') != 'Brgy. 2' ?: 'selected' }}>2, Santa Joaquina</option>
								<option value="Brgy. 3" {{ old('brgy') != 'Brgy. 3' ?: 'selected' }}>3, Nuestra Señora del Rosario</option>
								<option value="Brgy. 4" {{ old('brgy') != 'Brgy. 4' ?: 'selected' }}>4, San Guillermo</option>
								<option value="Brgy. 5" {{ old('brgy') != 'Brgy. 5' ?: 'selected' }}>5, San Pedro</option>
								<option value="Brgy. 6" {{ old('brgy') != 'Brgy. 6' ?: 'selected' }}>6, San Agustin</option>
								<option value="Brgy. 7-A" {{ old('brgy') != 'Brgy. 7-A' ?: 'selected' }}>7-A, Nuestra Señora del Natividad</option>
								<option value="Brgy. 7-B" {{ old('brgy') != 'Brgy. 7-B' ?: 'selected' }}>7-B, Nuestra Señora del Natividad</option>
								<option value="Brgy. 8" {{ old('brgy') != 'Brgy. 8' ?: 'selected' }}>8, San Vicente</option>
								<option value="Brgy. 9" {{ old('brgy') != 'Brgy. 9' ?: 'selected' }}>9, Santa Angela</option>
								<option value="Brgy. 10" {{ old('brgy') != 'Brgy. 10' ?: 'selected' }}>10, San Jose</option>
								<option value="Brgy. 11" {{ old('brgy') != 'Brgy. 11' ?: 'selected' }}>11, Santa Balbina</option>
								<option value="Brgy. 12" {{ old('brgy') != 'Brgy. 12' ?: 'selected' }}>12, San Isidro</option>
								<option value="Brgy. 13" {{ old('brgy') != 'Brgy. 13' ?: 'selected' }}>13, Nuestra Señora de Visitacion</option>
								<option value="Brgy. 14" {{ old('brgy') != 'Brgy. 14' ?: 'selected' }}>14, Santo Tomas</option>
								<option value="Brgy. 15" {{ old('brgy') != 'Brgy. 15' ?: 'selected' }}>15, San Guillermo</option>
								<option value="Brgy. 16" {{ old('brgy') != 'Brgy. 16' ?: 'selected' }}>16, San Jacinto</option>
								<option value="Brgy. 17" {{ old('brgy') != 'Brgy. 17' ?: 'selected' }}>17, San Francisco</option>
								<option value="Brgy. 18" {{ old('brgy') != 'Brgy. 18' ?: 'selected' }}>18, San Quirino</option>
								<option value="Brgy. 19" {{ old('brgy') != 'Brgy. 19' ?: 'selected' }}>19, Santa Marcela</option>
								<option value="Brgy. 20" {{ old('brgy') != 'Brgy. 20' ?: 'selected' }}>20, San Miguel</option>
								<option value="Brgy. 21" {{ old('brgy') != 'Brgy. 21' ?: 'selected' }}>21, San Pedro</option>
								<option value="Brgy. 22" {{ old('brgy') != 'Brgy. 22' ?: 'selected' }}>22, San Andres</option>
								<option value="Brgy. 23" {{ old('brgy') != 'Brgy. 23' ?: 'selected' }}>23, San Matias</option>
								<option value="Brgy. 24" {{ old('brgy') != 'Brgy. 24' ?: 'selected' }}>24, Nuestra Señora de Consolacion</option>
								<option value="Brgy. 25" {{ old('brgy') != 'Brgy. 25' ?: 'selected' }}>25, Santa Cayetana</option>
								<option value="Brgy. 26" {{ old('brgy') != 'Brgy. 26' ?: 'selected' }}>26, San Marcelino</option>
								<option value="Brgy. 27" {{ old('brgy') != 'Brgy. 27' ?: 'selected' }}>27, Nuestra Señora de Soledad</option>
								<option value="Brgy. 28" {{ old('brgy') != 'Brgy. 28' ?: 'selected' }}>28, San Bernardo</option>
								<option value="Brgy. 29" {{ old('brgy') != 'Brgy. 29' ?: 'selected' }}>29, Santo Tomas</option>
								<option value="Brgy. 30-A" {{ old('brgy') != 'Brgy. 30-A' ?: 'selected' }}>30-A, Suyo</option>
								<option value="Brgy. 30-B" {{ old('brgy') != 'Brgy. 30-B' ?: 'selected' }}>30-B, Santa Maria</option>
								<option value="Brgy. 31" {{ old('brgy') != 'Brgy. 31' ?: 'selected' }}>31, Talingaan</option>
								<option value="Brgy. 32-A" {{ old('brgy') != 'Brgy. 32-A' ?: 'selected' }}>32-A, La Paz East</option>
								<option value="Brgy. 32-B" {{ old('brgy') != 'Brgy. 32-B' ?: 'selected' }}>32-B, La Paz West</option>
								<option value="Brgy. 32-C" {{ old('brgy') != 'Brgy. 32-C' ?: 'selected' }}>32-C, La Paz East</option>
								<option value="Brgy. 33-A" {{ old('brgy') != 'Brgy. 33-A' ?: 'selected' }}>33-A, La Paz Proper</option>
								<option value="Brgy. 33-B" {{ old('brgy') != 'Brgy. 33-B' ?: 'selected' }}>33-B, La Paz Proper</option>
								<option value="Brgy. 34-A" {{ old('brgy') != 'Brgy. 34-A' ?: 'selected' }}>34-A, Gabu Norte West</option>
								<option value="Brgy. 34-B" {{ old('brgy') != 'Brgy. 34-B' ?: 'selected' }}>34-B, Gabu Norte East</option>
								<option value="Brgy. 35" {{ old('brgy') != 'Brgy. 35' ?: 'selected' }}>35, Gabu Sur</option>
								<option value="Brgy. 36" {{ old('brgy') != 'Brgy. 36' ?: 'selected' }}>36, Araniw</option>
								<option value="Brgy. 37" {{ old('brgy') != 'Brgy. 37' ?: 'selected' }}>37, Calayab</option>
								<option value="Brgy. 38-A" {{ old('brgy') != 'Brgy. 38-A' ?: 'selected' }}>38-A, Mangato East</option>
								<option value="Brgy. 38-B" {{ old('brgy') != 'Brgy. 38-B' ?: 'selected' }}>38-B, Mangato West</option>
								<option value="Brgy. 39" {{ old('brgy') != 'Brgy. 39' ?: 'selected' }}>39, Santa Rosa</option>
								<option value="Brgy. 40" {{ old('brgy') != 'Brgy. 40' ?: 'selected' }}>40, Balatong</option>
								<option value="Brgy. 41" {{ old('brgy') != 'Brgy. 41' ?: 'selected' }}>41, Balacad</option>
								<option value="Brgy. 42" {{ old('brgy') != 'Brgy. 42' ?: 'selected' }}>42, Apaya</option>
								<option value="Brgy. 43" {{ old('brgy') != 'Brgy. 43' ?: 'selected' }}>43, Cavit</option>
								<option value="Brgy. 44" {{ old('brgy') != 'Brgy. 44' ?: 'selected' }}>44, Zamboanga</option>
								<option value="Brgy. 45" {{ old('brgy') != 'Brgy. 45' ?: 'selected' }}>45, Tangid</option>
								<option value="Brgy. 46" {{ old('brgy') != 'Brgy. 46' ?: 'selected' }}>46, Nalbo</option>
								<option value="Brgy. 47" {{ old('brgy') != 'Brgy. 47' ?: 'selected' }}>47, Bengcag</option>
								<option value="Brgy. 48-A" {{ old('brgy') != 'Brgy. 48-A' ?: 'selected' }}>48-A, Cabungaan North</option>
								<option value="Brgy. 48-B" {{ old('brgy') != 'Brgy. 48-B' ?: 'selected' }}>48-B, Cabungaan South</option>
								<option value="Brgy. 49-A" {{ old('brgy') != 'Brgy. 49-A' ?: 'selected' }}>49-A, Darayday</option>
								<option value="Brgy. 49-B" {{ old('brgy') != 'Brgy. 49-B' ?: 'selected' }}>49-B, Raraburan</option>
								<option value="Brgy. 50" {{ old('brgy') != 'Brgy. 50' ?: 'selected' }}>50, Buttong</option>
								<option value="Brgy. 51-A" {{ old('brgy') != 'Brgy. 51-A' ?: 'selected' }}>51-A, Nangalisan East</option>
								<option value="Brgy. 51-B" {{ old('brgy') != 'Brgy. 51-B' ?: 'selected' }}>51-B, Nangalisan West</option>
								<option value="Brgy. 52-A" {{ old('brgy') != 'Brgy. 52-A' ?: 'selected' }}>52-A, San Mateo</option>
								<option value="Brgy. 52-B" {{ old('brgy') != 'Brgy. 52-B' ?: 'selected' }}>52-B, Lataag</option>
								<option value="Brgy. 53" {{ old('brgy') != 'Brgy. 53' ?: 'selected' }}>53, Rioeng</option>
								<option value="Brgy. 54-A" {{ old('brgy') != 'Brgy. 54-A' ?: 'selected' }}>54-A, Camangaan</option>
								<option value="Brgy. 54-B" {{ old('brgy') != 'Brgy. 54-B' ?: 'selected' }}>54-B, Lagui-Sail</option>
								<option value="Brgy. 55-A" {{ old('brgy') != 'Brgy. 55-A' ?: 'selected' }}>55-A, Barit-Pandan</option>
								<option value="Brgy. 55-B" {{ old('brgy') != 'Brgy. 55-B' ?: 'selected' }}>55-B, Salet-Bulangon</option>
								<option value="Brgy. 55-C" {{ old('brgy') != 'Brgy. 55-C' ?: 'selected' }}>55-C, Vira</option>
								<option value="Brgy. 56-A" {{ old('brgy') != 'Brgy. 56-A' ?: 'selected' }}>56-A, Bacsil North</option>
								<option value="Brgy. 56-B" {{ old('brgy') != 'Brgy. 56-B' ?: 'selected' }}>56-B, Bacsil South</option>
								<option value="Brgy. 57" {{ old('brgy') != 'Brgy. 57' ?: 'selected' }}>57, Pila</option>
								<option value="Brgy. 58" {{ old('brgy') != 'Brgy. 58' ?: 'selected' }}>58, Casili</option>
								<option value="Brgy. 59-A" {{ old('brgy') != 'Brgy. 59-A' ?: 'selected' }}>59-A, Dibua South</option>
								<option value="Brgy. 59-B" {{ old('brgy') != 'Brgy. 59-B' ?: 'selected' }}>59-B, Dibua North</option>
								<option value="Brgy. 60-A" {{ old('brgy') != 'Brgy. 60-A' ?: 'selected' }}>60-A, Caaoacan</option>
								<option value="Brgy. 60-B" {{ old('brgy') != 'Brgy. 60-B' ?: 'selected' }}>60-B, Madiladig</option>
								<option value="Brgy. 61" {{ old('brgy') != 'Brgy. 61' ?: 'selected' }}>61, Cataban</option>
								<option value="Brgy. 62-A" {{ old('brgy') != 'Brgy. 62-A' ?: 'selected' }}>62-A, Navotas North</option>
								<option value="Brgy. 62-B" {{ old('brgy') != 'Brgy. 62-B' ?: 'selected' }}>62-B, Navotas South</option>
							</select>
				    	</div>

				    	<div class="seven wide field
				    	{!! !$errors->has('street') ? '"' : ' error" data-content="' . $errors->first('street') . '" data-position="top center"' !!}>
				    		<label>Street:</label>
				    		<input type="text" name="street" value="{{ old('street') }}" placeholder="street">
				    	</div>

				    	<div class="three wide field{!! !$errors->has('date_of_issuance') ? '"' : ' error" data-content="' . $errors->first('date_of_issuance') . '" data-position="top center"' !!}>
				    		<label>Date of Issuance:</label>
				    		<input type="date" name="date_of_issuance" value="{{ old('date_of_issuance') ? old('date_of_issuance') : date('Y-m-d', strtotime('now')) }}">
				    	</div>

				    	<div class="three wide field{!! !$errors->has('date_of_expiration') ? '"' : ' error" data-content="' . $errors->first('date_of_expiration') . '" data-position="top center"' !!}>
				    		<label>Date of Expiration:</label>
				    		<input type="date" name="date_of_expiration" value="{{ date('Y', strtotime('now')) . '-12-31' }}" readonly="true">
				    	</div>
					</div>

					<br>

					<div class="fields">
						<div class="four wide field"></div>

				    	<div class="eight wide field
					    	{!! !$errors->has('sanitary_inspector') ? '"' : ' error" data-content="' . $errors->first('sanitary_inspector') . '" data-position="top center"' !!}>
				    		<label>Sanitary Inspector:</label>
				    		<input type="text" name="sanitary_inspector" value="{{ old('sanitary_inspector') }}" placeholder="Sanitary Inspector">
				    	</div>
					</div>

					<br>

					<button id="submit_sanitary_permit" class="ui fluid inverted blue button">
						Create Sanitary Permit
					</button>
				</form>
			</div>
		</div>			
	</div>
</div>
@endsection

@section('sub_custom_js')
	<script src="{{ mix('/js/new_sanitary_permit.js') }}"></script>
@endsection