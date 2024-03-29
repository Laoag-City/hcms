let cert_type_duration = {
	years: 0,
	months: 0,
	days: 0
};

let issuance_date = "";

$(document).ready(function(){
	$('.field').popup();
	$('.ui.checkbox').checkbox();
	toggleWholeName();
});

//checkbox logic
$('input[name="existing_client"]').change(function(){
	$('.dynamic_on_search, input[name="whole_name"]').val('');
	toggleWholeName();
});

//search logic
$('.ui.search').search({
	apiSettings: {
		url: '/applicant_search?q={query}'
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

//certificate type logic
$('select[name=certificate_type]').change(function(){
	cert_type_duration.years = Number($('option[value="' + this.value + '"]').attr('data-years'));
	cert_type_duration.months = Number($('option[value="' + this.value + '"]').attr('data-months'));
	cert_type_duration.days = Number($('option[value="' + this.value + '"]').attr('data-days'));
	//getExpirationDate();
});

//issuance date logic
$('input[name=date_of_issuance]').change(function(){
	issuance_date = this.value;
	//getExpirationDate();
});

//submit logic
$('#submit_health_certificate').click(function(event){
	event.preventDefault();
	$('.dynamic_select').removeAttr('disabled');
	$('#health_certificate_form').submit();
});

function toggleWholeName()
{
	if($('input[name="existing_client"]').is(':checked'))
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

	$('#searchApplicant').removeClass(class_name[1]).addClass(class_name[0]);
	$('input[name="whole_name"').removeAttr(state[1]).attr(state[0], true);
	$('.dynamic_input').attr('readonly', field_state);
	$('.dynamic_select').attr('disabled', field_state);
}

function getExpirationDate()
{
	if($('select[name=certificate_type]').val() != "" && issuance_date != "")
	{
		let expiration_date = dayjs(new Date(issuance_date))
								.add(cert_type_duration.years, 'y')
								.add(cert_type_duration.months, 'M')
								.add(cert_type_duration.days, 'd')
								.format('YYYY-MM-DD');

		$('input[name=date_of_expiration]').val(expiration_date);
	}

	else
		$('input[name=date_of_expiration]').val("");
}