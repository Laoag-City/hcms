@extends('layouts.authenticated')

@section('sub_content')
<div class="sixteen wide column center aligned">
	<div class="ui attached message">
		<h2 class="ui header">
			{{ $title }}
		</h2>
	</div>

	<div class="ui attached segment">
		<div class="ui stackable centered grid">
			<div class="sixteen wide column center aligned">

				<form id="pre-renew-form" method="GET" action="{{ url()->current() }}" class="ui form {{ $errors->any() ? 'error' : 'success' }}">
					<div class="fields">
						<div class="six wide field"></div>

						<div class="four wide field">
							<label>Filter Address:</label>
							<div class="ui fluid action input">
								<select class="ui search dropdown" name="brgy">
									<option value=""></option>
									<option value="1">1, San Lorenzo</option>
									<option value="2">2, Santa Joaquina</option>
									<option value="3">3, Nuestra Señora del Rosario</option>
									<option value="4">4, San Guillermo</option>
									<option value="5">5, San Pedro</option>
									<option value="6">6, San Agustin</option>
									<option value="7-A"}>7-A, Nuestra Señora del Natividad</option>
									<option value="7-B"}>7-B, Nuestra Señora del Natividad</option>
									<option value="8">8, San Vicente</option>
									<option value="9">9, Santa Angela</option>
									<option value="10">10, San Jose</option>
									<option value="11">11, Santa Balbina</option>
									<option value="12">12, San Isidro</option>
									<option value="13">13, Nuestra Señora de Visitacion</option>
									<option value="14">14, Santo Tomas</option>
									<option value="15">15, San Guillermo</option>
									<option value="16">16, San Jacinto</option>
									<option value="17">17, San Francisco</option>
									<option value="18">18, San Quirino</option>
									<option value="19">19, Santa Marcela</option>
									<option value="20">20, San Miguel</option>
									<option value="21">21, San Pedro</option>
									<option value="22">22, San Andres</option>
									<option value="23">23, San Matias</option>
									<option value="24">24, Nuestra Señora de Consolacion</option>
									<option value="25">25, Santa Cayetana</option>
									<option value="26">26, San Marcelino</option>
									<option value="27">27, Nuestra Señora de Soledad</option>
									<option value="28">28, San Bernardo</option>
									<option value="29">29, Santo Tomas</option>
									<option value="30-A">30-A, Suyo</option>
									<option value="30-B">30-B, Santa Maria</option>
									<option value="31">31, Talingaan</option>
									<option value="32-A">32-A, La Paz East</option>
									<option value="32-B">32-B, La Paz West</option>
									<option value="32-C">32-C, La Paz East</option>
									<option value="33-A">33-A, La Paz Proper</option>
									<option value="33-B">33-B, La Paz Proper</option>
									<option value="34-A">34-A, Gabu Norte West</option>
									<option value="34-B">34-B, Gabu Norte East</option>
									<option value="35">35, Gabu Sur</option>
									<option value="36">36, Araniw</option>
									<option value="37">37, Calayab</option>
									<option value="38-A">38-A, Mangato East</option>
									<option value="38-B">38-B, Mangato West</option>
									<option value="39">39, Santa Rosa</option>
									<option value="40">40, Balatong</option>
									<option value="41">41, Balacad</option>
									<option value="42">42, Apaya</option>
									<option value="43">43, Cavit</option>
									<option value="44">44, Zamboanga</option>
									<option value="45">45, Tangid</option>
									<option value="46">46, Nalbo</option>
									<option value="47">47, Bengcag</option>
									<option value="48-A">48-A, Cabungaan North</option>
									<option value="48-B">48-B, Cabungaan South</option>
									<option value="49-A">49-A, Darayday</option>
									<option value="49-B">49-B, Raraburan</option>
									<option value="50">50, Buttong</option>
									<option value="51-A">51-A, Nangalisan East</option>
									<option value="51-B">51-B, Nangalisan West</option>
									<option value="52-A">52-A, San Mateo</option>
									<option value="52-B">52-B, Lataag</option>
									<option value="53">53, Rioeng</option>
									<option value="54-A">54-A, Camangaan</option>
									<option value="54-B">54-B, Lagui-Sail</option>
									<option value="55-A">55-A, Barit-Pandan</option>
									<option value="55-B">55-B, Salet-Bulangon</option>
									<option value="55-C">55-C, Vira</option>
									<option value="56-A">56-A, Bacsil North</option>
									<option value="56-B">56-B, Bacsil South</option>
									<option value="57">57, Pila</option>
									<option value="58">58, Casili</option>
									<option value="59-A">59-A, Dibua South</option>
									<option value="59-B">59-B, Dibua North</option>
									<option value="60-A">60-A, Caaoacan</option>
									<option value="60-B">60-B, Madiladig</option>
									<option value="61">61, Cataban</option>
									<option value="62-A">62-A, Navotas North</option>
									<option value="62-B">62-B, Navotas South</option>
								</select>
								<button class="ui button">Filter</button>
							</div>
						</div>
					</div>
				</form>

				<br>

				@if($sanitary_permits != [])
					<h3 class="ui left aligned header">Brgy. {{ request()->brgy }} Sanitary Permits</h3>

					<table class="ui attached striped selectable structured celled table">
				<thead>
					<tr class="center aligned">
						<th class="collapsing">Sanitary Permit Number</th>
						<th>Establishment Type</th>
						<th>Address</th>
						<th class="collapsing">Expired</th>
						<th class="collapsing">Issuance Date</th>
						<th class="collapsing">Expiration Date</th>
						<th class="collapsing">Options</th>
					</tr>
				</thead>

				<tbody>
					@foreach($sanitary_permits as $sc)
						@php
							$expired = $sc->checkIfExpired();
						@endphp

						<tr class="center aligned">
							<td>{{ $sc->sanitary_permit_number }}</td>
							<td>{{ $sc->establishment_type }}</td>
							<td>{{ $sc->address }}</td>
							@if($expired)
								<td class="error">Yes</td>
							@else
								<td>No</td>
							@endif
							<td>{{ $sc->issuance_date }}</td>
							<td>{{ $sc->expiration_date }}</td>
							<td class="collapsing">
								<div class="ui compact menu">
									<div class="ui simple dropdown item">
										<i class="options icon"></i>
										<i class="dropdown icon"></i>
										<div class="menu">
											<a class="item" href="{{ url("sanitary_permit/$sc->sanitary_permit_id") }}">Sanitary Permit Info</a>
											<a class="item" href="{{ url("sanitary_permit/$sc->sanitary_permit_id/preview") }}">Print Preview</a>
											<button type="button" class="item delete_button" data-id="{{ $sc->sanitary_permit_id }}">Remove</button>
										</div>
									</div>
								</div>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
				@endif
			</div>
		</div>			
	</div>
</div>
@endsection

@section('sub_custom_js')

<script src="{{ mix('/js/sanitary_permit_list.js') }}"></script>

@include('commons.delete_modal')

@endsection