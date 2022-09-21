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
use App\Custom\RegistrationNumberGenerator;
use App\Custom\CertificateTableRowFinder;
use App\Custom\PinkCardFileGenerator;

/*
This controller share many similiarites with HealthCertificateController.
Some codes from the HealthCertificateController that are applicable here are further improved and optimized.
Those codes are used as the building blocks for the pink card.
Most improvements and optimizations made here that are applicable for the health certificate are not done due to time constraints.
*/
class PinkHealthCertificateController extends Controller
{
    use CertificateTableRowFinder;
    
    protected $request;
    protected $immunization_rows = 3;
    protected $xray_sputum_rows = 3;
    protected $stool_and_other_rows = 3;
    protected $hiv_rows = 3;
    protected $hbsag_rows = 3;
    protected $vdrl_rows = 3;
    protected $cervical_smear_rows = 69;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function addPinkHealthCertificate()
    {
        if($this->request->isMethod('get'))
        {
            return view('pink_health_certificate.add', [
                'title' => 'Add Pink Card',
                'validity_period' => PinkHealthCertificate::VALIDITY_PERIOD['months'],
                'immunization_rows' => $this->immunization_rows,
                'xray_sputum_rows' => $this->xray_sputum_rows,
                'stool_and_other_rows' => $this->stool_and_other_rows,
                'hiv_rows' => $this->hiv_rows,
                'hbsag_rows' => $this->hbsag_rows,
                'vdrl_rows' => $this->vdrl_rows,
                'cervical_smear_max_rows' => $this->cervical_smear_rows,
            ]);
        }

        elseif($this->request->isMethod('post'))
        {
            $id = $this->create_edit_logic('add');

            return redirect("pink_card/$id/preview");
        }

        return response()->json([], 405);
    }

    public function viewEditPinkHealthCertificate(PinkHealthCertificate $pink_health_certificate)
    {
        if($this->request->isMethod('get'))
        {
            $immunizations = $this->tabledFieldsLooper(false, 'App\Immunization', $this->immunization_rows, $pink_health_certificate->immunizations->sortBy('row_number'));

            $xray_sputums = $this->tabledFieldsLooper(false, 'App\XRaySputum', $this->xray_sputum_rows, $pink_health_certificate->xray_sputums->sortBy('row_number'));

            $stool_and_others = $this->tabledFieldsLooper(false, 'App\StoolAndOther', $this->stool_and_other_rows, $pink_health_certificate->stool_and_others->sortBy('row_number'));

            $hivs = $this->tabledFieldsLooper(false, 'App\HivExamination', $this->hiv_rows, $pink_health_certificate->hiv_examinations->sortBy('row_number'));

            $hbsags = $this->tabledFieldsLooper(false, 'App\HbsagExamination', $this->hbsag_rows, $pink_health_certificate->hbsag_examinations->sortBy('row_number'));

            $vdrls = $this->tabledFieldsLooper(false, 'App\VdrlExamination', $this->vdrl_rows, $pink_health_certificate->vdrl_examinations->sortBy('row_number'));

            $cervical_smears = $this->tabledFieldsLooper(false, 'App\CervicalSmearExamination', $this->cervical_smear_rows, $pink_health_certificate->cervical_smear_examinations->sortBy('row_number'));

            return view('pink_health_certificate.view_edit', [
                'title' => "Pink Card Information",

                'applicant' => $pink_health_certificate->applicant,
                'pink_health_certificate' => $pink_health_certificate,
                'immunizations' => $immunizations,
                'xray_sputums' => $xray_sputums,
                'stool_and_others' => $stool_and_others,
                'hivs' => $hivs,
                'hbsags' => $hbsags,
                'vdrls' => $vdrls,
                'cervical_smears' => $cervical_smears,

                'picture_url' => (new PinkCardFileGenerator($pink_health_certificate))->getPicturePathAndURL()['url'],
                'validity_period' => PinkHealthCertificate::VALIDITY_PERIOD['months']
            ]);
        }

        elseif($this->request->isMethod('put'))
        {
            $this->create_edit_logic('edit', $pink_health_certificate);

            return redirect("pink_card/{$pink_health_certificate->pink_health_certificate_id}/preview");
        }
    }

    public function renewPinkHealthCertificate()
    {
        $searches = null;
        $pink_health_certificate = null;
        $immunizations = null;
        $xray_sputums = null;
        $stool_and_others = null;
        $hivs = null;
        $hbsags = null;
        $vdrls = null;
        $cervical_smears = null;

        if($this->request->search)
        {
            $searches = Applicant::search($this->request->search)
                                    ->with('pink_health_certificates')
                                    ->get();

            //if id is present in the request and in the searches
            if($this->request->id && $searches->pluck('pink_health_certificates')->flatten()->where('pink_health_certificate_id', $this->request->id)->isNotEmpty())
            {
                Validator::make($this->request->all(), [
                    'id' => 'bail|required|exists:pink_health_certificates,pink_health_certificate_id'
                ])->validate();

                $pink_health_certificate = PinkHealthCertificate::with(['immunizations',
                                                                        'xray_sputums',
                                                                        'stool_and_others',
                                                                        'hiv_examinations',
                                                                        'hbsag_examinations',
                                                                        'vdrl_examinations',
                                                                        'cervical_smear_examinations'
                                                                    ])->find($this->request->id);

                $immunizations = $this->tabledFieldsLooper(false, 'App\Immunization', $this->immunization_rows, $pink_health_certificate->immunizations->sortBy('row_number'));

                $xray_sputums = $this->tabledFieldsLooper(false, 'App\XRaySputum', $this->xray_sputum_rows, $pink_health_certificate->xray_sputums->sortBy('row_number'));

                $stool_and_others = $this->tabledFieldsLooper(false, 'App\StoolAndOther', $this->stool_and_other_rows, $pink_health_certificate->stool_and_others->sortBy('row_number'));

                $hivs = $this->tabledFieldsLooper(false, 'App\HivExamination', $this->hiv_rows, $pink_health_certificate->hiv_examinations->sortBy('row_number'));

                $hbsags = $this->tabledFieldsLooper(false, 'App\HbsagExamination', $this->hbsag_rows, $pink_health_certificate->hbsag_examinations->sortBy('row_number'));

                $vdrls = $this->tabledFieldsLooper(false, 'App\VdrlExamination', $this->vdrl_rows, $pink_health_certificate->vdrl_examinations->sortBy('row_number'));

                $cervical_smears = $this->tabledFieldsLooper(false, 'App\CervicalSmearExamination', $this->cervical_smear_rows, $pink_health_certificate->cervical_smear_examinations->sortBy('row_number'));
            }
        }

        if($this->request->isMethod('get'))
        {
            return view('pink_health_certificate.renew', [
                'title' => "Renew A Pink Card",
                'searches' => $searches,
                'pink_health_certificate' => $pink_health_certificate,
                'immunizations' => $immunizations,
                'xray_sputums' => $xray_sputums,
                'stool_and_others' => $stool_and_others,
                'hivs' => $hivs,
                'hbsags' => $hbsags,
                'vdrls' => $vdrls,
                'cervical_smears' => $cervical_smears,
                'validity_period' => PinkHealthCertificate::VALIDITY_PERIOD['months']
            ]);
        }

        elseif($this->request->isMethod('put'))
        {
            $id = $this->create_edit_logic('renew', $pink_health_certificate);

            return redirect("pink_card/{$id}/preview");
        }
    }

    public function deletePinkHealthCertificate(PinkHealthCertificate $pink_health_certificate)
    {
        $validator = Validator::make($this->request->all(), [
            'password' => 'bail|required'
        ]);

        $validator->after(function ($validator){
            if(!app('hash')->check($this->request->password, $this->request->user()->password))
                $validator->errors()->add('password', 'Incorrect password.');
        });

        $validator->validate();

        $pink_health_certificate->delete();
        return redirect(explode('?', url()->previous())[0]);
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
            'community_tax_no' => 'bail|required|string|max:20',
            'community_tax_issued_at' => 'bail|required|alpha_spaces|max:30',
            'community_tax_issued_on' => 'bail|required|date|before_or_equal:today',

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

            'hiv_date_1' => 'nullable|bail|required_with:hiv_result_1,hiv_date_of_next_exam_1|date|before_or_equal:today',

            'hiv_result_1' => 'nullable|bail|required_with:hiv_date_1,hiv_date_of_next_exam_1|max:20',

            'hiv_date_of_next_exam_1' => 'nullable|bail|required_with:hiv_date_1,hiv_result_1|date|after:hiv_date_1',
            ///////////////////////////

            'hiv_date_2' => 'nullable|bail|required_with:hiv_result_2,hiv_date_of_next_exam_2|date|before_or_equal:today',

            'hiv_result_2' => 'nullable|bail|required_with:hiv_date_2,hiv_date_of_next_exam_2|max:20',

            'hiv_date_of_next_exam_2' => 'nullable|bail|required_with:hiv_date_2,hiv_result_2|date|after:hiv_date_2',
            ///////////////////////////

            'hiv_date_3' => 'nullable|bail|required_with:hiv_result_3,hiv_date_of_next_exam_3|date|before_or_equal:today',

            'hiv_result_3' => 'nullable|bail|required_with:hiv_date_3,hiv_date_of_next_exam_3|max:20',

            'hiv_date_of_next_exam_3' => 'nullable|bail|required_with:hiv_date_3,hiv_result_3|date|after:hiv_date_3',
            ///////////////////////////

            'hbsag_date_1' => 'nullable|bail|required_with:hbsag_result_1,hbsag_date_of_next_exam_1|date|before_or_equal:today',

            'hbsag_result_1' => 'nullable|bail|required_with:hbsag_date_1,hbsag_date_of_next_exam_1|max:20',

            'hbsag_date_of_next_exam_1' => 'nullable|bail|required_with:hbsag_date_1,hbsag_result_1|date|after:hbsag_date_1',
            ///////////////////////////

            'hbsag_date_2' => 'nullable|bail|required_with:hbsag_result_2,hbsag_date_of_next_exam_2|date|before_or_equal:today',

            'hbsag_result_2' => 'nullable|bail|required_with:hbsag_date_2,hbsag_date_of_next_exam_2|max:20',

            'hbsag_date_of_next_exam_2' => 'nullable|bail|required_with:hbsag_date_2,hbsag_result_2|date|after:hbsag_date_2',
            ///////////////////////////

            'hbsag_date_3' => 'nullable|bail|required_with:hbsag_result_3,hbsag_date_of_next_exam_3|date|before_or_equal:today',

            'hbsag_result_3' => 'nullable|bail|required_with:hbsag_date_3,hbsag_date_of_next_exam_3|max:20',

            'hbsag_date_of_next_exam_3' => 'nullable|bail|required_with:hbsag_date_3,hbsag_result_3|date|after:hbsag_date_3',
            ///////////////////////////

            'vdrl_date_1' => 'nullable|bail|required_with:vdrl_result_1,vdrl_date_of_next_exam_1|date|before_or_equal:today',

            'vdrl_result_1' => 'nullable|bail|required_with:vdrl_date_1,vdrl_date_of_next_exam_1|max:20',

            'vdrl_date_of_next_exam_1' => 'nullable|bail|required_with:vdrl_date_1,vdrl_result_1|date|after:vdrl_date_1',
            ///////////////////////////

            'vdrl_date_2' => 'nullable|bail|required_with:vdrl_result_2,vdrl_date_of_next_exam_2|date|before_or_equal:today',

            'vdrl_result_2' => 'nullable|bail|required_with:vdrl_date_2,vdrl_date_of_next_exam_2|max:20',

            'vdrl_date_of_next_exam_2' => 'nullable|bail|required_with:vdrl_date_2,vdrl_result_2|date|after:vdrl_date_2',
            ///////////////////////////

            'vdrl_date_3' => 'nullable|bail|required_with:vdrl_result_3,vdrl_date_of_next_exam_3|date|before_or_equal:today',

            'vdrl_result_3' => 'nullable|bail|required_with:vdrl_date_3,vdrl_date_of_next_exam_3|max:20',

            'vdrl_date_of_next_exam_3' => 'nullable|bail|required_with:vdrl_date_3,vdrl_result_3|date|after:vdrl_date_3',
            //////////////////////////

            'cervical_smear' => 'array|size:' . $this->cervical_smear_rows,

            'cervical_smear.*.date' => 'nullable|bail|required_with:cervical_smear.*.initial,cervical_smear.*.date_of_next_exam|date|before_or_equal:today',

            'cervical_smear.*.initial' => 'nullable|bail|required_with:cervical_smear.*.date,cervical_smear.*.date_of_next_exam|max:20',

            'cervical_smear.*.date_of_next_exam' => 'nullable|bail|required_with:cervical_smear.*.date,cervical_smear.*.initial|date|after:cervical_smear.*.date'
        ]));

        //run the validation process. If there are errors, it will automatically redirect back
        $validator->validate();

        if($mode == 'add')
        {
            //if applicant is new
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

            //if applicant chosen already exists
            else
            {
                $applicant = Applicant::find($this->request->id);
                $applicant->age = $this->request->age;
                $applicant->nationality = $this->request->nationality;
                $applicant->save();
            }

            //save to database
            $pink_health_certificate = new PinkHealthCertificate;
            $pink_health_certificate->applicant_id = $applicant->applicant_id;
            $pink_health_certificate->registration_number = (new RegistrationNumberGenerator)->getRegistrationNumber('App\PinkHealthCertificate', 'registration_number');
            $pink_health_certificate->validity_period = PinkHealthCertificate::VALIDITY_PERIOD['string'];
            $pink_health_certificate->occupation = $this->request->occupation;
            $pink_health_certificate->place_of_work = $this->request->place_of_work;
            $pink_health_certificate->issuance_date = $this->request->date_of_issuance;
            $pink_health_certificate->expiration_date = $this->request->date_of_expiration;
            $pink_health_certificate->community_tax_no = $this->request->community_tax_no;
            $pink_health_certificate->community_tax_issued_at = $this->request->community_tax_issued_at;
            $pink_health_certificate->community_tax_issued_on = $this->request->community_tax_issued_on;
            $pink_health_certificate->is_expired = false;
            $pink_health_certificate->save();

            //prepare variables for the input fields in a table at the front-end
            $immunizations = $this->tabledFieldsLooper(true, 'App\Immunization', $this->immunization_rows);

            $xray_sputums = $this->tabledFieldsLooper(true, 'App\XRaySputum', $this->xray_sputum_rows);

            $stool_and_others = $this->tabledFieldsLooper(true, 'App\StoolAndOther', $this->stool_and_other_rows);

            $hivs = $this->tabledFieldsLooper(true, 'App\HivExamination', $this->hiv_rows);

            $hbsags = $this->tabledFieldsLooper(true, 'App\HbsagExamination', $this->hbsag_rows);

            $vdrls = $this->tabledFieldsLooper(true, 'App\VdrlExamination', $this->vdrl_rows);

            $cervical_smears = $this->tabledFieldsLooper(true, 'App\CervicalSmearExamination', $this->cervical_smear_rows);
        }

        //if either edit or renew
        else
        {
            //update applicant's age, which usually changes
            $applicant = $pink_health_certificate->applicant;
            $applicant->age = $this->request->age;
            $applicant->save();

            //update common pink card values that usually change
            $pink_health_certificate->occupation = $this->request->occupation;
            $pink_health_certificate->place_of_work = $this->request->place_of_work;
            $pink_health_certificate->issuance_date = $this->request->date_of_issuance;
            $pink_health_certificate->expiration_date = $this->request->date_of_expiration;
            $pink_health_certificate->community_tax_no = $this->request->community_tax_no;
            $pink_health_certificate->community_tax_issued_at = $this->request->community_tax_issued_at;
            $pink_health_certificate->community_tax_issued_on = $this->request->community_tax_issued_on;

            //if renewing and it's already next year, update registration number
            if($mode == 'renew')
                if((int)explode('-', $pink_health_certificate->registration_number)[0] < (int)date('Y', strtotime('now')))
                    $pink_health_certificate->registration_number = (new RegistrationNumberGenerator)->getRegistrationNumber('App\PinkHealthCertificate', 'registration_number');

            $pink_health_certificate->save();

            $pink_health_certificate->checkIfExpired();

            //prepare variables for the input fields in a table at the front-end
            $immunizations = $this->tabledFieldsLooper(false, 'App\Immunization', $this->immunization_rows, $pink_health_certificate->immunizations->sortBy('row_number'));

            $xray_sputums = $this->tabledFieldsLooper(false, 'App\XRaySputum', $this->xray_sputum_rows, $pink_health_certificate->xray_sputums->sortBy('row_number'));

            $stool_and_others = $this->tabledFieldsLooper(false, 'App\StoolAndOther', $this->stool_and_other_rows, $pink_health_certificate->stool_and_others->sortBy('row_number'));

            $hivs = $this->tabledFieldsLooper(false, 'App\HivExamination', $this->hiv_rows, $pink_health_certificate->hiv_examinations->sortBy('row_number'));

            $hbsags = $this->tabledFieldsLooper(false, 'App\HbsagExamination', $this->hbsag_rows, $pink_health_certificate->hbsag_examinations->sortBy('row_number'));

            $vdrls = $this->tabledFieldsLooper(false, 'App\VdrlExamination', $this->vdrl_rows, $pink_health_certificate->vdrl_examinations->sortBy('row_number'));

            $cervical_smears = $this->tabledFieldsLooper(false, 'App\CervicalSmearExamination', $this->cervical_smear_rows, $pink_health_certificate->cervical_smear_examinations->sortBy('row_number'));
        }

        //Database operations below for form fields in tables. If statement for adding/editing record, elseif statement for deleting a record when it is in edit/renew mode and the user deletes a record.
        //loop variable $i for every foreach loop below. It is used for accessing form fields' name suffixed with a number.
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

            elseif($this->request->{"immunization_date_$i"} == null && $this->request->{"immunization_kind_$i"} == null && $this->request->{"immunization_date_of_expiration_$i"} == null && ($mode == 'edit' || $mode == 'renew'))
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

            elseif($this->request->input("x-ray_sputum_exam_date_$i") == null && $this->request->input("x-ray_sputum_exam_kind_$i") == null && $this->request->input("x-ray_sputum_exam_result_$i") == null && ($mode == 'edit' || $mode == 'renew'))
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

            elseif($this->request->{"stool_and_other_exam_date_$i"} == null && $this->request->{"stool_and_other_exam_kind_$i"} == null && $this->request->{"stool_and_other_exam_result_$i"} == null && ($mode == 'edit' || $mode == 'renew'))
                $stool_and_other->delete();

            $i++;
        }

        $i = 1;

        foreach($hivs as $hiv)
        {
            if($this->request->{"hiv_date_$i"} != null && $this->request->{"hiv_result_$i"} != null && $this->request->{"hiv_date_of_next_exam_$i"} != null)
            {
                $hiv->pink_health_certificate_id = $pink_health_certificate->pink_health_certificate_id;
                $hiv->date_of_exam = $this->request->{"hiv_date_$i"};
                $hiv->result = $this->request->{"hiv_result_$i"};
                $hiv->date_of_next_exam = $this->request->{"hiv_date_of_next_exam_$i"};
                $hiv->row_number = $i;
                $hiv->save();
            }

            elseif($this->request->{"hiv_date_$i"} == null && $this->request->{"hiv_result_$i"} == null && $this->request->{"hiv_date_of_next_exam_$i"} == null && ($mode == 'edit' || $mode == 'renew'))
                $hiv->delete();

            $i++;
        }

        $i = 1;

        foreach($hbsags as $hbsag)
        {
            if($this->request->{"hbsag_date_$i"} != null && $this->request->{"hbsag_result_$i"} != null && $this->request->{"hbsag_date_of_next_exam_$i"} != null)
            {
                $hbsag->pink_health_certificate_id = $pink_health_certificate->pink_health_certificate_id;
                $hbsag->date_of_exam = $this->request->{"hbsag_date_$i"};
                $hbsag->result = $this->request->{"hbsag_result_$i"};
                $hbsag->date_of_next_exam = $this->request->{"hbsag_date_of_next_exam_$i"};
                $hbsag->row_number = $i;
                $hbsag->save();
            }

            elseif($this->request->{"hbsag_date_$i"} == null && $this->request->{"hbsag_result_$i"} == null && $this->request->{"hbsag_date_of_next_exam_$i"} == null && ($mode == 'edit' || $mode == 'renew'))
                $hbsag->delete();

            $i++;
        }

        $i = 1;

        foreach($vdrls as $vdrl)
        {
            if($this->request->{"vdrl_date_$i"} != null && $this->request->{"vdrl_result_$i"} != null && $this->request->{"vdrl_date_of_next_exam_$i"} != null)
            {
                $vdrl->pink_health_certificate_id = $pink_health_certificate->pink_health_certificate_id;
                $vdrl->date_of_exam = $this->request->{"vdrl_date_$i"};
                $vdrl->result = $this->request->{"vdrl_result_$i"};
                $vdrl->date_of_next_exam = $this->request->{"vdrl_date_of_next_exam_$i"};
                $vdrl->row_number = $i;
                $vdrl->save();
            }

            elseif($this->request->{"vdrl_date_$i"} == null && $this->request->{"vdrl_result_$i"} == null && $this->request->{"vdrl_date_of_next_exam_$i"} == null && ($mode == 'edit' || $mode == 'renew'))
                $vdrl->delete();

            $i++;
        }

        $i = 1;

        foreach($cervical_smears as $cervical_smear)
        {
            if($this->request->cervical_smear[$i]['date'] != null && $this->request->cervical_smear[$i]['initial'] != null && $this->request->cervical_smear[$i]['date_of_next_exam'] != null)
            {
                $cervical_smear->pink_health_certificate_id = $pink_health_certificate->pink_health_certificate_id;
                $cervical_smear->date_of_exam = $this->request->cervical_smear[$i]['date'];
                $cervical_smear->initial = $this->request->cervical_smear[$i]['initial'];
                $cervical_smear->date_of_next_exam = $this->request->cervical_smear[$i]['date_of_next_exam'];
                $cervical_smear->row_number = $i;
                $cervical_smear->save();
            }

            elseif($this->request->cervical_smear[$i]['date'] == null && $this->request->cervical_smear[$i]['initial'] == null && $this->request->cervical_smear[$i]['date_of_next_exam'] == null && ($mode == 'edit' || $mode == 'renew'))
                $cervical_smear->delete();

            $i++;
        }

        if($mode != 'edit')
        {
            return $pink_health_certificate->pink_health_certificate_id;
        }
    }
}
