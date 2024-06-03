<!DOCTYPE html>
<html>
<head>
	<meta name="author" content="Russell James F. Bello">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>window.Laravel = {!! json_encode(['csrfToken' => csrf_token(), ]) !!};</script>
	<title>Pink Card</title>

	<link rel="stylesheet" href="{{ mix('/css/print_pink_health_certificate.css') }}">
</head>
<body>
	<div class="no-print">
		<br>
		<button onclick="window.location.replace('{{ url()->previous() }}')">GO BACK</button>
		<button onclick="window.location.replace('{{ url('/') }}')">ADD HEALTH CERTIFICATE</button>
		<button onclick="window.location.replace('{{ url("/sanitary_permit") }}')">
			ADD SANITARY PERMIT
		</button>

		@if(!collect(session()->get('print_phc_ids'))->contains($pink_health_certificate->pink_health_certificate_id))
			<button onclick="event.preventDefault(); document.getElementById('add_to_bulk_print_form').submit();">
				ADD TO BULK PRINT LIST
			</button>

			<form id="add_to_bulk_print_form" action="{{ url('pink_card/bulk_print_add') }}" method="POST" style="display: none;">
				{{ csrf_field() }}
				<input type="hidden" name="id" value="{{ $pink_health_certificate->pink_health_certificate_id }}">
			</form>
		@endif
		
		<button data-function="print_back" class="pull_right print" style="margin-left: 10px;">PRINT (BACK)</button>
		<button data-function="print_front" class="pull_right print">PRINT (FRONT)</button>
		<br>
		<br>
		<button id="take_picture" class="hidden">TAKE PICTURE</button>
		<button id="retake_picture" class="hidden">RETAKE PICTURE</button>
		<button id="save_picture" class="pull_right hidden">SAVE PICTURE</button>
		<hr>

		<h3 class="text_center camera_certificate_header">Camera Output</h3>
		<div id="camera"></div>
	</div>

	<div id="certificates-wrapper" class="text_center">
		<h3 class="no-print">Front Preview</h3>

		@include('pink_health_certificate.front')

		<h3 class="no-print">Back Preview</h3>

		@include('pink_health_certificate.back')
	</div>
	
</body>
<script>
	var save_picture_url = "{!! $save_picture_url !!}";
</script>
<script src="/webcamjs/webcam.js"></script>
<script src="{{ mix('/js/app.js') }}"></script>
<script src="{{ mix('/js/camera.js') }}"></script>
</html>