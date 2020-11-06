@extends('layouts.authenticated')

@section('sub_content')
<div class="sixteen wide column center aligned">
    <div class="ui attached message">
		<h2 class="ui header">
			Change Health Certificate Values
		</h2>
    </div>
    
    <form method="POST" action="{{ url()->current() }}" class="ui form attached fluid segment {{ $errors->any() ? 'error' : 'success' }}">
		{{ csrf_field() }}
		{{ method_field('PUT') }}

		@if(session('success') != NULL)
			<div class="ui success message">
				<div class="header">{{ session('success')['header'] }}</div>

				<p>{{ session('success')['message'] }}</p>
			</div>
		@endif

        <br>

        <div class="ui centered grid">
            <div class="row">
                <div class="eight wide column">
                    <div class="field{!! !$errors->has('city_health_officer') ? '"' : ' error" data-content="' . $errors->first('city_health_officer') . '" data-position="top center"' !!}">
                        <label class="text_center">City Health Officer</label>
                        <input type="text" name="city_health_officer" value="{{ old('city_health_officer') ? old('city_health_officer') : $city_health_officer }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="eight wide column">
                    <div class="field{!! !$errors->has('health_certificates_output_folder') ? '"' : ' error" data-content="' . $errors->first('health_certificates_output_folder') . '" data-position="top center"' !!}">
                        <label class="text_center">Health Certificates Output Folder</label>
                        <input type="text" name="health_certificates_output_folder" value="{{ old('health_certificates_output_folder') ? old('health_certificates_output_folder') : $health_certificates_output_folder }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="eight wide column">
                    <button type="submit" class="fluid ui button">Submit</button>
                </div>
            </div>
        </div>
	</form>
</div>
@endsection

@section('sub_custom_js')
<script>$('.field').popup();</script>
@endsection