$(document).ready(function(){
	$('.field').popup();
	$('.ui.checkbox').checkbox();
	getExpirationDate();
	alterFormState();
});

$('.update_switches').change(function(){
	alterFormState();
});

$('input[name=date_of_issuance]').change(function(){
	getExpirationDate();
});

function getExpirationDate()
{
	let expiration_date = dayjs(new Date($('input[name=date_of_issuance]').val()))
							.add(validity, 'M')
							.format('YYYY-MM-DD');

	$('input[name=date_of_expiration]').val(expiration_date);
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