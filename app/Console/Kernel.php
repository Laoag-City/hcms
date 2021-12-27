<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use App\Applicant;
use App\HealthCertificate;
use App\SanitaryPermit;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {   
        //task for removing duplicate applicant records
        $schedule->call(function() {
             /*
            1. get total records
            2. loop each record and use where statement on name, age, and gender fields
            3. all query results' certificates and permits will be linked to the current record being checked
            4. save the duplicates' data, delete them, then update total record value
            */

            //dd(Applicant::with('health_certificates')->get()->pluck('health_certificates')->flatten());

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
                    Applicant::whereIn('applicant_id', $duplicate_ids->toArray())->delete();

                    $removed_ids->push($duplicates);

                    //remove duplicates' ids in the ids array
                    $all_applicant_ids = $all_applicant_ids->whereNotIn('applicant_id', $duplicate_ids)->values();
                }
            }

            if($removed_ids->isNotEmpty())
            {
                $removed_ids = $removed_ids->flatten(1);
                $date = date('M-d-Y_h-i-s', strtotime('now'));
                $file = fopen(storage_path("app\\removed_duplicates_$date.csv"), 'w');

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

                Log::info('Successfully saved the removed applicant duplicates at ' . storage_path("app\\removed_duplicates_$date.csv");
            }
        })->weekly()->mondays()->at('08:00');
    }

    /**
     * Register the Closure based commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        require base_path('routes/console.php');
    }
}
