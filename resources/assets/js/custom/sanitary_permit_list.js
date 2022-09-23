$('.delete_button').click(function(){
	$('.delete_modal_name').text('Sanitary Permit');
	$('#delete_form').attr('action', '/sanitary_permit/' + $(this).attr('data-id'));
	$('#delete_form').modal('show');
});