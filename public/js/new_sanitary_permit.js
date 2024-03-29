$(document).ready(function(){
	$('.field').popup();
	$('.ui.checkbox').checkbox();
	changePermitOwnerType();
	toggleExistingNameField();
});

//permit owner type logic
$('input[name=permit_owner_type]').change(function(){
	changePermitOwnerType(true);
});

//checkbox logic
$('input[name="has_existing_registered_name"]').change(function(){
	$('.field_individual, .field_business, input[name="id"], input[name="existing_registered_name"]').val('');
	toggleExistingNameField();
});

//search logic
$('.ui.search').search({
	apiSettings: {
		beforeSend: function(settings){
			if($('input[name=permit_owner_type]:checked').val() == 'individual')
				settings.url = '/applicant_search?q={query}';
			else
				settings.url = '/business_search?q={query}';

			/*settings.data = {
				existing_registered_name_type: $('input[name=permit_owner_type]:checked').val()
			};*/

			return settings;
		}
	},

	minCharacters: 3,

	searchOnFocus: false,

	maxResults: 25,

	duration: 100,

	searchDelay: 200,

	cache: false,

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
		$('input[name="suffix_name"]').val(result.suffix_name);
		$('input[name="age"]').val(result.age);
		$('select[name="gender"]').val(result.gender);

		$('input[name=business_name]').val(result.whole_name);
	},

	onResultsClose: function(){
		console.log('closed');
	}
});

//submit logic
$('#submit_sanitary_permit').click(function(event){
	event.preventDefault();
	if($('input[name=permit_owner_type]:checked').val() != 'business')
	{
		$('.dynamic_select').removeAttr('disabled');
	}
	$('#sanitary_permit_form').submit();
});

function changePermitOwnerType(reset_owner_fields = false)
{
	if(reset_owner_fields)
	{
		$('input[name="id"], input[name=existing_registered_name], .field_individual, .field_business').val('');
		$('input[name=has_existing_registered_name]').prop('checked', false);
		toggleExistingNameField();
	}

	if($('input[name=permit_owner_type]:checked').val() == 'individual')
	{
		$('.field_business').attr('disabled', true).hide();
		$('.field_existing, .field_individual').attr('disabled', false).show();
	}

	else if($('input[name=permit_owner_type]:checked').val() == 'business')
	{
		$('.field_individual').attr('disabled', true).hide();
		$('.field_existing, .field_business').attr('disabled', false).show();
	}

	else
		$('.field_existing, .field_individual, .field_business').attr('disabled', true).hide();
}

function toggleExistingNameField()
{
	if($('input[name="has_existing_registered_name"]').is(':checked'))
	{
		var class_name = ['fadeIn', 'fadeOut'];
		var state = ['required', 'disabled'];
		var field_state = true;
	}

	else
	{
		var class_name = ['fadeOut', 'fadeIn'];
		var state = ['disabled', 'required'];
		var field_state = false;
	}

	$('#searchPermitOwner').removeClass(class_name[1]).addClass(class_name[0]);
	$('input[name="existing_registered_name"').removeAttr(state[1]).attr(state[0], true);

	if($('input[name=permit_owner_type]:checked').val() == 'individual')
	{
		$('.field_individual.dynamic_input').attr('readonly', field_state);
		$('.field_individual.dynamic_select').attr('disabled', field_state);
	}

	else if($('input[name=permit_owner_type]:checked').val() == 'business')
		$('.field_business.dynamic_input').attr('readonly', field_state);
}