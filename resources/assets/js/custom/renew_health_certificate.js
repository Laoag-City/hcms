$('.field').popup();

$('input[name=id]').change(function(){
	$('#pre-renew-form').submit();
});

$('.delete.button').click(function(){
	$('.delete_modal_name').text('Health Certificate');
	$('#delete_form').attr('action', '/health_certificate' + '/' + $(this).attr('data-id'));
	$('#delete_form').modal('show');
});