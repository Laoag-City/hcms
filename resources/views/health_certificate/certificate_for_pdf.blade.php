<!DOCTYPE html>
<html>
<head>
	<meta name="author" content="Russell James F. Bello">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    
	<title>Health Certificate for PDF Download</title>

	<link rel="stylesheet" href="{{ public_path('css/camera.css') }}" media="all">
</head>
<body>
	<div class="pull_left">
		@include('health_certificate.front')
	</div>
	<div class="pull_left">
		@include('health_certificate.back')
	</div>
</body>
</html>