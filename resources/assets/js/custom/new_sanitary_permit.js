$('.field').popup();
$('.ui.checkbox').checkbox();

alterFormState();

$('input[name=permit_type]').change(function(){
	alterFormState();
});

var permit_owner_type = null;

//search logic
$('.ui.search').search({
	apiSettings: {
		url: '/applicant_search?q={query}',

		data: {
			owner_type: permit_owner_type
		}
	},

	minCharacters: 3,

	searchOnFocus: false,

	maxResults: 25,

	duration: 100,

	searchDelay: 200,

	fields: {
		title: 'whole_name',
		description: 'basic_info'
	},

	onResults: function(response){
		$('.dynamic_on_search').val('');
	},

	onSelect: function(result, response){
		$('input[name="id"]').val(result.id);
		$('input[name="first_name"]').val(result.first_name);
		$('input[name="middle_name"]').val(result.middle_name);
		$('input[name="last_name"]').val(result.last_name);
		$('select[name="suffix_name"]').val(result.suffix_name);
		$('input[name="age"]').val(result.age);
		$('select[name="gender"]').val(result.gender);
	},

	onResultsClose: function(){
		console.log('closed');
	}
});

function alterFormState()
{
	if($('input[name=permit_type]:checked').val() == 'individual')
	{
		$('#searchPermitOwner').show();
		$('.field_business').attr('disabled', true).hide();
		$('.field_individual').attr('disabled', false).show();
	}

	else if($('input[name=permit_type]:checked').val() == 'business')
	{
		$('#searchPermitOwner').show();
		$('.field_individual').attr('disabled', true).hide();
		$('.field_business').attr('disabled', false).show();
	}

	else
		$('.field_individual, .field_business').attr('disabled', true).hide();
}