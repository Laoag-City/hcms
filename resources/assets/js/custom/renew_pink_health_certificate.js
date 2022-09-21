$('.field').popup();

$('input[name=id]').change(function(){
	$('#pre-renew-form').submit();
});

$('.delete.button').click(function(){
	$('.delete_modal_name').text('Pink Card');
	$('#delete_form').attr('action', '/pink_card' + '/' + $(this).attr('data-id'));
	$('#delete_form').modal('show');
});