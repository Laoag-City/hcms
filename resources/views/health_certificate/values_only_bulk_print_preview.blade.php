<!DOCTYPE html>
<html>
<head>
	<meta name="author" content="Russell James F. Bello">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>window.Laravel = {!! json_encode(['csrfToken' => csrf_token(), ]) !!};</script>
	<title>Print Selected Health Certificates</title>

	<link rel="stylesheet" href="{{ mix('/css/print_health_certificate_values_only.css') }}">
</head>
<body>
	<div class="no-print">
		<br>
		<button onclick="window.location.replace('{{ url()->previous() }}')">GO BACK</button>
		<!--<button id="print_back" class="pull_right print" style="margin-left: 10px;">PRINT (BACK)</button>-->
		<button onclick="window.print()" class="pull_right print">PRINT</button>
		<hr>
	</div>

	<div id="certificates-wrapper" class="text-center">
		@foreach($health_certificates as $health_certificate)
			@php
				$picture = (new App\Custom\CertificateFileGenerator($health_certificate))->getPicturePathAndURL()['url'];
				$color = $health_certificate->getColor();
			@endphp

			<h3 class="text-center no-print camera_certificate_header">{{ $loop->iteration }}. {{ $health_certificate->applicant->formatName() }}</h3>

			<div style="display: inline-block;">
				<div style="float: left;">
					@include('health_certificate.values_only_front')
				</div>

				<p id="page_breaker"></p>
				
				<div style="float: left;">
					@include('health_certificate.values_only_back')
				</div>
			</div>

			<br>
			<br>
		@endforeach
	</div>
	
</body>
<script src="{{ mix('/js/app.js') }}"></script>
</html>