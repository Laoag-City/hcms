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
		$('.dynamic_input').attr('readonly', false);

	else
		$('.dynamic_input').attr('readonly', true);

	if(fade)
		$('#update_button').transition('fade');
}

$('.delete_button').click(function(){
	$('.delete_modal_name').text('Sanitary Permit');
	$('#delete_form').attr('action', '/sanitary_permit/' + $(this).attr('data-id'));
	$('#delete_form').modal('show');
});