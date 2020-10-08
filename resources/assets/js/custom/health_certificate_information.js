alterFormState();
	
$('.ui.checkbox').checkbox();
$('.field').popup(false);

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