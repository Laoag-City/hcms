$('.field').popup();
$('.ui.checkbox').checkbox();

alterFormState();

$('input[name=permit_type]').change(function(){
	alterFormState();
});

function alterFormState()
{
	if($('input[name=permit_type]:checked').val() == 'individual')
	{
		$('.field_business').attr('disabled', true).hide();
		$('.field_individual').attr('disabled', false).show();
	}

	else if($('input[name=permit_type]:checked').val() == 'business')
	{
		$('.field_individual').attr('disabled', true).hide();
		$('.field_business').attr('disabled', false).show();
	}

	else
		$('.field_individual, .field_business').attr('disabled', true).hide();
}