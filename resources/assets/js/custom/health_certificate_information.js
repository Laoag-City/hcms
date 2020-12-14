let cert_type_duration = {
	years: 0,
	months: 0,
	days: 0
};

let issuance_date = $('input[name=date_of_issuance]').val();

alterFormState();
	
$('.ui.checkbox').checkbox();
$('.field').popup(false);

$('.update_switches').change(function(){
	let to_switch_off = '';

	if($(this).val() == 'edit')
		to_switch_off = '#renew_switch';

	else if($(this).val() == 'edit_renew')
		to_switch_off = '#edit_switch';

	$(to_switch_off).prop('checked', false);

	alterFormState();
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

function alterFormState()
{
	if($('.update_switches').is(':checked'))
	{
		$('.dynamic_input').attr('readonly', false);
		$('select.dynamic_input').attr('disabled', false);
		$('#update_button').transition('show');
	}

	else
	{
		$('.dynamic_input').attr('readonly', true);
		$('select.dynamic_input').attr('disabled', true);
		$('#update_button').transition('hide');
	}
}