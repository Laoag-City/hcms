<?php

namespace App\Custom;

class RegistrationNumberGenerator
{
	public function getRegistrationNumber($model, $reg_num_field, $year)
	{
        $total_registrations_this_year = $model::select($reg_num_field)
                                        ->where($reg_num_field, 'like', "$year%")
                                        ->get();

        if($total_registrations_this_year->isNotEmpty())
        {
            $total_registrations_this_year = $total_registrations_this_year->sortByDesc($reg_num_field)
                                                                            ->first()
                                                                            ->$reg_num_field;

            $total_registrations_this_year = (int)explode('-', $total_registrations_this_year)[1];
        }

        else
            $total_registrations_this_year = 0;

        $iteration = 1;

        do
        {
            $registration_number = "$year-" . sprintf('%05d', $total_registrations_this_year + $iteration);
            ++$iteration;
        }
        
        while($model::where($reg_num_field, '=', $registration_number)->count() > 0);

        return $registration_number;
	}

    public function getYearRegistered($registration_number)
    {
        return (int)explode('-', $registration_number)[0];
    }
}

?>