<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Applicant;
use App\Business;
use App\HealthCertificate;
use App\PinkHealthCertificate;
use App\SanitaryPermit;

class ReportController extends Controller
{
    public function __invoke(Request $request)
    {
        $records_year_start = 2021;

        $total_applicants = Applicant::count();
        $total_businesses = Business::count();

        $total_yellow_health_certificates = HealthCertificate::where('duration', HealthCertificate::CERTIFICATE_TYPES['Yellow']['string'])->count();
        $total_green_health_certificates = HealthCertificate::where('duration', HealthCertificate::CERTIFICATE_TYPES['Green']['string'])->count();

        $total_food_sanitary_permits = SanitaryPermit::where('permit_classification', SanitaryPermit::PERMIT_CLASSIFICATIONS[0])->count();
        $total_nonfood_sanitary_permits = SanitaryPermit::where('permit_classification', SanitaryPermit::PERMIT_CLASSIFICATIONS[1])->count();

        $total_pink_card = PinkHealthCertificate::count();

        $total_registered_hc_for_each_year = collect();
        $total_registered_sp_for_each_year = collect();
        $total_registered_pc_for_each_year = collect();

        $year_now = (int)date('Y', strtotime('now'));

        while($records_year_start <= $year_now)
        {
            $hc_current_year_total = HealthCertificate::where('registration_number', 'like', "$records_year_start-%")->count();
            $sp_current_year_total = SanitaryPermit::where('sanitary_permit_number', 'like', "$records_year_start-%")->count();
            $pc_current_year_total = PinkHealthCertificate::where('registration_number', 'like', "$records_year_start-%")->count();

            $total_registered_hc_for_each_year->put($records_year_start, $hc_current_year_total);
            $total_registered_sp_for_each_year->put($records_year_start, $sp_current_year_total);
            $total_registered_pc_for_each_year->put($records_year_start, $pc_current_year_total);

            $records_year_start++;
        }

        return view('report', [
            'title' => 'Summary of Records',
            
            'total_applicants' => $total_applicants,
            'total_businesses' => $total_businesses,

            'total_yellow_health_certificates' => $total_yellow_health_certificates,
            'total_green_health_certificates' => $total_green_health_certificates,

            'total_food_sanitary_permits' => $total_food_sanitary_permits,
            'total_nonfood_sanitary_permits' => $total_nonfood_sanitary_permits,

            'total_pink_card' => $total_pink_card,

            'total_registered_hc_for_each_year' => $total_registered_hc_for_each_year,
            'total_registered_sp_for_each_year' => $total_registered_sp_for_each_year,
            'total_registered_pc_for_each_year' => $total_registered_pc_for_each_year
        ]);
    }
}