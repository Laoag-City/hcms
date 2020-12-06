let cert_type_duration = {
	years: 0,
	months: 0,
	days: 0
};

let issuance_date = "";

$(document).ready(function(){
	$('.field').popup();
	$('.ui.checkbox').checkbox();
});

$('select[name=certificate_type]').change(function(){
	cert_type_duration.years = Number($('option[value="' + this.value + '"]').attr('data-years'));
	cert_type_duration.months = Number($('option[value="' + this.value + '"]').attr('data-months'));
	cert_type_duration.days = Number($('option[value="' + this.value + '"]').attr('data-days'));
	getExpirationDate();
});

$('input[name=date_of_issuance]').change(function(){
	issuance_date = this.value;
	getExpirationDate();
});

function getExpirationDate()
{
	if($('select[name=certificate_type]').val() != "" && issuance_date != "")
	{
		let expiration_date = dayjs(new Date(issuance_date))
								.add(cert_type_duration.years, 'y')
								.add(cert_type_duration.months, 'M')
								.add(cert_type_duration.days, 'd')
								.format('YYYY-MM-DD');

		$('input[name=date_of_expiration]').val(expiration_date);
	}

	else
		$('input[name=date_of_expiration]').val("");
}