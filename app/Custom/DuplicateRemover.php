<?php

namespace App\Custom;

use App\Applicant;
use App\Business;
use App\HealthCertificate;
use App\SanitaryPermit;
use App\PinkHealthCertificate;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DuplicateRemover
{
	public function __invoke()
	{
		/*
        1. get total records
        2. loop each record and use where statement on name, age, and gender fields
        3. all query results' certificates and permits will be linked to the current record being checked
        4. save the duplicates' data, delete them, then update total record value
        */

        $folder = 'duplicates';

        if(!Storage::exists($folder))
            Storage::makeDirectory($folder);

        //get all applicant ids
        $all_applicant_ids = DB::table('applicants')->select('applicant_id')->get();
        $removed_ids = collect([]);

        for($i = 0; $i < $all_applicant_ids->count() - 1; $i++)
        {
            //get current applicant being checked
            $current_record = Applicant::find($all_applicant_ids[$i]->applicant_id);

            //get all duplicates
            $duplicates = Applicant::where([
                ['applicant_id', '<>', $current_record->applicant_id],
                ['first_name', '=', $current_record->first_name],
                ['middle_name', '=', $current_record->middle_name],
                ['last_name', '=', $current_record->last_name],
                ['suffix_name', '=', $current_record->suffix_name],
                //['age', '=', $current_record->age],
                ['gender', '=', $current_record->gender]
            ])->get();

            if($duplicates->isNotEmpty())
            {
                //get all duplicates' related ids
                $duplicate_ids = $duplicates->pluck('applicant_id');

                //transfer all duplicates' records to the original applicant and remove all duplicates
                HealthCertificate::whereIn('applicant_id', $duplicate_ids->toArray())->update(['applicant_id' => $current_record->applicant_id]);
                SanitaryPermit::whereIn('applicant_id', $duplicate_ids->toArray())->update(['applicant_id' => $current_record->applicant_id]);
                PinkHealthCertificate::whereIn('applicant_id', $duplicate_ids->toArray())->update(['applicant_id' => $current_record->applicant_id]);
                Applicant::whereIn('applicant_id', $duplicate_ids->toArray())->delete();

                $removed_ids->push($duplicates);

                //remove duplicates' ids in the ids array
                $all_applicant_ids = $all_applicant_ids->whereNotIn('applicant_id', $duplicate_ids)->values();
            }
        }

        if($removed_ids->isNotEmpty())
        {
            $removed_ids = $removed_ids->flatten(1);
            $date = date('Y-m-d_H-i-s', strtotime('now'));
            $file = fopen(storage_path("app\\$folder\\removed_applicant_duplicates_$date.csv"), 'w');

            foreach($removed_ids as $applicant)
            {
                fputcsv($file, [
                    $applicant->applicant_id,
                    $applicant->first_name,
                    $applicant->middle_name,
                    $applicant->last_name,
                    $applicant->suffix_name,
                    $applicant->age,
                    $applicant->gender,
                    $applicant->created_at,
                    $applicant->updated_at
                ]);
            }

            fclose($file);

            Log::info('Successfully saved the removed applicant duplicates at ' . storage_path("app\\$folder\\removed_applicant_duplicates_$date.csv"));
        }

        /////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////
        //Same logic from above but this time it's for Businesses

        $all_business_ids = DB::table('businesses')->select('business_id')->get();
        $removed_ids = collect([]);

        for($i = 0; $i < $all_business_ids->count() - 1; $i++)
        {
            //get current business being checked
            $current_record = Business::find($all_business_ids[$i]->business_id);

            //get all duplicates
            $duplicates = Business::where([
                ['business_id', '<>', $current_record->business_id],
                ['business_name', '=', $current_record->business_name],
            ])->get();

            if($duplicates->isNotEmpty())
            {
                //get all duplicates' related ids
                $duplicate_ids = $duplicates->pluck('business_id');

                //transfer all duplicates' records to the original business and remove all duplicates
                SanitaryPermit::whereIn('business_id', $duplicate_ids->toArray())->update(['business_id' => $current_record->business_id]);
                Business::whereIn('business_id', $duplicate_ids->toArray())->delete();

                $removed_ids->push($duplicates);

                //remove duplicates' ids in the ids array
                $all_business_ids = $all_business_ids->whereNotIn('business_id', $duplicate_ids)->values();
            }
        }

        if($removed_ids->isNotEmpty())
        {
            $removed_ids = $removed_ids->flatten(1);
            $date = date('Y-m-d_H-i-s', strtotime('now'));
            $file = fopen(storage_path("app\\$folder\\removed_business_duplicates_$date.csv"), 'w');

            foreach($removed_ids as $business)
            {
                fputcsv($file, [
                    $business->business_id,
                    $business->business_name,
                    $business->created_at,
                    $business->updated_at
                ]);
            }

            fclose($file);

            Log::info('Successfully saved the removed business duplicates at ' . storage_path("app\\$folder\\removed_business_duplicates_$date.csv"));
        }
	}
}

?>