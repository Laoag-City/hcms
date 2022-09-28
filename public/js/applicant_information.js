alterFormState();
	
$('.ui.checkbox').checkbox();
$('.field').popup(false);
$('.menu .item').tab();

$('input[name="edit_mode"]').change(function(){
	alterFormState(true);
});

function alterFormState(fade)
{
	if($('input[name="edit_mode"]').is(':checked'))
	{
		$('.dynamic_input').attr('readonly', false);
		$('.dynamic_select').attr('disabled', false).css('display', 'block');
		$('input.view_only').css('display', 'none');
	}

	else
	{
		$('.dynamic_input').attr('readonly', true);
		$('.dynamic_select').attr('disabled', true).css('display', 'none');
		$('input.view_only').css('display', 'block');
	}

	if(fade)
		$('#update_button').transition('fade');
}

$('.delete_button').click(function(){
	let delete_title;
	let form_action;
	let record_type = $(this).attr('data-type');

	if(record_type == 'hc')
	{
		delete_title = 'Health Certificate';
		form_action = '/health_certificate/';
	}

	else if(record_type == 'phc')
	{
		delete_title = 'Pink Card';
		form_action = '/pink_card/';
	}

	else
	{
		delete_title = 'Sanitary Permit';
		form_action = '/sanitary_permit/';
	}

	$('.delete_modal_name').text(delete_title);
	$('#delete_form').attr('action', form_action + $(this).attr('data-id'));
	$('#delete_form').modal('show');
});