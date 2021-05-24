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