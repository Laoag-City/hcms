alterFormState();
	
$('.ui.checkbox').checkbox();
$('.field').popup(false);

$('.update_switches').change(function(){
	let to_switch_off = '';

	if($(this).val() == 'edit')
		to_switch_off = '#renew_switch';

	else if($(this).val() == 'edit_renew')
		to_switch_off = '#edit_switch';

	$(to_switch_off).prop('checked', false);

	alterFormState(true);
});

function alterFormState(fade)
{
	if($('.update_switches').is(':checked'))
		$('.dynamic_input').attr('readonly', false);

	else
		$('.dynamic_input').attr('readonly', true);

	if(fade)
		$('#update_button').transition('fade');
}