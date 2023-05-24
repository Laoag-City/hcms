<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Applicant;
use App\Business;
use App\Year;
use App\DocumentType;
use App\DocumentCategory;
use App\Statistic;

class ReportController extends Controller
{
    public function __invoke(Request $request)
    {
        $year_ids = Year::orderBy('year', 'desc')->get()->pluck('year_id');

        $hc_id = DocumentType::where('document_name', 'Health Certificate')->first()->document_type_id;
        $pc_id = DocumentType::where('document_name', 'Pink Health Certificate')->first()->document_type_id;
        $sp_id = DocumentType::where('document_name', 'Sanitary Permit')->first()->document_type_id;

        $hc_results = DB::table('document_types')
                ->select('document_name', 'category', 'counts', 'year', 'statistic_id')
                ->where('document_types.document_type_id', $hc_id)
                ->join('document_categories', 'document_types.document_type_id', '=', 'document_categories.document_type_id')
                ->join('statistics', 'document_categories.document_category_id', '=', 'statistics.document_category_id')
                ->join('years', 'statistics.year_id', '=', 'years.year_id')
                ->orderBy('years.year', 'desc')
                ->get()
                ->groupBy('year');

        $pc_results = DB::table('document_types')
                ->select('document_name', 'category', 'counts', 'year', 'statistic_id')
                ->where('document_types.document_type_id', $pc_id)
                ->join('document_categories', 'document_types.document_type_id', '=', 'document_categories.document_type_id')
                ->join('statistics', 'document_categories.document_category_id', '=', 'statistics.document_category_id')
                ->join('years', 'statistics.year_id', '=', 'years.year_id')
                ->orderBy('years.year', 'desc')
                ->get()
                ->groupBy('year');

        $sp_results = DB::table('document_types')
                ->select('document_name', 'category', 'counts', 'year', 'statistic_id')
                ->where('document_types.document_type_id', $sp_id)
                ->join('document_categories', 'document_types.document_type_id', '=', 'document_categories.document_type_id')
                ->join('statistics', 'document_categories.document_category_id', '=', 'statistics.document_category_id')
                ->join('years', 'statistics.year_id', '=', 'years.year_id')
                ->orderBy('years.year', 'desc')
                ->get()
                ->groupBy('year');

        //dd($hc_results);

        return view('report', [
            'title' => 'Summary of Records',

            'total_registered_hc_for_each_year' => $hc_results,
            'total_registered_sp_for_each_year' => $sp_results,
            'total_registered_pc_for_each_year' => $pc_results,

            'hc_categories' => DocumentCategory::where('document_type_id', $hc_id)->get(),
            'sp_categories' => DocumentCategory::where('document_type_id', $sp_id)->get(),
            'pc_categories' => DocumentCategory::where('document_type_id', $pc_id)->get()
        ]);

        /*
        OLD CODE
            $records_year_start = 2021;

            $total_applicants = Applicant::count();
            $total_businesses = Business::count();

            $total_yellow_health_certificates = HealthCertificate::where('duration', HealthCertificate::CERTIFICATE_TYPES['Yellow']['string'])->count();
            $total_green_health_certificates = HealthCertificate::where('duration', HealthCertificate::CERTIFICATE_TYPES['Green']['string'])->count();

            $classifications = [];
            $colors = ['green', 'blue', 'red']; //Could've done better here like placed this in the following object's property but meh  ¯\_(ツ)_/¯

            foreach(SanitaryPermit::PERMIT_CLASSIFICATIONS as $key => $value)
            {
                $classifications[$key]['total'] = SanitaryPermit::where('permit_classification', $value)->count();
                $classifications[$key]['name'] = $value;
                $classifications[$key]['color'] = $colors[$key];
            }

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

                'classifications' => $classifications,

                'total_pink_card' => $total_pink_card,

                'total_registered_hc_for_each_year' => $total_registered_hc_for_each_year,
                'total_registered_sp_for_each_year' => $total_registered_sp_for_each_year,
                'total_registered_pc_for_each_year' => $total_registered_pc_for_each_year
            ]);
        */
    }
}