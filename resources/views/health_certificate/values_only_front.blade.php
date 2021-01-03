<div id="front_preview" class="health_certificate">
	<div id="outer_border" class="no_outer_border">
		<div id="inner_border" class="no_inner_border">
			<div id="contents">
				<div id="header_1" class="invisible_on_print">
					<img id="logo" src="{{ $logo }}" class="pull_left">

					<p class="text_right standard_font"><b>EHS Form No. 102-A-B</b></p>
					<p class="text_right" style="font-size: 10.5pt;"><b>DEPARTMENT OF HEALTH</b></p>
					<p class="text-center standard_font"><b>Office of the City Health Officer</b></p>
					<p class="text-center standard_font"><b>LAOAG CITY</b></p>
					<div style="margin: 0pt auto 0pt auto; width: 124pt; border-top: .5625pt solid black; overflow: auto;"></div>
				</div>

				<div id="header_2" class="text_right">
					<div class="label smaller_font invisible_on_print">Reg. No.</div><div id="reg_number" class="field no_border_on_print larger_font">{{ $health_certificate->registration_number }}</div>
					<h4 id="h4_front" class="no_margin text-center invisible_on_print" style="margin-top: 4.5pt; background-color: {{ $color }}">HEALTH CERTIFICATE</h4>
				</div>

				<div>
					<p class="text-justify no_margin invisible_on_print" style="margin-top: 4.5pt; font-size: 8.45pt;">
						Pursuant to the provisions of P. D. 522 and 856 and City Ord. No 1057 S 85, this certificate is issued to
					</p>
				</div>

				<div style="margin-top: 4.5pt;">
					<div class="label smaller_font invisible_on_print">Name</div><div id="name" class="field no_border_on_print larger_font">{{ $health_certificate->applicant->formatName() }}</div>
				</div>

				<div style="margin-top: 4.5pt;">
					<div class="label smaller_font invisible_on_print">Age</div><div id="age" class="field no_border_on_print larger_font">{{ $health_certificate->applicant->age }}</div>
					<div class="label smaller_font invisible_on_print">Sex</div><div id="sex" class="field no_border_on_print larger_font">{{ $health_certificate->applicant->gender == 1 ? 'M' : 'F' }}</div>
					<div class="label smaller_font invisible_on_print">Work Type</div><div id="work_type" class="field no_border_on_print larger_font">{{ $health_certificate->work_type }}</div>
				</div>

				<div style="margin-top: 4.5pt;">
					<div class="label smaller_font invisible_on_print">Establishment</div><div id="establishment" class="field no_border_on_print larger_font">{{ $health_certificate->establishment }}</div>
				</div>

				<div style="margin-top: 9pt;" class="invisible_on_print">
					<img {{ !$picture ?: "src=$picture"}} id="picture" class="pull_left">

					<div class="pull_right" style="margin-top: 4.5pt;">
						<div id="signature_si_in_charge" class="standard_font field" style="border-bottom: 0.7625pt solid black;"></div>
						<i class="label standard_font text-center" style="display: block;">Signature</i>
					</div>

					<div class="pull_right" style="margin-top: 9pt;">
						<div id="signature_si_in_charge" class="standard_font field" style="border-bottom: 0.7625pt solid black;"></div>
						<i class="label standard_font text-center" style="display: block;">CSO/SI In-Charge</i>
					</div>

					<div class="pull_right" style="margin-top: 9pt;">
						<b class="label standard_font text-center" style="display: block; width: 110pt;">RENATO R. MATEO, M.D.</b>
						<div class="label standard_font text-center" style="display: block;">City Health Officer</div>
					</div>
				</div>

				<div class="standard_font invisible_on_print" style="clear: left; margin-left: 15pt; text-align: left;">CHO-054-&#216;</div>
			</div>
		</div>
	</div>
</div>