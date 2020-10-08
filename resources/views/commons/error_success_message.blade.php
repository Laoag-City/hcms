@if(count($errors) > 0)
	<div class="ui error message">
		<div class="header">
			Whoops! Something went wrong.
		</div>

		<div class="ui divider"></div>
		
		@foreach($errors->all() as $error)
			<div>
				<i class="pointing right icon"></i>
				{{ $error }}
			</div>
		@endforeach
		
	</div>

@elseif(session('success') != NULL)
	<div class="ui success message">
		<div class="header">{{ session('success')['header'] }}</div>

		<p>{{ session('success')['message'] }}</p>
	</div>
@endif