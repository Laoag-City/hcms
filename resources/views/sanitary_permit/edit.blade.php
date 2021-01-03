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
					{{ method_field('PUT') }}
					
					<br>

					<div class="fields">
						<div class="eight wide field">
								<br>
								<div class="inline fields">
									<label>Update Mode: </label>
									<div class="field">
										<div class="ui toggle checkbox">
											<input type="radio" id="edit_switch" name="update_mode" value="edit" class="update_switches hidden" {{ old('update_mode') != 'edit' ?: 'checked' }}>
											<label>Edit Only</label>
										</div>
									</div>

									<div class="field">
										<div class="ui toggle checkbox">
											<input type="radio" id="renew_switch" name="update_mode" value="edit_renew" class="update_switches hidden" {{ old('update_mode') != 'edit_renew' ?: 'checked' }}>
											<label>Edit and Renew</label>
										</div>
									</div>
								</div>
						</div>

						<div class="eight wide field">
							<label>Name:</label>
					    	<input type="text" value="{{ $applicant->formatName() }}" readonly="">
						</div>
					</div>

					<div class="fields">
							<div class="eight wide field
							{!! !$errors->has('establishment_type') ? '"' : ' error" data-content="' . $errors->first('establishment_type') . '" data-position="top center"' !!}>
					    		<label>Establishment Type:</label>
					    		<input type="text" name="establishment_type" value="{{ old('establishment_type') ? old('establishment_type') : $permit->establishment_type }}" placeholder="Establishment Type" class="dynamic_input">
					    	</div>

					    	<div class="eight wide field
					    	{!! !$errors->has('address') ? '"' : ' error" data-content="' . $errors->first('address') . '" data-position="top center"' !!}>
					    		<label>Address:</label>
					    		<input type="text" name="address" value="{{ old('address') ? old('address') : $permit->address }}" placeholder="Address" class="dynamic_input">
					    	</div>
					</div>

					<br>

					<div class="fields">
				    	<div class="four wide field{!! !$errors->has('date_of_issuance') ? '"' : ' error" data-content="' . $errors->first('date_of_issuance') . '" data-position="top center"' !!}>
				    		<label>Date of Issuance:</label>
				    		<input type="date" name="date_of_issuance" value="{{ old('date_of_issuance') ? old('date_of_issuance') : $permit->dateToInput('issuance_date') }}" class="dynamic_input">
				    	</div>

				    	<div class="four wide field{!! !$errors->has('date_of_expiration') ? '"' : ' error" data-content="' . $errors->first('date_of_expiration') . '" data-position="top center"' !!}>
				    		<label>Date of Expiration:</label>
				    		<input type="date" name="date_of_expiration" value="{{ old('date_of_expiration') ? old('date_of_expiration') : $permit->dateToInput('expiration_date') }}" class="dynamic_input">
				    	</div>

				    	<div class="eight wide field
					    	{!! !$errors->has('sanitary_inspector') ? '"' : ' error" data-content="' . $errors->first('sanitary_inspector') . '" data-position="top center"' !!}>
					    		<label>Sanitary Inspector:</label>
					    		<input type="text" name="sanitary_inspector" value="{{ old('sanitary_inspector') ? old('sanitary_inspector') : $permit->sanitary_inspector }}" placeholder="Sanitary Inspector" class="dynamic_input">
					    	</div>
					</div>

					<br>

					<button type="submit" id="update_button" class="ui fluid inverted blue button">
						Update
					</button>
				</form>
			</div>
		</div>			
	</div>
</div>
@endsection

@section('sub_custom_js')
	<script>
		alterFormState();
			
		$('.ui.checkbox').checkbox();
		$('.field').popup();

		$('.update_switches').change(function(){
			alterFormState();
		});

		function alterFormState()
		{
			if($('.update_switches').is(':checked'))
			{
				$('.dynamic_input').attr('readonly', false);
				$('select.dynamic_input').attr('disabled', false);
				$('#update_button').transition('show');
			}

			else
			{
				$('.dynamic_input').attr('readonly', true);
				$('select.dynamic_input').attr('disabled', true);
				$('#update_button').transition('hide');
			}
		}
	</script>
@endsection