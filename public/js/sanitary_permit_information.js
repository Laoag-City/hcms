$('.ui.checkbox').checkbox();
$('.field').popup();

alterFormState();
switchPermitOwnerType();

$('input[name=update_mode]').change(function(){
	alterFormState();
});

$('input[name=permit_type]').change(function(){
	switchPermitOwnerType();
});

function alterFormState()
{
	if($('input[name=update_mode]').is(':checked'))
	{
		if($('input[name=permit_type]').attr('value') == 'individual')
		{
			$('input.field_individual').attr('readonly', false);
			$('select.field_individual').attr('disabled', false);
		}

		else
		{
			$('.field_business').attr('readonly', false);
		}

		$('.dynamic_input').attr('readonly', false);
		$('#update_button, #switch_permit_type_field').show();
	}

	else
	{
		$('input[name=permit_type]').prop('checked', false);
		switchPermitOwnerType()
		$('input.field_individual, .field_business, .dynamic_input').attr('readonly', true);
		$('select.field_individual').attr('disabled', true);
		$('#update_button, #switch_permit_type_field').hide();
	}
}

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