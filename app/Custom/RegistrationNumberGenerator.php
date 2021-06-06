<?php

namespace App\Custom;

class RegistrationNumberGenerator
{
	public function getRegistrationNumber($model, $reg_num_field)
	{
        $year_now = date('Y', strtotime('now'));
        $total_registrations_this_year = $model::where($reg_num_field, 'like', "$year_now%")->count();
        $iteration = 1;

        do
        {
            $registration_number = "$year_now-" . sprintf('%05d', $total_registrations_this_year + $iteration);
            ++$iteration;
        }
        
        while($model::where($reg_num_field, '=', $registration_number)->count() > 0);

        return $registration_number;
	}
}

?>