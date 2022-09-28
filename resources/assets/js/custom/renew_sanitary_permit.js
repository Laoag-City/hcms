$('.ui.checkbox').checkbox();
$('.field').popup();

$('input[name=id]').change(function(){
	$('#pre-renew-form').submit();
});

$('.delete.button').click(function(){
	$('.delete_modal_name').text('Sanitary Permit');
	$('#delete_form').attr('action', '/sanitary_permit' + '/' + $(this).attr('data-id'));
	$('#delete_form').modal('show');
});

$('input[name=permit_owner_type]').change(function(){
	switchPermitOwnerType();
});

if($('input[name=permit_owner_type]').attr('value') == 'individual')
{
	$('input.field_individual').attr('readonly', false);
	$('select.field_individual').attr('disabled', false);
	$('.field_business').attr('readonly', true);
}

else
{
	$('.field_business').attr('readonly', false);
	$('input.field_individual').attr('readonly', true);
	$('select.field_individual').attr('disabled', true);
}

switchPermitOwnerType();

function switchPermitOwnerType()
{
	if($('input[name=permit_owner_type]:checked').val() == 'individual')
	{
		$('.field_individual').show();
		$('.field_business').hide();
		return;
	}

	else if($('input[name=permit_owner_type]:checked').val() == 'business')
	{
		$('.field_business').show();
		$('.field_individual').hide();
		return;
	}

	//else statements executes if permit_owner_type is unchecked
	else
	{
		if($('input[name=permit_owner_type]').attr('value') == 'individual')
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