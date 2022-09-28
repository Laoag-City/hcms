$(document).ready(function(){
	$('.field').popup();
	getExpirationDate();
});

$('input[name=id]').change(function(){
	$('#pre-renew-form').submit();
});

$('input[name=date_of_issuance]').change(function(){
	getExpirationDate();
});

$('.delete.button').click(function(){
	$('.delete_modal_name').text('Pink Card');
	$('#delete_form').attr('action', '/pink_card' + '/' + $(this).attr('data-id'));
	$('#delete_form').modal('show');
});

function getExpirationDate()
{
	let expiration_date = dayjs(new Date($('input[name=date_of_issuance]').val()))
							.add(validity, 'M')
							.format('YYYY-MM-DD');

	$('input[name=date_of_expiration]').val(expiration_date);
}