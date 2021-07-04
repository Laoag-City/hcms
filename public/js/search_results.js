$('.delete_button').click(function(){
	let delete_title;
	let form_action;

	if($(this).attr('data-type') == 'hc')
	{
		delete_title = 'Health Certificate';
		form_action = '/health_certificate/';
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