<!DOCTYPE html>
<html>
<head>
	<meta name="author" content="Russell James F. Bello">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>window.Laravel = {!! json_encode(['csrfToken' => csrf_token(), ]) !!};</script>
	<title>Health Certificate - Front</title>

	<link rel="stylesheet" href="{{ mix('/css/camera.css') }}">
</head>
<body>
	<div class="no-print">
		<br>
		<button onclick="window.location.replace('{{ url('/') }}')">GO BACK</button>
		<!--<button id="print_back" class="pull_right print" style="margin-left: 10px;">PRINT (BACK)</button>-->
		<button id="print_front" class="pull_right print">PRINT</button>
		<br>
		<br>
		<button id="take_picture" class="hidden">TAKE PICTURE</button>
		<button id="retake_picture" class="hidden">RETAKE PICTURE</button>
		<button id="save_picture" class="pull_right hidden">SAVE PICTURE</button>
		<hr>

		<h3 class="text-center camera_certificate_header">Camera Output</h3>
		<div id="camera"></div>
	</div>

	<div id="certificates-wrapper" class="text-center">
		<div style="display: inline-block;">
			<div style="float: left;">
				<h3 class="text-center no-print camera_certificate_header">Front Preview</h3>
				@include('health_certificate.values_only_front')
			</div>

			<p id="page_breaker"></p>
			
			<div style="float: left;">
				<h3 class="text-center no-print camera_certificate_header">Back Preview</h3>
				@include('health_certificate.values_only_back')
			</div>
		</div>
	</div>
	
</body>
<script>
	var picture = '{{ $picture == null ?: "#print_front" }}';
	var id = {{ $health_certificate->applicant_id }};
</script>
<script src="/webcamjs/webcam.js"></script>
<script src="{{ mix('/js/app.js') }}"></script>
<script src="{{ mix('/js/camera.js') }}"></script>
</html>