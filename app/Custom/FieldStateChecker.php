<?php

namespace App\Custom;

use Illuminate\Support\ViewErrorBag;

class FieldStateChecker
{

	//does a specific check by identifying what option is selected based from old input and existing data from a data source
	public function dropdown_select_check($old_data, $existing_data, $options)
	{
		$data_to_use = $old_data != null ? $old_data : $existing_data;

		foreach($options as $option)
		{
			if($option == $data_to_use)
				return $option;
		}
	}
}

?>