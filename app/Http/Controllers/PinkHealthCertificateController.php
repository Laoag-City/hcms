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

class PinkHealthCertificateController extends Controller
{
    protected $request;

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
                'validity_period' => PinkHealthCertificate::VALIDITY_PERIOD
            ]);
        }

        elseif($this->request->isMethod('post'))
        {
            $this->create_edit_logic('add');
        }

        return response()->json([], 405);
    }

    private function create_edit_logic($mode, PinkHealthCertificate $health_certificate = null)
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
                    'date_of_issuance' => "bail|required|date|before_or_equal:today|after:{$health_certificate->dateToInput('issuance_date')}"
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
            /*$old_health_certificate = $health_certificate->replicate();

            $old_health_certificate->health_certificate_id = $health_certificate->health_certificate_id;
            $old_health_certificate->created_at = $health_certificate->created_at;*/
        }
        
        //define validation rules here
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
                $applicant->save();
            }

            $health_certificate = new PinkHealthCertificate;
            $health_certificate->applicant_id = $applicant->applicant_id;
            $health_certificate->registration_number = (new RegistrationNumberGenerator)->getRegistrationNumber('App\PinkHealthCertificate', 'registration_number');
            $health_certificate->validity_period = 
            $health_certificate->occupation = $this->request->occupation;
            $health_certificate->place_of_work = $this->request->place_of_work;
            $health_certificate->issuance_date = $this->request->date_of_issuance;
            $health_certificate->expiration_date = $this->request->date_of_expiration;
            $health_certificate->community_tax_no = $this->request->community_tax_no;
            $health_certificate->community_tax_issued_at = $this->request->community_tax_issued_at;
            $health_certificate->community_tax_issued_on = $this->request->community_tax_issued_on;
            $health_certificate->is_expired = false;
            $health_certificate->save();

            $immunization1 = new Immunization;
            $immunization2 = new Immunization;
            $x_ray_sputum_exam1 = new XRaySputum;
            $x_ray_sputum_exam2 = new XRaySputum;
            $stool_and_others1 = new StoolAndOther;
            $stool_and_others2 = new StoolAndOther;
        }

        else
        {
            $applicant = $health_certificate->applicant;
            $applicant->age = $this->request->age;
            $applicant->save();
            
            $health_certificate->duration = $this->request->certificate_type;
            $health_certificate->issuance_date = $this->request->date_of_issuance;
            $health_certificate->expiration_date = $this->request->date_of_expiration;//$this->getExpirationDate($this->request->date_of_issuance, $this->request->certificate_type);
            $health_certificate->work_type = $this->request->type_of_work;
            $health_certificate->establishment = $this->request->name_of_establishment;

            //if renewing and it's already next year, update registration number
            if($mode == 'renew')
            {   
                if((int)explode('-', $health_certificate->registration_number)[0] < (int)date('Y', strtotime('now')))
                    $health_certificate->registration_number = (new RegistrationNumberGenerator)->getRegistrationNumber('App\HealthCertificate', 'registration_number');
            }

            $health_certificate->save();

            $health_certificate->checkIfExpired();
            
            $immunizations = Immunization::where('health_certificate_id', '=', $health_certificate->health_certificate_id)->get();
            $immunization1 = $this->findByRowNumber($immunizations, 1, 'App\Immunization');
            $immunization2 = $this->findByRowNumber($immunizations, 2, 'App\Immunization');

            $x_ray_sputum_exams = XRaySputum::where('health_certificate_id', '=', $health_certificate->health_certificate_id)->get();
            $x_ray_sputum_exam1 = $this->findByRowNumber($x_ray_sputum_exams, 1, 'App\XRaySputum');
            $x_ray_sputum_exam2 = $this->findByRowNumber($x_ray_sputum_exams, 2, 'App\XRaySputum');

            $stool_and_others = StoolAndOther::where('health_certificate_id', '=', $health_certificate->health_certificate_id)->get();
            $stool_and_others1 = $this->findByRowNumber($stool_and_others, 1, 'App\StoolAndOther');
            $stool_and_others2 = $this->findByRowNumber($stool_and_others, 2, 'App\StoolAndOther');
        }

        //solve: what if an immunization is only at row 2 or row 1? applies to xray and sputum and stools and others
        //save to database for the 3 tables linked to health certificate
        if($this->request->immunization_date_1 != null && $this->request->immunization_kind_1 != null && $this->request->immunization_date_of_expiration_1 != null)
        {
            $immunization1->health_certificate_id = $health_certificate->health_certificate_id;
            $immunization1->date = $this->request->immunization_date_1;
            $immunization1->kind = $this->request->immunization_kind_1;
            $immunization1->expiration_date = $this->request->immunization_date_of_expiration_1;
            $immunization1->row_number = 1;
            $immunization1->save();
        }

        elseif($this->request->immunization_date_1 == null && $this->request->immunization_kind_1 == null && $this->request->immunization_date_of_expiration_1 == null && ($mode == 'edit' || $mode == 'renew') && $immunization1 != null)
            $immunization1->delete();

        if($this->request->immunization_date_2 != null && $this->request->immunization_kind_2 != null && $this->request->immunization_date_of_expiration_2 != null)
        {
            $immunization2->health_certificate_id = $health_certificate->health_certificate_id;
            $immunization2->date = $this->request->immunization_date_2;
            $immunization2->kind = $this->request->immunization_kind_2;
            $immunization2->expiration_date = $this->request->immunization_date_of_expiration_2;
            $immunization2->row_number = 2;
            $immunization2->save();
        }

        elseif($this->request->immunization_date_2 == null && $this->request->immunization_kind_2 == null && $this->request->immunization_date_of_expiration_2 == null && ($mode == 'edit' || $mode == 'renew') && $immunization2 != null)
            $immunization2->delete();

        if($this->request->input('x-ray_sputum_exam_date_1') != null && $this->request->input('x-ray_sputum_exam_kind_1') != null && $this->request->input('x-ray_sputum_exam_result_1') != null)
        {
            $x_ray_sputum_exam1->health_certificate_id = $health_certificate->health_certificate_id;
            $x_ray_sputum_exam1->date = $this->request->input('x-ray_sputum_exam_date_1');
            $x_ray_sputum_exam1->kind = $this->request->input('x-ray_sputum_exam_kind_1');
            $x_ray_sputum_exam1->result = $this->request->input('x-ray_sputum_exam_result_1');
            $x_ray_sputum_exam1->row_number = 1;
            $x_ray_sputum_exam1->save();
        }

        elseif($this->request->input('x-ray_sputum_exam_date_1') == null && $this->request->input('x-ray_sputum_exam_kind_1') == null && $this->request->input('x-ray_sputum_exam_result_1') == null 
                && ($mode == 'edit' || $mode == 'renew') && $x_ray_sputum_exam1 != null)
                $x_ray_sputum_exam1->delete();

        if($this->request->input('x-ray_sputum_exam_date_2') != null && $this->request->input('x-ray_sputum_exam_kind_2') != null && $this->request->input('x-ray_sputum_exam_result_2') != null)
        {
            $x_ray_sputum_exam2->health_certificate_id = $health_certificate->health_certificate_id;
            $x_ray_sputum_exam2->date = $this->request->input('x-ray_sputum_exam_date_2');
            $x_ray_sputum_exam2->kind = $this->request->input('x-ray_sputum_exam_kind_2');
            $x_ray_sputum_exam2->result = $this->request->input('x-ray_sputum_exam_result_2');
            $x_ray_sputum_exam2->row_number = 2;
            $x_ray_sputum_exam2->save();
        }

        elseif($this->request->input('x-ray_sputum_exam_date_2') == null && $this->request->input('x-ray_sputum_exam_kind_2') == null && $this->request->input('x-ray_sputum_exam_result_2') == null 
                && ($mode == 'edit' || $mode == 'renew') && $x_ray_sputum_exam2 != null)
                $x_ray_sputum_exam2->delete();

        if($this->request->stool_and_other_exam_date_1 != null && $this->request->stool_and_other_exam_kind_1 != null && $this->request->stool_and_other_exam_result_1 != null)
        {
            $stool_and_others1->health_certificate_id = $health_certificate->health_certificate_id;
            $stool_and_others1->date = $this->request->stool_and_other_exam_date_1;
            $stool_and_others1->kind = $this->request->stool_and_other_exam_kind_1;
            $stool_and_others1->result = $this->request->stool_and_other_exam_result_1;
            $stool_and_others1->row_number = 1;
            $stool_and_others1->save();
        }

        elseif($this->request->stool_and_other_exam_date_1 == null && $this->request->stool_and_other_exam_kind_1 == null && $this->request->stool_and_other_exam_result_1 == null 
            && ($mode == 'edit' || $mode == 'renew') && $stool_and_others1 != null)
            $stool_and_others1->delete();

        if($this->request->stool_and_other_exam_date_2 != null && $this->request->stool_and_other_exam_kind_2 != null && $this->request->stool_and_other_exam_result_2 != null)
        {
            $stool_and_others2->health_certificate_id = $health_certificate->health_certificate_id;
            $stool_and_others2->date = $this->request->stool_and_other_exam_date_2;
            $stool_and_others2->kind = $this->request->stool_and_other_exam_kind_2;
            $stool_and_others2->result = $this->request->stool_and_other_exam_result_2;
            $stool_and_others2->row_number = 2;
            $stool_and_others2->save();
        }

        elseif($this->request->stool_and_other_exam_date_2 == null && $this->request->stool_and_other_exam_kind_2 == null && $this->request->stool_and_other_exam_result_2 == null 
            && ($mode == 'edit' || $mode == 'renew') && $stool_and_others2 != null)
            $stool_and_others2->delete();

        //logic for saving pdf files of certificates
        if($mode != 'edit')
        {
            //(new CertificateFileGenerator($health_certificate))->generatePDF();
            return $health_certificate->health_certificate_id;
        }

        //else
            //(new CertificateFileGenerator($health_certificate))->updatePDF(/*$old_health_certificate*/);
    }
}
