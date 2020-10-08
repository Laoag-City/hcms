<?php

namespace App\Custom;

trait DateToInputFormatter
{
	abstract public function dateToInput($attribute);

	public function convertDateForInputField($attribute)
	{
		return date('Y-m-d', strtotime($attribute));
	}
}

?>