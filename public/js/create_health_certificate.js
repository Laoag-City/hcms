let cert_type_duration = {
	years: 0,
	months: 0,
	days: 0
};

let issuance_date = "";

$(document).ready(function(){
	$('.field').popup();
	$('.ui.checkbox').checkbox();
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

$('select[name=certificate_type]').change(function(){
	cert_type_duration.years = Number($('option[value="' + this.value + '"]').attr('data-years'));
	cert_type_duration.months = Number($('option[value="' + this.value + '"]').attr('data-months'));
	cert_type_duration.days = Number($('option[value="' + this.value + '"]').attr('data-days'));
	//getExpirationDate();
});

$('input[name=date_of_issuance]').change(function(){
	issuance_date = this.value;
	//getExpirationDate();
});

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