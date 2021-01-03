<!DOCTYPE html>
<html>
<head>
	<meta name="author" content="Russell James F. Bello">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>window.Laravel = {!! json_encode(['csrfToken' => csrf_token(), ]) !!};</script>
	<title>Sanitary Permit</title>

	<style>
body
{
	margin: 0pt 0pt 0pt 0pt;
}

#permit
{
	width: 612pt;
	height: 792pt;
	border: 1pt solid black;
	margin-left: auto;
	margin-right: auto;
}

#contents
{
	margin: 72pt;
}

#header
{
	height: 72pt;
	position: relative;
}

#logo
{
	width: 72pt;
	height: 72pt;
	position: absolute;
	z-index: -1;
}

#header_texts
{
	font-size: 13pt;
	position: absolute;
	top: 50%;
	left: 50%;
	transform: translate(-50%, -50%);
}

#title
{
	font-family: sans-serif;
	font-size: 25pt;
	font-weight: 800;
	margin-top: 25pt;
	margin-bottom: 35pt;
}

#body
{
	font-family: sans-serif;
	overflow: auto;
}

.values
{
	display: inline-block;
	border-bottom-width: 1pt;
	border-bottom-style: solid;
	border-bottom-color: black;
}

.pull_left
{
	float: left;
}

.pull_right
{
	float: right;
}

.text-center
{
	text-align: center;
}
.text-justify
{
	text-align: justify;
}

.block_center
{
	margin-right: auto;
	margin-left: auto;
}

.auto_flow
{
	overflow: auto;
	margin-bottom: 15pt;
}

.hidden
{
	display: none;
}

@media print
{    
    .no-print
    {
        display: none !important;
    }

    #permit
    {
    	border-color: white;
    }
}
	</style>
</head>
<body>
	<div class="no-print">
		<br>
		<button onclick="window.location.replace('{{ url()->previous() }}')">GO BACK</button>
		<!--<button id="print_back" class="pull_right print" style="margin-left: 10px;">PRINT (BACK)</button>-->
		<button onclick="window.print();" class="pull_right print">PRINT</button>
		<br>
		<hr>
	</div>

	<div id="permit">
		<div id="contents">
			<div id="header">
				<img id="logo" src="{{ $logo }}">

				<div id="header_texts" class="text-center">
					<b>Republic of the Philippines</b>
					<br>
					<b>CITY HEALTH OFFICE</b>
					<br>
					<b>Laoag City</b>
				</div>
			</div>

			<h1 id="title" class="text-center">SANITARY PERMIT TO OPERATE</h1>

			<div id="body">
				<div class="auto_flow">
					<span class="pull_left" style="margin-top: 4pt;">Issued to</span>
					<span class="pull_right text-center values" style="width: 415pt; font-size: 14pt;">
						<b>{{ strtoupper($permit->applicant->formatName()) }}</b>
					</span>
					<i style="display: block;" class="text-center">(Registered Name)</i>
				</div>

				<div class="auto_flow">
					<span class="pull_right text-center values" style=" width: 100%; font-size: 14pt;">
						<b>{{ strtoupper($permit->establishment_type) }}</b>
					</span>
					<i style="display: block;" class="text-center">(Type of Establishment)</i>
				</div>

				<div class="auto_flow">
					<span class="pull_left" style="margin-top: 3pt;">Address</span>
					<span class="pull_right text-center values" style="width: 423pt; font-size: 13pt;">
						<b>{{ strtoupper($permit->address) }}</b>
					</span>
				</div>

				<br>

				<div class="auto_flow">
					<div class="pull_left">
						<span style="margin-right: 6pt">Sanitary Permit No.</span>
						<b class="text-center values" style="width: 108pt; font-size: 14pt">{{ $permit->sanitary_permit_number }}</b>
					</div>

					<div class="pull_right">
						<span style="margin-right: 6pt">Date Issued</span>
						<b class="text-center values" style="width: 144pt; font-size: 14pt">{{ $permit->issuance_date }}</b>
					</div>
				</div>

				<br>

				<div class="auto_flow">
					<div class="pull_left">
						<span style="margin-right: 6pt">Date of Expiration</span>
						<b class="text-center values" style="width: 144pt; font-size: 14pt">{{ $permit->expiration_date }}</b>
					</div>
				</div>

				<p class="text-justify">
					This permit is non-transferable and will be revoked for violation/s of Sanitary Rules, Laws or Regulations 
					of P.D. 856 and Pertinent Local Ordinances.
				</p>

				<br>

				<div class="auto_flow">
					<span class="pull_left" style="margin-top: 4pt; width: 88pt; text-align: right;">Recommending Approval</span>
					<span class="pull_right text-center values" style="width: 380pt; font-family: serif; font-size: 13pt; margin-top: 40pt">
						<b>{{ strtoupper($permit->sanitary_inspector) }}</b>
					</span>
					<b style="display: block; float: right; width: 380pt;font-family: serif; " class="text-center">Sanitary Inspector</b>
				</div>

				<div class="auto_flow">
					<span class="pull_left" style="margin-top: 4pt; width: 88pt; text-align: right;">Approved</span>
					<span class="pull_right text-center values" style="width: 380pt; font-size: 13pt; margin-top: 40pt">
					</span>
					<b style="display: block; float: right; width: 380pt; font-family: serif;" class="text-center">RENATO R. MATEO, M. D.</b>
					<b style="display: block; float: right; width: 380pt; font-family: serif; font-size: 10.5pt;" class="text-center">CITY HEALTH OFFICER</b>
				</div>
			</div>

			<br>

			<b style="font-size: 10pt; font-family: sans-serif;">CHO-053-&#216;</b>
		</div>
	</div>
</body>
<script>
</script>
</html>