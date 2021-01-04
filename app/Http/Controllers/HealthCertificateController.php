<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Applicant;
use App\HealthCertificate;
use App\Immunization;
use App\XRaySputum;
use App\StoolAndOther;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use App\Custom\CertificateFileGenerator;
use Carbon\Carbon;

class HealthCertificateController extends Controller
{
	protected $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

    public function createHealthCertificate()
    {
    	if($this->request->isMethod('get'))
    	{
    		return view('health_certificate.create', [
                'title' => 'New Health Certificate',
                'certificate_types' => HealthCertificate::CERTIFICATE_TYPES
            ]);
    	}

    	elseif($this->request->isMethod('post'))
    	{
            $id = $this->create_edit_logic(true);
            /*
        		$request = $this->request;
        		$required_message = 'The :attribute field is required.';
        		//define validation rules here
        		$validator = Validator::make($this->request->all(), [
        			'existing_client' => 'sometimes|in:on',
        			'whole_name' => 'bail|required_if:existing_client,on|max:107',
        			'id' => [
        								'nullable',
                                		'bail',
                                    	'required_if:existing_client,on',
                                    	Rule::exists('applicants', 'applicant_id')->where(function ($query) use($request) {

                                        	$query->where('first_name', $request->first_name)
                                                	->where('middle_name', $request->middle_name)
                                                	->where('last_name', $request->last_name)
                                                	->where('suffix_name', $request->suffix_name)
                                                	->where('gender', $request->gender);
                                    	})
                					],

        			'registration_number' => [
    	    									'bail',
    	    									'required',
    	    									'integer',
    	    									'min:1',
    	    									'max:2147483647',
    	    									Rule::unique('health_certificates')
    	    								
    	    								],
        			'first_name' => 'bail|required|alpha_spaces|max:40',
        			'middle_name' => 'nullable|bail|alpha_spaces|max:30',
        			'last_name' => 'bail|required|alpha_spaces|max:30',
        			'suffix_name' => 'nullable|bail|in:Jr.,Sr.,I,II,III,IV,V,VI,VII,VIII,IX,X',
        			'age' => 'bail|required|integer|min:0|max:120',
        			'gender' => 'bail|required|in:0,1',
        			'type_of_work' => 'bail|required|alpha_spaces|max:40',
        			'name_of_establishment' => 'bail|required|max:50',
        			'date_of_issuance' => 'bail|required|date|before_or_equal:today',
        			'date_of_expiration' => 'bail|required|date|after_or_equal:today',

        			'immunization_date_1' => 'nullable|bail|required_with:immunization_kind_1,immunization_date_of_expiration_1|date|before_or_equal:today',

        			'immunization_kind_1' => 'nullable|bail|required_with:immunization_date_1,immunization_date_of_expiration_1|alpha_spaces|max:15',

        			'immunization_date_of_expiration_1' => 'nullable|bail|required_with:immunization_date_1,immunization_kind_1|date|after_or_equal:today',


        			'immunization_date_2' => 'nullable|bail|required_with:immunization_kind_2,immunization_date_of_expiration_2|date|before_or_equal:today',

        			'immunization_kind_2' => 'nullable|bail|required_with:immunization_date_2,immunization_date_of_expiration_2|alpha_spaces|max:15',

        			'immunization_date_of_expiration_2' => 'nullable|bail|required_with:immunization_date_2,immunization_kind_2|date|after_or_equal:today',


        			'x-ray_sputum_exam_date_1' => 'nullable|bail|required_with:x-ray_sputum_exam_kind_1,x-ray_sputum_exam_result_1|date|before_or_equal:today',

        			'x-ray_sputum_exam_kind_1' => 'nullable|bail|required_with:x-ray_sputum_exam_date_1,x-ray_sputum_exam_result_1|alpha_spaces|max:15',

        			'x-ray_sputum_exam_result_1' => 'nullable|bail|required_with:x-ray_sputum_exam_date_1,x-ray_sputum_exam_kind_1|alpha_spaces|max:15',


        			'x-ray_sputum_exam_date_2' => 'nullable|bail|required_with:x-ray_sputum_exam_kind_2,x-ray_sputum_exam_result_2|date|before_or_equal:today',

        			'x-ray_sputum_exam_kind_2' => 'nullable|bail|required_with:x-ray_sputum_exam_date_2,x-ray_sputum_exam_result_2|alpha_spaces|max:15',

        			'x-ray_sputum_exam_result_2' => 'nullable|bail|required_with:x-ray_sputum_exam_date_2,x-ray_sputum_exam_kind_2|alpha_spaces|max:15',


        			'stool_and_other_exam_date_1' => 'nullable|bail|required_with:stool_and_other_exam_kind_1,stool_and_other_exam_result_1|date|before_or_equal:today',

        			'stool_and_other_exam_kind_1' => 'nullable|bail|required_with:stool_and_other_exam_date_1,stool_and_other_exam_result_1|alpha_spaces|max:15',

        			'stool_and_other_exam_result_1' => 'nullable|bail|required_with:stool_and_other_exam_date_1,stool_and_other_exam_kind_1|alpha_spaces|max:15',


        			'stool_and_other_exam_date_2' => 'nullable|bail|required_with:stool_and_other_exam_kind_2,stool_and_other_exam_result_2|date|before_or_equal:today',

        			'stool_and_other_exam_kind_2' => 'nullable|bail|required_with:stool_and_other_exam_date_2,stool_and_other_exam_result_2|alpha_spaces|max:15',

        			'stool_and_other_exam_result_2' => 'nullable|bail|required_with:stool_and_other_exam_date_2,stool_and_other_exam_kind_2|alpha_spaces|max:15'
        		], [
        			'id.required_if' => 'The applicant you provided is missing important data.',
        			'id.exists' => 'The applicant you provided does not exist in the system.', 
        			//rather than use required rule on these fields and code the required_if and required_unless logic manually based on if the existing client field exists in the request,
        			//just use the required_if and required_unless rules and change the error message so it will just look like the error message of the required rule.
        			'first_name.required_unless' => $required_message,
        			'last_name.required_unless' => $required_message,
        			'whole_name.required_if' => $required_message,
        		]);

        		//after validation hook to further add validation rules after the first rules
        		$validator->after(function ($validator) {
        			if($this->request->id != null)
        			{
        				$existing_applicant = Applicant::find($this->request->id);

        				if($existing_applicant != null && $existing_applicant->age > (int)$this->request->age)
        					$validator->errors()->add('age', 'The applicant cannot be younger than his/her current age.');
        			}
        			
        			$input_value_from_tables = collect([
        					$this->request->immunization_date_1, $this->request->immunization_kind_1, $this->request->immunization_date_of_expiration_1,
        					$this->request->immunization_date_2, $this->request->immunization_kind_2, $this->request->immunization_date_of_expiration_2,

        					$this->request->input('x-ray_sputum_exam_date_1'), $this->request->input('x-ray_sputum_exam_kind_1'), $this->request->input('x-ray_sputum_exam_result_1'),
        					$this->request->input('x-ray_sputum_exam_date_2'), $this->request->input('x-ray_sputum_exam_kind_2'), $this->request->input('x-ray_sputum_exam_result_2'),

        					$this->request->stool_and_other_exam_date_1, $this->request->stool_and_other_exam_kind_1, $this->request->stool_and_other_exam_result_1,
        					$this->request->stool_and_other_exam_date_2, $this->request->stool_and_other_exam_kind_2, $this->request->stool_and_other_exam_result_2
        				]);

        			if($input_value_from_tables->unique()->count() == 1)
        				$validator->errors()->add('general_table_error', 'There must be at least one result for Immunization, X-Ray, Sputum Exam, Stool, and Other Exam.');

    			});

        		//run the validation process. If there are errors, it will automatically redirect back
    			$validator->validate();

    			if($this->request->id == null)//if the validation did not detect errors, it will proceed saving records to the database
    			{
    				$applicant = new Applicant;
    				$applicant->first_name = $this->request->first_name;
    				$applicant->middle_name = $this->request->middle_name;
    				$applicant->last_name = $this->request->last_name;
    				$applicant->suffix_name = $this->request->suffix_name;
    				$applicant->age = $this->request->age;
    				$applicant->gender = $this->request->gender;
    			}

    			else
    			{
    				$applicant = Applicant::find($this->request->id);
    				$applicant->age = $this->request->age;
    			}

    			$applicant->save();
    			

    			$health_certificate = new HealthCertificate;
    			$health_certificate->applicant_id = $applicant->applicant_id;
    			$health_certificate->registration_number = $this->request->registration_number;
    			$health_certificate->work_type = $this->request->type_of_work;
    			$health_certificate->establishment = $this->request->name_of_establishment;
    			$health_certificate->issuance_date = $this->request->date_of_issuance;
    			$health_certificate->expiration_date = $this->request->date_of_expiration;
    			$health_certificate->save();

    			if($this->request->immunization_date_1 != null && $this->request->immunization_kind_1 != null && $this->request->immunization_date_of_expiration_1 != null)
    			{
    				$immunization1 = new Immunization;
    				$immunization1->health_certificate_id = $health_certificate->health_certificate_id;
    				$immunization1->date = $this->request->immunization_date_1;
    				$immunization1->kind = $this->request->immunization_kind_1;
    				$immunization1->expiration_date = $this->request->immunization_date_of_expiration_1;
    				$immunization1->row_number = 1;
    				$immunization1->save();
    			}

    			if($this->request->immunization_date_2 != null && $this->request->immunization_kind_2 != null && $this->request->immunization_date_of_expiration_2 != null)
    			{
    				$immunization2 = new Immunization;
    				$immunization2->health_certificate_id = $health_certificate->health_certificate_id;
    				$immunization2->date = $this->request->immunization_date_2;
    				$immunization2->kind = $this->request->immunization_kind_2;
    				$immunization2->expiration_date = $this->request->immunization_date_of_expiration_2;
    				$immunization2->row_number = 2;
    				$immunization2->save();
    			}

    			if($this->request->input('x-ray_sputum_exam_date_1') != null && $this->request->input('x-ray_sputum_exam_kind_1') != null && $this->request->input('x-ray_sputum_exam_result_1') != null)
    			{
    				$x_ray_sputum_exam_1 = new XRaySputum;
    				$x_ray_sputum_exam_1->health_certificate_id = $health_certificate->health_certificate_id;
    				$x_ray_sputum_exam_1->date = $this->request->input('x-ray_sputum_exam_date_1');
    				$x_ray_sputum_exam_1->kind = $this->request->input('x-ray_sputum_exam_kind_1');
    				$x_ray_sputum_exam_1->result = $this->request->input('x-ray_sputum_exam_result_1');
    				$x_ray_sputum_exam_1->row_number = 1;
    				$x_ray_sputum_exam_1->save();
    			}

    			if($this->request->input('x-ray_sputum_exam_date_2') != null && $this->request->input('x-ray_sputum_exam_kind_2') != null && $this->request->input('x-ray_sputum_exam_result_2') != null)
    			{
    				$x_ray_sputum_exam_2 = new XRaySputum;
    				$x_ray_sputum_exam_2->health_certificate_id = $health_certificate->health_certificate_id;
    				$x_ray_sputum_exam_2->date = $this->request->input('x-ray_sputum_exam_date_2');
    				$x_ray_sputum_exam_2->kind = $this->request->input('x-ray_sputum_exam_kind_2');
    				$x_ray_sputum_exam_2->result = $this->request->input('x-ray_sputum_exam_result_2');
    				$x_ray_sputum_exam_2->row_number = 2;
    				$x_ray_sputum_exam_2->save();
    			}

    			if($this->request->stool_and_other_exam_date_1 != null && $this->request->stool_and_other_exam_kind_1 != null && $this->request->stool_and_other_exam_result_1 != null)
    			{
    				$stool_and_others1 = new StoolAndOther;
    				$stool_and_others1->health_certificate_id = $health_certificate->health_certificate_id;
    				$stool_and_others1->date = $this->request->stool_and_other_exam_date_1;
    				$stool_and_others1->kind = $this->request->stool_and_other_exam_kind_1;
    				$stool_and_others1->result = $this->request->stool_and_other_exam_result_1;
    				$stool_and_others1->row_number = 1;
    				$stool_and_others1->save();
    			}

    			if($this->request->stool_and_other_exam_date_2 != null && $this->request->stool_and_other_exam_kind_2 != null && $this->request->stool_and_other_exam_result_2 != null)
    			{
    				$stool_and_others2 = new StoolAndOther;
    				$stool_and_others2->health_certificate_id = $health_certificate->health_certificate_id;
    				$stool_and_others2->date = $this->request->stool_and_other_exam_date_2;
    				$stool_and_others2->kind = $this->request->stool_and_other_exam_kind_2;
    				$stool_and_others2->result = $this->request->stool_and_other_exam_result_2;
    				$stool_and_others2->row_number = 2;
    				$stool_and_others2->save();
    			}

                return back()->with('success', ['header' => 'Health Certificate created successfully!', 'message' => 'Click the "View PDF" button to view the Health Certificate as PDF file and print there directly.']);
            */

            return redirect("health_certificate/$id/preview");
    	}
    }

    /*public function getHealthCertificates()
    {
    	return view('health_certificate.index', [
    		'title' => 'Health Certificates',
    		'health_certificates' => HealthCertificate::with('applicant')->orderBy('updated_at', 'desc')->paginate(50)
    	]);
    }*/

    public function viewEditCertificate(HealthCertificate $health_certificate)
    {
    	if($this->request->isMethod('get'))
    	{
    		return view('health_certificate.view_edit', [
    			'title' => "Health Certificate Information | {$health_certificate->registration_number}",
    			'applicant' => $health_certificate->applicant,
    			'health_certificate' => $health_certificate,
    			'immunization' => $health_certificate->immunizations->sortBy('row_number'),
    			'stool_and_others' => $health_certificate->stool_and_others->sortBy('row_number'),
    			'xray_sputum' => $health_certificate->xray_sputums->sortBy('row_number'),
    			'picture_url' => (new CertificateFileGenerator($health_certificate))->getPicturePathAndURL()['url'],
                'certificate_types' => HealthCertificate::CERTIFICATE_TYPES
    		]);
    	}

    	elseif($this->request->isMethod('put'))
    	{
    		$this->create_edit_logic(false, $health_certificate->applicant, $health_certificate);

            return redirect("health_certificate/{$health_certificate->applicant_id}/preview");

            /*return back()->with('success', 
                                ['header' => 'Health Certificate updated successfully!', 
                                'message' => null]);*/
    	}
    }

    public function createHealthCertificateExistingClient(Applicant $applicant)
    {
        if($this->request->isMethod('get'))
        {
            return view('health_certificate.existing_client_create', [
                'title' => 'Add Health Certificate',
                'applicant' => $applicant,
                'certificate_types' => HealthCertificate::CERTIFICATE_TYPES
            ]);
        }

        elseif($this->request->isMethod('post'))
        {
            $id = $this->create_edit_logic(true, $applicant);

            return redirect("health_certificate/$id/preview");
        }
    }

    public function printPreview(HealthCertificate $health_certificate)
    {   //to use the view for printing side-by-side, remove values_only_
        return view('health_certificate.values_only_preview', [
            'logo' => '/doh_logo.png',
        	'picture' => (new CertificateFileGenerator($health_certificate))->getPicturePathAndURL()['url'],
            'color' => $health_certificate->getColor(),
            'health_certificate' => HealthCertificate::where('applicant_id', '=', $health_certificate->applicant_id)
                                                        ->with(['applicant', 'immunizations', 'stool_and_others', 'xray_sputums'])
                                                        ->first()
        ]);
    }

    public function bulkPrintPreview()
    {
        if(session()->has('print_ids'))
        {   //to use the view for printing side-by-side, remove values_only_
            return view('health_certificate.values_only_bulk_print_preview', [
                'logo' => '/doh_logo.png',
                'health_certificates' => HealthCertificate::whereIn('applicant_id', session()->get('print_ids'))
                                            ->with(['applicant', 'immunizations', 'stool_and_others', 'xray_sputums'])
                                            ->get()
            ]);
        }

        else
            return redirect('/');
    }

    public function savePicture(HealthCertificate $health_certificate)
    {
        if($this->request->ajax() && $this->request->isMethod('post'))
        {
            $picture_url_path = (new CertificateFileGenerator($health_certificate))->getPicturePathAndURL(true);

            file_put_contents($picture_url_path['path'], base64_decode($this->request->webcam));
            (new CertificateFileGenerator($health_certificate))->updatePDF();

            return response()->json(['url' => $picture_url_path['url']]);
        }

        abort(403);
    }

    public function showPicture(HealthCertificate $health_certificate)
    {
        return response()->file((new CertificateFileGenerator($health_certificate))->getPicturePathAndURL()['path'], ['Cache-Control' => 'No-Store']);
    }

    /*COMMENTED OUT. Maybe this function will be useful in the future so i'll let it be
    public function showEditCertificateValues()
    {
        $config_file_path = base_path('certificate_variables.txt');
        $certificate_variables = file($config_file_path, FILE_IGNORE_NEW_LINES);
        $current_output_folder = $certificate_variables[3];

        if($this->request->isMethod('get'))
        {
            return view('health_certificate.health_certificate_values', [
                'title' => 'View/Edit Health Certificate',
                'city_health_officer' => $certificate_variables[0],
                'health_certificates_output_folder' => $current_output_folder
            ]);
        }

        elseif($this->request->isMethod('put'))
        {
            $validator = Validator::make($this->request->all(), [
                'city_health_officer' => 'required|regex:/^[\pL\s.,-]+$/u',
                'health_certificates_output_folder' => 'required|regex:/^[a-zA-Z]\:[\/,\\\\].{1,}/'
            ]);

            $validator->after(function($validator){
                if(Storage::exists($this->request->output_folder))
                    $validator->errors()->add('output_folder', 'The output folder path does not exist in the server.');
            });

            $validator->validate();

            $certificate_variables[0] = $this->request->city_health_officer;
            $certificate_variables[3] = $this->request->health_certificates_output_folder;

            file_put_contents($config_file_path, implode("\n", $certificate_variables));

            //transfer the files from old folder to new folder and show success message
        }
    }*/

    private function create_edit_logic($is_create, Applicant $applicant = null, HealthCertificate $health_certificate = null)
    {
        //set rules depending on $is_create
        if($is_create)
        {
            $required_message = 'The :attribute field is required.';

            if($applicant != null)
                $create_edit_rules = [
                    'date_of_issuance' => 'bail|required|date|before_or_equal:today',
                ];

            else
                $create_edit_rules = [
                    'first_name' => 'bail|required|alpha_spaces|max:40',
                    'middle_name' => 'nullable|bail|alpha_spaces|max:30',
                    'last_name' => 'bail|required|alpha_spaces|max:30',
                    'suffix_name' => 'nullable|bail|in:Jr.,Sr.,I,II,III,IV,V,VI,VII,VIII,IX,X',
                    'age' => 'bail|required|integer|min:0|max:120',
                    'gender' => 'bail|required|in:0,1',
                    'date_of_issuance' => 'bail|required|date|before_or_equal:today',
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
            if($this->request->update_mode != null && $this->request->update_mode == 'edit_renew')
                $date_of_issuance_rule = "bail|required|date|before_or_equal:today|after:{$health_certificate->dateToInput('issuance_date')}";
            else
                $date_of_issuance_rule = 'bail|required|date|before_or_equal:today';

            $create_edit_rules = [
                'update_mode' => 'bail|required|in:edit,edit_renew',
                'age' => 'bail|required|integer|min:0|max:120',
                'date_of_issuance' => $date_of_issuance_rule,

            ];
            /*$old_health_certificate = $health_certificate->replicate();

            $old_health_certificate->health_certificate_id = $health_certificate->health_certificate_id;
            $old_health_certificate->created_at = $health_certificate->created_at;*/
        }
        
        //define validation rules here
        $validator = Validator::make($this->request->all(), array_merge($create_edit_rules, [
            'type_of_work' => 'bail|required|alpha_spaces|max:40',
            'name_of_establishment' => 'bail|required|max:50',
            'certificate_type' => 'bail|required|in:' . implode(',', collect(HealthCertificate::CERTIFICATE_TYPES)->pluck('string')->toArray()),
            'date_of_expiration' => 'bail|required|date',

            'immunization_date_1' => 'nullable|bail|required_with:immunization_kind_1,immunization_date_of_expiration_1|date|before_or_equal:today',

            'immunization_kind_1' => 'nullable|bail|required_with:immunization_date_1,immunization_date_of_expiration_1|max:20',

            'immunization_date_of_expiration_1' => 'nullable|bail|required_with:immunization_date_1,immunization_kind_1|date|after:immunization_date_1',


            'immunization_date_2' => 'nullable|bail|required_with:immunization_kind_2,immunization_date_of_expiration_2|date|before_or_equal:today',

            'immunization_kind_2' => 'nullable|bail|required_with:immunization_date_2,immunization_date_of_expiration_2|max:20',

            'immunization_date_of_expiration_2' => 'nullable|bail|required_with:immunization_date_2,immunization_kind_2|date|after:immunization_date_2',


            'x-ray_sputum_exam_date_1' => 'nullable|bail|required_with:x-ray_sputum_exam_kind_1,x-ray_sputum_exam_result_1|date|before_or_equal:today',

            'x-ray_sputum_exam_kind_1' => 'nullable|bail|required_with:x-ray_sputum_exam_date_1,x-ray_sputum_exam_result_1|max:20',

            'x-ray_sputum_exam_result_1' => 'nullable|bail|required_with:x-ray_sputum_exam_date_1,x-ray_sputum_exam_kind_1|max:20',


            'x-ray_sputum_exam_date_2' => 'nullable|bail|required_with:x-ray_sputum_exam_kind_2,x-ray_sputum_exam_result_2|date|before_or_equal:today',

            'x-ray_sputum_exam_kind_2' => 'nullable|bail|required_with:x-ray_sputum_exam_date_2,x-ray_sputum_exam_result_2|max:20',

            'x-ray_sputum_exam_result_2' => 'nullable|bail|required_with:x-ray_sputum_exam_date_2,x-ray_sputum_exam_kind_2|max:20',


            'stool_and_other_exam_date_1' => 'nullable|bail|required_with:stool_and_other_exam_kind_1,stool_and_other_exam_result_1|date|before_or_equal:today',

            'stool_and_other_exam_kind_1' => 'nullable|bail|required_with:stool_and_other_exam_date_1,stool_and_other_exam_result_1|max:20',

            'stool_and_other_exam_result_1' => 'nullable|bail|required_with:stool_and_other_exam_date_1,stool_and_other_exam_kind_1|max:20',


            'stool_and_other_exam_date_2' => 'nullable|bail|required_with:stool_and_other_exam_kind_2,stool_and_other_exam_result_2|date|before_or_equal:today',

            'stool_and_other_exam_kind_2' => 'nullable|bail|required_with:stool_and_other_exam_date_2,stool_and_other_exam_result_2|max:20',

            'stool_and_other_exam_result_2' => 'nullable|bail|required_with:stool_and_other_exam_date_2,stool_and_other_exam_kind_2|max:20'
        ]));

        //after validation hook to further add validation rules after the first rules
        $validator->after(function ($validator) use ($is_create) {
            $input_value_from_tables = collect([
                    $this->request->immunization_date_1, $this->request->immunization_kind_1, $this->request->immunization_date_of_expiration_1,
                    $this->request->immunization_date_2, $this->request->immunization_kind_2, $this->request->immunization_date_of_expiration_2,

                    $this->request->input('x-ray_sputum_exam_date_1'), $this->request->input('x-ray_sputum_exam_kind_1'), $this->request->input('x-ray_sputum_exam_result_1'),
                    $this->request->input('x-ray_sputum_exam_date_2'), $this->request->input('x-ray_sputum_exam_kind_2'), $this->request->input('x-ray_sputum_exam_result_2'),

                    $this->request->stool_and_other_exam_date_1, $this->request->stool_and_other_exam_kind_1, $this->request->stool_and_other_exam_result_1,
                    $this->request->stool_and_other_exam_date_2, $this->request->stool_and_other_exam_kind_2, $this->request->stool_and_other_exam_result_2
                ]);

            if($input_value_from_tables->unique()->count() == 1)
                $validator->errors()->add('general_table_error', 'There must be at least one result for Immunization, X-Ray, Sputum Exam, Stool, or Other Exam.');
        });

        //run the validation process. If there are errors, it will automatically redirect back
        $validator->validate();

        //save to database
        if($is_create)
        {
            //generate reg number
            $year_now = date('Y', strtotime('now'));
            $total_registrations_this_year = HealthCertificate::where('registration_number', 'like', "$year_now%")->count();
            $iteration = 1;

            do
            {
                $registration_number = "$year_now-" . sprintf('%05d', $total_registrations_this_year + $iteration);
                ++$iteration;
            }
            
            while(HealthCertificate::where('registration_number', '=', $registration_number)->count() > 0);

            if($applicant == null)
            {
                $applicant = new Applicant;
                $applicant->first_name = $this->request->first_name;
                $applicant->middle_name = $this->request->middle_name == null ? null : $this->request->middle_name;
                $applicant->last_name = $this->request->last_name;
                $applicant->suffix_name = $this->request->suffix_name == null ? null : $this->request->suffix_name;
                $applicant->age = $this->request->age;
                $applicant->gender = $this->request->gender;
                $applicant->save();
            }

            $health_certificate = new HealthCertificate;
            $health_certificate->applicant_id = $applicant->applicant_id;
            $health_certificate->registration_number = $registration_number;
            $health_certificate->duration = $this->request->certificate_type;
            $health_certificate->work_type = $this->request->type_of_work;
            $health_certificate->establishment = $this->request->name_of_establishment;
            $health_certificate->issuance_date = $this->request->date_of_issuance;
            $health_certificate->expiration_date = $this->getExpirationDate($this->request->date_of_issuance, $this->request->certificate_type);
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
            $health_certificate->expiration_date = $this->getExpirationDate($this->request->date_of_issuance, $this->request->certificate_type);
            $health_certificate->work_type = $this->request->type_of_work;
            $health_certificate->establishment = $this->request->name_of_establishment;
            $health_certificate->save();

            $health_certificate->checkIfExpired();
            
            $immunizations = Immunization::where('applicant_id', '=', $health_certificate->applicant_id)->get();
            $immunization1 = $this->findByRowNumber($immunizations, 1, 'App\Immunization');
            $immunization2 = $this->findByRowNumber($immunizations, 2, 'App\Immunization');

            $x_ray_sputum_exams = XRaySputum::where('applicant_id', '=', $health_certificate->applicant_id)->get();
            $x_ray_sputum_exam1 = $this->findByRowNumber($x_ray_sputum_exams, 1, 'App\XRaySputum');
            $x_ray_sputum_exam2 = $this->findByRowNumber($x_ray_sputum_exams, 2, 'App\XRaySputum');

            $stool_and_others = StoolAndOther::where('applicant_id', '=', $health_certificate->applicant_id)->get();
            $stool_and_others1 = $this->findByRowNumber($stool_and_others, 1, 'App\StoolAndOther');
            $stool_and_others2 = $this->findByRowNumber($stool_and_others, 2, 'App\StoolAndOther');
        }

        //solve: what if an immunization is only at row 2 or row 1? applies to xray and sputum and stools and others
        //save to database for the 3 tables linked to health certificate
        if($this->request->immunization_date_1 != null && $this->request->immunization_kind_1 != null && $this->request->immunization_date_of_expiration_1 != null)
        {
            $immunization1->applicant_id = $health_certificate->applicant_id;
            $immunization1->date = $this->request->immunization_date_1;
            $immunization1->kind = $this->request->immunization_kind_1;
            $immunization1->expiration_date = $this->request->immunization_date_of_expiration_1;
            $immunization1->row_number = 1;
            $immunization1->save();
        }

        elseif($this->request->immunization_date_1 == null && $this->request->immunization_kind_1 == null && $this->request->immunization_date_of_expiration_1 == null && !$is_create && $immunization1 != null)
            $immunization1->delete();

        if($this->request->immunization_date_2 != null && $this->request->immunization_kind_2 != null && $this->request->immunization_date_of_expiration_2 != null)
        {
            $immunization2->applicant_id = $health_certificate->applicant_id;
            $immunization2->date = $this->request->immunization_date_2;
            $immunization2->kind = $this->request->immunization_kind_2;
            $immunization2->expiration_date = $this->request->immunization_date_of_expiration_2;
            $immunization2->row_number = 2;
            $immunization2->save();
        }

        elseif($this->request->immunization_date_2 == null && $this->request->immunization_kind_2 == null && $this->request->immunization_date_of_expiration_2 == null && !$is_create && $immunization2 != null)
            $immunization2->delete();

        if($this->request->input('x-ray_sputum_exam_date_1') != null && $this->request->input('x-ray_sputum_exam_kind_1') != null && $this->request->input('x-ray_sputum_exam_result_1') != null)
        {
            $x_ray_sputum_exam1->applicant_id = $health_certificate->applicant_id;
            $x_ray_sputum_exam1->date = $this->request->input('x-ray_sputum_exam_date_1');
            $x_ray_sputum_exam1->kind = $this->request->input('x-ray_sputum_exam_kind_1');
            $x_ray_sputum_exam1->result = $this->request->input('x-ray_sputum_exam_result_1');
            $x_ray_sputum_exam1->row_number = 1;
            $x_ray_sputum_exam1->save();
        }

        elseif($this->request->input('x-ray_sputum_exam_date_1') == null && $this->request->input('x-ray_sputum_exam_kind_1') == null && $this->request->input('x-ray_sputum_exam_result_1') == null 
                && !$is_create && $x_ray_sputum_exam1 != null)
                $x_ray_sputum_exam1->delete();

        if($this->request->input('x-ray_sputum_exam_date_2') != null && $this->request->input('x-ray_sputum_exam_kind_2') != null && $this->request->input('x-ray_sputum_exam_result_2') != null)
        {
            $x_ray_sputum_exam2->applicant_id = $health_certificate->applicant_id;
            $x_ray_sputum_exam2->date = $this->request->input('x-ray_sputum_exam_date_2');
            $x_ray_sputum_exam2->kind = $this->request->input('x-ray_sputum_exam_kind_2');
            $x_ray_sputum_exam2->result = $this->request->input('x-ray_sputum_exam_result_2');
            $x_ray_sputum_exam2->row_number = 2;
            $x_ray_sputum_exam2->save();
        }

        elseif($this->request->input('x-ray_sputum_exam_date_2') == null && $this->request->input('x-ray_sputum_exam_kind_2') == null && $this->request->input('x-ray_sputum_exam_result_2') == null 
                && !$is_create && $x_ray_sputum_exam2 != null)
                $x_ray_sputum_exam2->delete();

        if($this->request->stool_and_other_exam_date_1 != null && $this->request->stool_and_other_exam_kind_1 != null && $this->request->stool_and_other_exam_result_1 != null)
        {
            $stool_and_others1->applicant_id = $health_certificate->applicant_id;
            $stool_and_others1->date = $this->request->stool_and_other_exam_date_1;
            $stool_and_others1->kind = $this->request->stool_and_other_exam_kind_1;
            $stool_and_others1->result = $this->request->stool_and_other_exam_result_1;
            $stool_and_others1->row_number = 1;
            $stool_and_others1->save();
        }

        elseif($this->request->stool_and_other_exam_date_1 == null && $this->request->stool_and_other_exam_kind_1 == null && $this->request->stool_and_other_exam_result_1 == null 
            && !$is_create && $stool_and_others1 != null)
            $stool_and_others1->delete();

        if($this->request->stool_and_other_exam_date_2 != null && $this->request->stool_and_other_exam_kind_2 != null && $this->request->stool_and_other_exam_result_2 != null)
        {
            $stool_and_others2->applicant_id = $health_certificate->applicant_id;
            $stool_and_others2->date = $this->request->stool_and_other_exam_date_2;
            $stool_and_others2->kind = $this->request->stool_and_other_exam_kind_2;
            $stool_and_others2->result = $this->request->stool_and_other_exam_result_2;
            $stool_and_others2->row_number = 2;
            $stool_and_others2->save();
        }

        elseif($this->request->stool_and_other_exam_date_2 == null && $this->request->stool_and_other_exam_kind_2 == null && $this->request->stool_and_other_exam_result_2 == null 
            && !$is_create && $stool_and_others2 != null)
            $stool_and_others2->delete();

        //logic for saving pdf files of certificates
        if($is_create)
        {
	    	(new CertificateFileGenerator($health_certificate))->generatePDF();
	    	return $health_certificate->applicant_id;
        }

        else
        	(new CertificateFileGenerator($health_certificate))->updatePDF(/*$old_health_certificate*/);
    }

    private function findByRowNumber($model, $row_number, $class_name)
    {
        $model = $model->where('row_number', $row_number)->first();
        return $model == null ? new $class_name : $model;
    }

    private function getExpirationDate($issuance_date, $certificate_type)
    {
        return date('Y-m-d', strtotime($issuance_date . ' + ' . $certificate_type));
    }
}
