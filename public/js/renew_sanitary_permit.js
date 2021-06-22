$('.ui.checkbox').checkbox();
$('.field').popup();

$('input[name=id]').change(function(){
	$('#pre-renew-form').submit();
});

$('.delete.button').click(function(){
	$('.delete_modal_name').text('Health Certificate');
	$('#delete_form').attr('action', '/health_certificate' + '/' + $(this).attr('data-id'));
	$('#delete_form').modal('show');
});

$('input[name=permit_type]').change(function(){
	switchPermitOwnerType();
});

switchPermitOwnerType();

function switchPermitOwnerType()
{
	if($('input[name=permit_type]:checked').val() == 'individual')
	{
		$('.field_individual').show();
		$('.field_business').hide();
		return;
	}

	else if($('input[name=permit_type]:checked').val() == 'business')
	{
		$('.field_business').show();
		$('.field_individual').hide();
		return;
	}

	//else statements executes if permit_type is unchecked
	else
	{
		if($('input[name=permit_type]').attr('value') == 'individual')
		{
			$('.field_business').show();
			$('.field_individual').hide();
			return;
		}

		else
		{
			$('.field_individual').show();
			$('.field_business').hide();
			return;
		}
	}
}