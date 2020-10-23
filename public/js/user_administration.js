$('.field').popup();
$('.delete.button').click(function(){
	$('#delete_form').attr('action', delete_url + '/' + $(this).attr('data-id'));

	$('#delete_modal').modal('show');
});