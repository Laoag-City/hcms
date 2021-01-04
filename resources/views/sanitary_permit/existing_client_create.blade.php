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

					<div class="fields">
							<div class="eight wide field
							{!! !$errors->has('establishment_type') ? '"' : ' error" data-content="' . $errors->first('establishment_type') . '" data-position="top center"' !!}>
					    		<label>Establishment Type:</label>
					    		<input type="text" name="establishment_type" value="{{ old('establishment_type') }}" placeholder="Establishment Type">
					    	</div>

					    	<div class="eight wide field
					    	{!! !$errors->has('address') ? '"' : ' error" data-content="' . $errors->first('address') . '" data-position="top center"' !!}>
					    		<label>Address:</label>
					    		<input type="text" name="address" value="{{ old('address') }}" placeholder="Address">
					    	</div>
					</div>

					<br>

					<div class="fields">
				    	<div class="four wide field{!! !$errors->has('date_of_issuance') ? '"' : ' error" data-content="' . $errors->first('date_of_issuance') . '" data-position="top center"' !!}>
				    		<label>Date of Issuance:</label>
				    		<input type="date" name="date_of_issuance" value="{{ old('date_of_issuance') }}">
				    	</div>

				    	<div class="four wide field{!! !$errors->has('date_of_expiration') ? '"' : ' error" data-content="' . $errors->first('date_of_expiration') . '" data-position="top center"' !!}>
				    		<label>Date of Expiration:</label>
				    		<input type="date" name="date_of_expiration" value="{{ old('date_of_expiration') }}">
				    	</div>

				    	<div class="eight wide field
					    	{!! !$errors->has('sanitary_inspector') ? '"' : ' error" data-content="' . $errors->first('sanitary_inspector') . '" data-position="top center"' !!}>
					    		<label>Sanitary Inspector:</label>
					    		<input type="text" name="sanitary_inspector" value="{{ old('sanitary_inspector') }}" placeholder="Sanitary Inspector">
					    	</div>
					</div>

					<br>

					<button class="ui fluid inverted blue button">
						Create Sanitary Permit
					</button>
				</form>
			</div>
		</div>			
	</div>
</div>
@endsection

@section('sub_custom_js')
	<script>
		$(document).ready(function(){
			$('.field').popup();
			$('.ui.checkbox').checkbox();
		});
	</script>
@endsection