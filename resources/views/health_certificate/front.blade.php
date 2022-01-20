<div id="front_preview" class="health_certificate">
	<div id="outer_border">
		<div id="inner_border">
			<div id="contents">
				<div id="header_1">
					<img id="logo" src="{{ $logo }}" class="pull_left">

					<p class="text_right standard_font"><b>EHS Form No. 102-A-B</b></p>
					<p class="text_right" style="font-size: 12pt; letter-spacing: 3pt;"><b>DEPARTMENT OF HEALTH</b></p>
					<p class="text-center standard_font" style="margin-top: 1pt;"><b>Office of the City Health Officer</b></p>
					<p class="text-center standard_font"><b>LAOAG CITY</b></p>
					<div style="margin: 0pt auto 0pt auto; width: 124pt; border-top: .5625pt solid black; overflow: auto;"></div>
				</div>

				<div id="header_2" class="text_right">
					<div class="label standard_font">Reg. No.</div><div id="reg_number" class="standard_font field"><b>{{ $health_certificate->registration_number }}</b></div>
					<h4 id="h4_front" class="no_margin text-center" style="margin-top: 4.5pt; /*background-color: {{ $color }}*/">HEALTH CERTIFICATE</h4>
				</div>

				<div style="margin-top: 5pt;">
					<p class="text-justify no_margin" style="margin-top: 4.5pt; font-size: 8.45pt;">
						Pursuant to the provisions of P. D. 522 and 856 and City Ord. No 1057 S 85, this certificate is issued to
					</p>
				</div>

				<div style="margin-top: 5pt;">
					<div class="label standard_font">Name</div><div id="name" class="standard_font field"><b>{{ $health_certificate->applicant->formatName() }}</b></div>
				</div>

				<div style="margin-top: 5pt;">
					<div class="label standard_font">Age</div><div id="age" class="standard_font field">{{ $health_certificate->applicant->age }}</div>
					<div class="label standard_font">Sex</div><div id="sex" class="standard_font field">{{ $health_certificate->applicant->gender == 1 ? 'M' : 'F' }}</div>
					<div class="label standard_font">Work Type</div><div id="work_type" class="standard_font field">{{ $health_certificate->work_type }}</div>
				</div>

				<div style="margin-top: 5pt;">
					<div class="label standard_font">Establishment</div><div id="establishment" class="standard_font field">{{ $health_certificate->establishment }}</div>
				</div>

				<div style="margin-top: 6pt;">
					<img {{ !$picture ?: "src=$picture"}} id="picture" class="pull_left">

					<div class="pull_right" style="margin-top: 4.5pt;">
						<div id="signature_si_in_charge" class="standard_font field" style="border-bottom: 0.7625pt solid black;"></div>
						<i class="label standard_font text-center" style="display: block;">Signature</i>
					</div>

					<div class="pull_right" style="margin-top: 4.5pt;">
						<div id="signature_si_in_charge" class="standard_font field" style="border-bottom: 0.7625pt solid black;"></div>
						<i class="label standard_font text-center" style="display: block;">CSO/SI In-Charge</i>
					</div>

					<div class="pull_right" style="margin-top: 18pt; margin-right: 30pt;">
						<b class="label standard_font text-center" style="display: block; width: 110pt;">JOSEPH D. ADAYA, M.D.</b>
						<div class="label standard_font text-center" style="display: block;">OIC - City Health Officer</div>
					</div>
				</div>

				<!--<div class="standard_font" style="clear: left; margin-left: 15pt; text-align: left;">CHO-054-&#216;</div>-->
			</div>
		</div>
	</div>
</div>