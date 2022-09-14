<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Applicant;
use App\PinkHealthCertificate;
use App\Immunization;
use App\XRaySputum;
use App\StoolAndOther;
use App\HivExamination;
use App\HbsagExamination;
use App\VdrlExamination;
use App\CervicalSmearExamination;
use Illuminate\Validation\Rule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

/*
This controller share many similiarites with HealthCertificateController.
Some codes from the HealthCertificateController that are applicable here are further improved and optimized.
Those codes are used as the building blocks for the pink card.
The improvements and optimizations made here that are applicable for the health certificate are not done due to time constraints.
*/
class PinkHealthCertificateController extends Controller
{
    protected $request;
    protected $immunization_rows = 3;
    protected $xray_sputum_rows = 3;
    protected $stool_and_other_rows = 3;
    protected $hiv_rows = 3;
    protected $hbsag_rows = 3;
    protected $vdrl_rows = 3;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function addPinkHealthCertificate()
    {
        if($this->request->isMethod('get'))
        {
            return view('pink_health_certificate.add', [
                'title' => 'Add Pink Health Certificate',
                'validity_period' => PinkHealthCertificate::VALIDITY_PERIOD['months'],
                'cervical_smear_max_rows' => PinkHealthCertificate::MAX_ROWS,
                'immunization_rows' => $this->immunization_rows,
                'xray_sputum_rows' => $this->xray_sputum_rows,
                'stool_and_other_rows' => $this->stool_and_other_rows,
                'hiv_rows' => $this->hiv_rows,
                'hbsag_rows' => $this->hbsag_rows,
                'vdrl_rows' => $this->vdrl_rows,
            ]);
        }

        elseif($this->request->isMethod('post'))
        {
            $this->create_edit_logic('add');
        }

        return response()->json([], 405);
    }

    private function create_edit_logic($mode, PinkHealthCertificate $pink_health_certificate = null)
    {
        //set rules depending on $mode
        if($mode == 'add')
        {
            $request = $this->request;

            $create_or_edit_rules = [
                'existing_client' => 'sometimes|in:on',
                'whole_name' => 'bail|sometimes|required_if:existing_client,on|max:107',

                'first_name' => 'bail|required|alpha_spaces|max:40',
                'middle_name' => 'nullable|bail|alpha_spaces|max:30',
                'last_name' => 'bail|required|alpha_spaces|max:30',
                'suffix_name' => 'nullable|bail|in:Jr.,Sr.,I,II,III,IV,V,VI,VII,VIII,IX,X',
                'age' => 'bail|required|integer|min:15|max:100',
                'gender' => 'bail|required|in:0,1',
                'nationality'=> 'bail|required|alpha_spaces|max:20',

                'date_of_issuance' => 'bail|required|date|before_or_equal:today',

                'id' => [
                        'bail',
                        'nullable',
                        'required_if:existing_client,on',
                        Rule::exists('applicants', 'applicant_id')->where(function ($query) use($request) {
                            $query->where('first_name', $request->first_name)
                                    ->where('middle_name', $request->middle_name)
                                    ->where('last_name', $request->last_name)
                                    ->where('suffix_name', $request->suffix_name)
                                    ->where('gender', $request->gender);
                        })
                    ]
            ];
        }

        else
        {
            /*
            if renew
                issuance date must be a date after last issuance and before or equal now

            if not renew
                issuance date must be a date before or equal now
                proceed regardless if the expiration date computed based on type and issuance is already expired
            */
            if($mode == 'renew')
            {
                $specific_rules = [
                    'date_of_issuance' => "bail|required|date|before_or_equal:today|after:{$pink_health_certificate->dateToInput('issuance_date')}"
                ];
            }

            else
            {
                $specific_rules = [
                    'date_of_issuance' => 'bail|required|date|before_or_equal:today',
                    'update_mode' => 'bail|required|accepted',
                ];
            }

            $create_or_edit_rules = array_merge($specific_rules, [
                'age' => 'bail|required|integer|min:15|max:100'

            ]);
            /*$old_health_certificate = $pink_health_certificate->replicate();

            $old_health_certificate->health_certificate_id = $pink_health_certificate->health_certificate_id;
            $old_health_certificate->created_at = $pink_health_certificate->created_at;*/
        }
        
        /*
        Rules below for form fields inside a table are still statically defined, while they are dynamically generated in the front-end by a loop.
        The dynamic generation of these form fields in the front-end are for simplicity's sake. It is not likely that the pink card will have changes for how many rows it have for its form fields inside a table.
        With those in consideration, it is still more feasible to declare these form fields' rules statically rather than dynamically.
        */
        $validator = Validator::make($this->request->all(), array_merge($create_or_edit_rules, [
            'occupation' => 'bail|required|alpha_spaces|max:40',
            'place_of_work' => 'bail|required|max:50',
            'date_of_expiration' => 'bail|required|date|after:date_of_issuance',

            'immunization_date_1' => 'nullable|bail|required_with:immunization_kind_1,immunization_date_of_expiration_1|date|before_or_equal:today',

            'immunization_kind_1' => 'nullable|bail|required_with:immunization_date_1,immunization_date_of_expiration_1|max:20',

            'immunization_date_of_expiration_1' => 'nullable|bail|required_with:immunization_date_1,immunization_kind_1|date|after:immunization_date_1',
            ///////////////////////////////

            'immunization_date_2' => 'nullable|bail|required_with:immunization_kind_2,immunization_date_of_expiration_2|date|before_or_equal:today',

            'immunization_kind_2' => 'nullable|bail|required_with:immunization_date_2,immunization_date_of_expiration_2|max:20',

            'immunization_date_of_expiration_2' => 'nullable|bail|required_with:immunization_date_2,immunization_kind_2|date|after:immunization_date_2',
            //////////////////////////////

            'immunization_date_3' => 'nullable|bail|required_with:immunization_kind_3,immunization_date_of_expiration_3|date|before_or_equal:today',

            'immunization_kind_3' => 'nullable|bail|required_with:immunization_date_3,immunization_date_of_expiration_3|max:20',

            'immunization_date_of_expiration_3' => 'nullable|bail|required_with:immunization_date_3,immunization_kind_3|date|after:immunization_date_3',
            /////////////////////////////

            'x-ray_sputum_exam_date_1' => 'nullable|bail|required_with:x-ray_sputum_exam_kind_1,x-ray_sputum_exam_result_1|date|before_or_equal:today',

            'x-ray_sputum_exam_kind_1' => 'nullable|bail|required_with:x-ray_sputum_exam_date_1,x-ray_sputum_exam_result_1|max:20',

            'x-ray_sputum_exam_result_1' => 'nullable|bail|required_with:x-ray_sputum_exam_date_1,x-ray_sputum_exam_kind_1|max:20',
            /////////////////////////////

            'x-ray_sputum_exam_date_2' => 'nullable|bail|required_with:x-ray_sputum_exam_kind_2,x-ray_sputum_exam_result_2|date|before_or_equal:today',

            'x-ray_sputum_exam_kind_2' => 'nullable|bail|required_with:x-ray_sputum_exam_date_2,x-ray_sputum_exam_result_2|max:20',

            'x-ray_sputum_exam_result_2' => 'nullable|bail|required_with:x-ray_sputum_exam_date_2,x-ray_sputum_exam_kind_2|max:20',
            /////////////////////////////

            'x-ray_sputum_exam_date_3' => 'nullable|bail|required_with:x-ray_sputum_exam_kind_3,x-ray_sputum_exam_result_3|date|before_or_equal:today',

            'x-ray_sputum_exam_kind_3' => 'nullable|bail|required_with:x-ray_sputum_exam_date_3,x-ray_sputum_exam_result_3|max:20',

            'x-ray_sputum_exam_result_3' => 'nullable|bail|required_with:x-ray_sputum_exam_date_3,x-ray_sputum_exam_kind_3|max:20',
            /////////////////////////////

            'stool_and_other_exam_date_1' => 'nullable|bail|required_with:stool_and_other_exam_kind_1,stool_and_other_exam_result_1|date|before_or_equal:today',

            'stool_and_other_exam_kind_1' => 'nullable|bail|required_with:stool_and_other_exam_date_1,stool_and_other_exam_result_1|max:20',

            'stool_and_other_exam_result_1' => 'nullable|bail|required_with:stool_and_other_exam_date_1,stool_and_other_exam_kind_1|max:20',
            ////////////////////////////

            'stool_and_other_exam_date_2' => 'nullable|bail|required_with:stool_and_other_exam_kind_2,stool_and_other_exam_result_2|date|before_or_equal:today',

            'stool_and_other_exam_kind_2' => 'nullable|bail|required_with:stool_and_other_exam_date_2,stool_and_other_exam_result_2|max:20',

            'stool_and_other_exam_result_2' => 'nullable|bail|required_with:stool_and_other_exam_date_2,stool_and_other_exam_kind_2|max:20',
            ////////////////////////////

            'stool_and_other_exam_date_3' => 'nullable|bail|required_with:stool_and_other_exam_kind_3,stool_and_other_exam_result_3|date|before_or_equal:today',

            'stool_and_other_exam_kind_3' => 'nullable|bail|required_with:stool_and_other_exam_date_3,stool_and_other_exam_result_3|max:20',

            'stool_and_other_exam_result_3' => 'nullable|bail|required_with:stool_and_other_exam_date_3,stool_and_other_exam_kind_3|max:20',
            ///////////////////////////

            'hiv_date_1' => 'nullable|bail|required_with:hiv_kind_1,hiv_date_of_next_exam_1|date|before_or_equal:today',

            'hiv_kind_1' => 'nullable|bail|required_with:hiv_date_1,hiv_date_of_next_exam_1|max:20',

            'hiv_date_of_next_exam_1' => 'nullable|bail|required_with:hiv_date_1,hiv_kind_1|date|after:hiv_date_1',
            ///////////////////////////

            'hiv_date_2' => 'nullable|bail|required_with:hiv_kind_2,hiv_date_of_next_exam_2|date|before_or_equal:today',

            'hiv_kind_2' => 'nullable|bail|required_with:hiv_date_2,hiv_date_of_next_exam_2|max:20',

            'hiv_date_of_next_exam_2' => 'nullable|bail|required_with:hiv_date_2,hiv_kind_2|date|after:hiv_date_2',
            ///////////////////////////

            'hiv_date_3' => 'nullable|bail|required_with:hiv_kind_3,hiv_date_of_next_exam_3|date|before_or_equal:today',

            'hiv_kind_3' => 'nullable|bail|required_with:hiv_date_3,hiv_date_of_next_exam_3|max:20',

            'hiv_date_of_next_exam_3' => 'nullable|bail|required_with:hiv_date_3,hiv_kind_3|date|after:hiv_date_3',
            ///////////////////////////

            'hbsag_date_1' => 'nullable|bail|required_with:hbsag_kind_1,hbsag_date_of_next_exam_1|date|before_or_equal:today',

            'hbsag_kind_1' => 'nullable|bail|required_with:hbsag_date_1,hbsag_date_of_next_exam_1|max:20',

            'hbsag_date_of_next_exam_1' => 'nullable|bail|required_with:hbsag_date_1,hbsag_kind_1|date|after:hbsag_date_1',
            ///////////////////////////

            'hbsag_date_2' => 'nullable|bail|required_with:hbsag_kind_2,hbsag_date_of_next_exam_2|date|before_or_equal:today',

            'hbsag_kind_2' => 'nullable|bail|required_with:hbsag_date_2,hbsag_date_of_next_exam_2|max:20',

            'hbsag_date_of_next_exam_2' => 'nullable|bail|required_with:hbsag_date_2,hbsag_kind_2|date|after:hbsag_date_2',
            ///////////////////////////

            'hbsag_date_3' => 'nullable|bail|required_with:hbsag_kind_3,hbsag_date_of_next_exam_3|date|before_or_equal:today',

            'hbsag_kind_3' => 'nullable|bail|required_with:hbsag_date_3,hbsag_date_of_next_exam_3|max:20',

            'hbsag_date_of_next_exam_3' => 'nullable|bail|required_with:hbsag_date_3,hbsag_kind_3|date|after:hbsag_date_3',
            ///////////////////////////

            'vdrl_date_1' => 'nullable|bail|required_with:vdrl_kind_1,vdrl_date_of_next_exam_1|date|before_or_equal:today',

            'vdrl_kind_1' => 'nullable|bail|required_with:vdrl_date_1,vdrl_date_of_next_exam_1|max:20',

            'vdrl_date_of_next_exam_1' => 'nullable|bail|required_with:vdrl_date_1,vdrl_kind_1|date|after:vdrl_date_1',
            ///////////////////////////

            'vdrl_date_2' => 'nullable|bail|required_with:vdrl_kind_2,vdrl_date_of_next_exam_2|date|before_or_equal:today',

            'vdrl_kind_2' => 'nullable|bail|required_with:vdrl_date_2,vdrl_date_of_next_exam_2|max:20',

            'vdrl_date_of_next_exam_2' => 'nullable|bail|required_with:vdrl_date_2,vdrl_kind_2|date|after:vdrl_date_2',
            ///////////////////////////

            'vdrl_date_3' => 'nullable|bail|required_with:vdrl_kind_3,vdrl_date_of_next_exam_3|date|before_or_equal:today',

            'vdrl_kind_3' => 'nullable|bail|required_with:vdrl_date_3,vdrl_date_of_next_exam_3|max:20',

            'vdrl_date_of_next_exam_3' => 'nullable|bail|required_with:vdrl_date_3,vdrl_kind_3|date|after:vdrl_date_3',
            //////////////////////////

            'cervical_smear.*.date' => 'nullable|bail|required_with:cervical_smear.*.initial,cervical_smear.*.date_of_next_exam|date|before_or_equal:today',

            'cervical_smear.*.initial' => 'nullable|bail|required_with:cervical_smear.*.date,cervical_smear.*.date_of_next_exam|max:20',

            'cervical_smear.*.date_of_next_exam' => 'nullable|bail|required_with:cervical_smear.*.date,cervical_smear.*.initial|date|after:cervical_smear.*.date'
        ]));

        //run the validation process. If there are errors, it will automatically redirect back
        $validator->validate();

        //save to database
        if($mode == 'add')
        {
            if($this->request->id == null)
            {
                $applicant = new Applicant;
                $applicant->first_name = $this->request->first_name;
                $applicant->middle_name = $this->request->middle_name == null ? null : $this->request->middle_name;
                $applicant->last_name = $this->request->last_name;
                $applicant->suffix_name = $this->request->suffix_name == null ? null : $this->request->suffix_name;
                $applicant->age = $this->request->age;
                $applicant->gender = $this->request->gender;
                $applicant->nationality = $this->request->nationality;
                $applicant->save();
            }

            else
            {
                $applicant = Applicant::find($this->request->id);
                $applicant->age = $this->request->age;
                $applicant->nationality = $this->request->nationality;
                $applicant->save();
            }

            $pink_health_certificate = new PinkHealthCertificate;
            $pink_health_certificate->applicant_id = $applicant->applicant_id;
            $pink_health_certificate->registration_number = (new RegistrationNumberGenerator)->getRegistrationNumber('App\PinkHealthCertificate', 'registration_number');
            $pink_health_certificate->validity_period = PinkHealthCertificate::VALIDITY_PERIOD['string'];    //added this row if ever pink card will have differing validity period in the future
            $pink_health_certificate->occupation = $this->request->occupation;
            $pink_health_certificate->place_of_work = $this->request->place_of_work;
            $pink_health_certificate->issuance_date = $this->request->date_of_issuance;
            $pink_health_certificate->expiration_date = $this->request->date_of_expiration;
            $pink_health_certificate->community_tax_no = $this->request->community_tax_no;
            $pink_health_certificate->community_tax_issued_at = $this->request->community_tax_issued_at;
            $pink_health_certificate->community_tax_issued_on = $this->request->community_tax_issued_on;
            $pink_health_certificate->is_expired = false;
            $pink_health_certificate->save();

            for($i = 0; $i < $this->immunization_rows; $i++)
                $immunizations[$i] = new Immunization;

            for($i = 0; $i < $this->xray_sputum_rows; $i++)
                $xray_sputums[$i] = new XRaySputum;

            for($i = 0; $i < $this->stool_and_other_rows; $i++)
                $stool_and_others[$i] = new StoolAndOther;

            for($i = 0; $i < $this->hiv_rows; $i++)
                $hivs[$i] = new HivExamination;

            for($i = 0; $i < $this->hbsag_rows; $i++)
                $hbsags[$i] = new HbsagExamination;

            for($i = 0; $i < $this->vdrl_rows; $i++)
                $vdrls[$i] = new VdrlExamination;
        }

        else
        {
            $applicant = $pink_health_certificate->applicant;
            $applicant->age = $this->request->age;
            $applicant->save();
            
            $pink_health_certificate->duration = $this->request->certificate_type;
            $pink_health_certificate->issuance_date = $this->request->date_of_issuance;
            $pink_health_certificate->expiration_date = $this->request->date_of_expiration;//$this->getExpirationDate($this->request->date_of_issuance, $this->request->certificate_type);
            $pink_health_certificate->work_type = $this->request->type_of_work;
            $pink_health_certificate->establishment = $this->request->name_of_establishment;

            //if renewing and it's already next year, update registration number
            if($mode == 'renew')
            {   
                if((int)explode('-', $pink_health_certificate->registration_number)[0] < (int)date('Y', strtotime('now')))
                    $pink_health_certificate->registration_number = (new RegistrationNumberGenerator)->getRegistrationNumber('App\HealthCertificate', 'registration_number');
            }

            $pink_health_certificate->save();

            $pink_health_certificate->checkIfExpired();
            
            $immunizations = Immunization::where('health_certificate_id', '=', $pink_health_certificate->health_certificate_id)->get();
            $immunization1 = $this->findByRowNumber($immunizations, 1, 'App\Immunization');
            $immunization2 = $this->findByRowNumber($immunizations, 2, 'App\Immunization');

            $x_ray_sputum_exams = XRaySputum::where('health_certificate_id', '=', $pink_health_certificate->health_certificate_id)->get();
            $x_ray_sputum_exam1 = $this->findByRowNumber($x_ray_sputum_exams, 1, 'App\XRaySputum');
            $x_ray_sputum_exam2 = $this->findByRowNumber($x_ray_sputum_exams, 2, 'App\XRaySputum');

            $stool_and_others = StoolAndOther::where('health_certificate_id', '=', $pink_health_certificate->health_certificate_id)->get();
            $stool_and_others1 = $this->findByRowNumber($stool_and_others, 1, 'App\StoolAndOther');
            $stool_and_others2 = $this->findByRowNumber($stool_and_others, 2, 'App\StoolAndOther');
        }

        //Database operations below for form fields in tables. If statement for adding/editing record, elseif statement for deleting record when in edit/renew mode and the user deletes a record.

        //loop variable for every foreach loop below
        $i = 1;

        foreach($immunizations as $immunization)
        {
            if($this->request->{"immunization_date_$i"} != null && $this->request->{"immunization_kind_$i"} != null && $this->request->{"immunization_date_of_expiration_$i"} != null)
            {
                $immunization->pink_health_certificate_id = $pink_health_certificate->pink_health_certificate_id;
                $immunization->date = $this->request->{"immunization_date_$i"};
                $immunization->kind = $this->request->{"immunization_kind_$i"};
                $immunization->expiration_date = $this->request->{"immunization_date_of_expiration_$i"};
                $immunization->row_number = $i;
                $immunization->save();
            }

            elseif($this->request->{"immunization_date_$i"} == null && $this->request->{"immunization_kind_$i"} == null && $this->request->{"immunization_date_of_expiration_$i"} == null && ($mode == 'edit' || $mode == 'renew') && $immunization != null)
                $immunization->delete();

            $i++;
        }

        $i = 1;

        foreach($xray_sputums as $xray_sputum)
        {
            if($this->request->input("x-ray_sputum_exam_date_$i") != null && $this->request->input("x-ray_sputum_exam_kind_$i") != null && $this->request->input("x-ray_sputum_exam_result_$i") != null)
            {
                $xray_sputum->pink_health_certificate_id = $pink_health_certificate->pink_health_certificate_id;
                $xray_sputum->date = $this->request->input("x-ray_sputum_exam_date_$i");
                $xray_sputum->kind = $this->request->input("x-ray_sputum_exam_kind_$i");
                $xray_sputum->result = $this->request->input("x-ray_sputum_exam_result_$i");
                $xray_sputum->row_number = $i;
                $xray_sputum->save();
            }

            elseif($this->request->input("x-ray_sputum_exam_date_$i") == null && $this->request->input("x-ray_sputum_exam_kind_$i") == null && $this->request->input("x-ray_sputum_exam_result_$i") == null 
                    && ($mode == 'edit' || $mode == 'renew') && $xray_sputum != null)
                    $xray_sputum->delete();

            $i++;
        }

        $i = 1;

        foreach($stool_and_others as $stool_and_other)
        {
            if($this->request->{"stool_and_other_exam_date_$i"} != null && $this->request->{"stool_and_other_exam_kind_$i"} != null && $this->request->{"stool_and_other_exam_result_$i"} != null)
            {
                $stool_and_other->pink_health_certificate_id = $pink_health_certificate->pink_health_certificate_id;
                $stool_and_other->date = $this->request->{"stool_and_other_exam_date_$i"};
                $stool_and_other->kind = $this->request->{"stool_and_other_exam_kind_$i"};
                $stool_and_other->result = $this->request->{"stool_and_other_exam_result_$i"};
                $stool_and_other->row_number = $i;
                $stool_and_other->save();
            }

            elseif($this->request->{"stool_and_other_exam_date_$i"} == null && $this->request->{"stool_and_other_exam_kind_$i"} == null && $this->request->{"stool_and_other_exam_result_$i"} == null 
                && ($mode == 'edit' || $mode == 'renew') && $stool_and_other != null)
                $stool_and_other->delete();

            $i++;
        }

        $i = 1;

        foreach($hivs as $hiv)
        {
            if($this->request->{"hiv_date_$i"} != null && $this->request->{"hiv_kind_$i"} != null && $this->request->{"hiv_date_of_next_exam_$i"} != null)
            {
                $hiv->pink_health_certificate_id = $pink_health_certificate->pink_health_certificate_id;
                $hiv->date_of_exam = $this->request->{"hiv_date_$i"};
                $hiv->result = $this->request->{"hiv_kind_$i"};
                $hiv->date_of_next_exam = $this->request->{"hiv_date_of_next_exam_$i"};
                $hiv->row_number = $i;
                $hiv->save();
            }

            elseif($this->request->{"hiv_date_$i"} == null && $this->request->{"hiv_kind_$i"} == null && $this->request->{"hiv_date_of_next_exam_$i"} == null 
                && ($mode == 'edit' || $mode == 'renew') && $hiv != null)
                $hiv->delete();

            $i++;
        }

        $i = 1;

        foreach($hbsags as $hbsag)
        {
            if($this->request->{"hbsag_date_$i"} != null && $this->request->{"hbsag_kind_$i"} != null && $this->request->{"hbsag_date_of_next_exam_$i"} != null)
            {
                $hbsag->pink_health_certificate_id = $pink_health_certificate->pink_health_certificate_id;
                $hbsag->date_of_exam = $this->request->{"hbsag_date_$i"};
                $hbsag->result = $this->request->{"hbsag_kind_$i"};
                $hbsag->date_of_next_exam = $this->request->{"hbsag_date_of_next_exam_$i"};
                $hbsag->row_number = $i;
                $hbsag->save();
            }

            elseif($this->request->{"hbsag_date_$i"} == null && $this->request->{"hbsag_kind_$i"} == null && $this->request->{"hbsag_date_of_next_exam_$i"} == null 
                && ($mode == 'edit' || $mode == 'renew') && $hbsag != null)
                $hbsag->delete();

            $i++;
        }//last edit here

        ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        //logic for saving pdf files of certificates
        if($mode != 'edit')
        {
            //(new CertificateFileGenerator($pink_health_certificate))->generatePDF();
            return $pink_health_certificate->health_certificate_id;
        }

        //else
            //(new CertificateFileGenerator($pink_health_certificate))->updatePDF(/*$old_health_certificate*/);
    }
}
