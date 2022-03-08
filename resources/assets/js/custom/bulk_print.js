if(to_print_ids.length == 0)
	$('table, #submit_button').hide();

function removeRow(id)
{
	$('tr[data-id=' + id + ']').remove();

	let index = to_print_ids.indexOf(id);
	to_print_ids.splice(index, 1);

	if(to_print_ids.length == 0)
		$('table, #submit_button').hide();
}

$('.ui.search').search({
	apiSettings: {
		url: '/health_certificate/search?q={query}'
	},

	searchOnFocus: false,

	minCharacters: 3,

	maxResults: 12,

	duration: 0,

	fields: {
		title: 'label',
		description: 'basic_info'
	},

	onResults: function(response){
	},

	onSelect: function(result, response){
		if(!to_print_ids.includes(result.id))
		{
			to_print_ids.push(result.id);

			$('#to_prints').append(
				`
				<tr data-id="${result.id}">
					<input type="hidden" name="ids[]" value="${result.id}">

					<td>${result.whole_name}</td>

					<td>${result.hc_no}</td>

					<td>
						<button type="button" class="ui mini red button remove_button" onclick="removeRow(${result.id})">Remove</button>
					</td>
				</tr>
				`
			);

			$('table, #submit_button').show();
		}
	},

	onResultsClose: function(){
	}
});

$('#search_applicant').focusin(function(){
	$(this).val('');
});