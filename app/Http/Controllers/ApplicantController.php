<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Applicant;
use App\HealthCertificate;
use App\Custom\CertificateFileGenerator;
use App\Custom\PermitFileGenerator;
use App\Custom\PinkCardFileGenerator;
use Validator;
use App\Log as ActivityLog;

class ApplicantController extends Controller
{
	protected $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function getApplicants()
	{
		return view('applicant.index', [
    		'title' => 'Clients',
    		'applicants' => Applicant::orderBy('updated_at', 'desc')->paginate(150)
    	]);
	}

	public function viewEditApplicant(Applicant $applicant)
	{
		if($this->request->isMethod('get'))
    	{
            $picture_url = null;

            if($applicant->health_certificates->isNotEmpty())
                $picture_url = (new CertificateFileGenerator($applicant->health_certificates->first()))->getPicturePathAndURL()['url'];

            elseif($applicant->pink_health_certificates->isNotEmpty())
                $picture_url = (new PinkCardFileGenerator($applicant->pink_health_certificates->first()))->getPicturePathAndURL()['url'];

    		return view('applicant.view_edit', [
    			'title' => $applicant->formatName(),
    			'applicant' => $applicant,
                'health_certificates' => $applicant->health_certificates,
                'pink_health_certificates' => $applicant->pink_health_certificates,
                'sanitary_permits' => $applicant->sanitary_permits,
                'picture_url' => $picture_url
    		]);
    	}

    	elseif($this->request->isMethod('put'))
    	{
    		$this->validate($this->request, [
    			'first_name' => 'bail|required|alpha_spaces|max:40',
    			'middle_name' => 'nullable|bail|alpha_spaces|max:30',
    			'last_name' => 'bail|required|alpha_spaces|max:30',
    			'suffix_name' => 'nullable|bail|in:Jr.,Sr.,I,II,III,IV,V,VI,VII,VIII,IX,X',
    			'age' => 'bail|required|integer|min:0|max:120',
    			'gender' => 'bail|required|in:0,1',
                'nationality'=> 'bail|required|alpha_spaces|max:20'
    		]);

    		//get folder paths for the documents with files in the storage folder
            if($applicant->health_certificates->isNotEmpty())
            {
                $old_certificate_file_generator = new CertificateFileGenerator($applicant->health_certificates->first());
                $old_applicant_certificate_folder = $old_certificate_file_generator->getHealthCertificateFolder();
            }

            if($applicant->pink_health_certificates->isNotEmpty())
            {
                $old_pink_hc_file_generator = new PinkCardFileGenerator($applicant->pink_health_certificates->first());
                $old_applicant_pink_hc_folder = $old_pink_hc_file_generator->getPinkHealthCertificateFolder();
            }

            /*if($applicant->sanitary_permits->isNotEmpty())
            {
                $old_permit_file_generator = new PermitFileGenerator($applicant->sanitary_permits->first());
                $old_applicant_permit_folder = $old_permit_file_generator->getSanitaryPermitFolder()['applicant_folder'];
            }*/

    		$applicant->first_name = $this->request->first_name;
    		$applicant->middle_name = $this->request->middle_name == null ? null : $this->request->middle_name;
    		$applicant->last_name = $this->request->last_name;
    		$applicant->suffix_name = $this->request->suffix_name == null ? null : $this->request->suffix_name;
    		$applicant->age = $this->request->age;
    		$applicant->gender = $this->request->gender;
            $applicant->nationality = $this->request->nationality;
    		$applicant->save();

    		//if there are changes affecting the filepath, update them below
    		//for health certificate
            if($applicant->health_certificates->isNotEmpty())
            {
                $new_certificate_file_generator = new CertificateFileGenerator($applicant->health_certificates->first()->refresh());
                $new_applicant_certificate_folder = $new_certificate_file_generator->getHealthCertificateFolder()['applicant_folder'];

                if($old_applicant_certificate_folder['applicant_folder'] != $new_applicant_certificate_folder && file_exists($old_applicant_certificate_folder['certificate_folder_path']))
                    $new_certificate_file_generator->updateApplicantFolder($old_applicant_certificate_folder['applicant_folder']);
            }

            //for pink card
            if($applicant->pink_health_certificates->isNotEmpty())
            {
                $new_pink_hc_file_generator = new PinkCardFileGenerator($applicant->pink_health_certificates->first()->refresh());
                $new_applicant_pink_hc_folder = $new_pink_hc_file_generator->getPinkHealthCertificateFolder()['applicant_folder'];

                if($old_applicant_pink_hc_folder['applicant_folder'] != $new_applicant_pink_hc_folder && file_exists($old_applicant_pink_hc_folder['pink_card_folder_path']))
                    $new_pink_hc_file_generator->updateApplicantFolder($old_applicant_pink_hc_folder['applicant_folder']);
            }

            /*if($applicant->sanitary_permits->isNotEmpty())
            {
                $new_permit_file_generator = new PermitFileGenerator($applicant->sanitary_permits->first()->refresh());
                $new_applicant_permit_folder = $new_permit_file_generator->getSanitaryPermitFolder()['applicant_folder'];

                if($old_applicant_permit_folder != $new_applicant_permit_folder)
                    $new_permit_file_generator->updateApplicantFolder($old_applicant_permit_folder);
            }*/

            $log = new ActivityLog;
            $log->user_id = Auth::user()->user_id;
            $log->loggable_id = $applicant->applicant_id;
            $log->loggable_type = get_class($applicant);
            $log->description = "Updated applicant's info";
            $log->save();

    		return back()->with('success', ['header' => 'Applicant updated successfully!', 'message' => null]);
    	}
	}

    public function searchApplicantsForCertificateOrPermitForm()
    {
    	return collect(['results' => Applicant::search($this->request->q)
                        ->with('health_certificates')
				    	->get()
				    	->transform(function($item, $key){
				    		return collect([
				    			'id' => $item->applicant_id,
				    			'first_name' => $item->first_name,
				    			'middle_name' => $item->middle_name,
				    			'last_name' => $item->last_name,
				    			'suffix_name' => $item->suffix_name,
				    			'age' => $item->age,
				    			'gender' => $item->gender,
				    			'nationality' => $item->nationality,
				    			'whole_name' => $item->formatName(), 
				    			'basic_info' => "{$item->getGender()}, $item->age / " . 
                                                    $item->health_certificates->sortByDesc('health_certificate_id')
                                                        ->take(3)->pluck('establishment')
                                                        ->implode(', ') . 
                                                        ($item->health_certificates->count() > 3 ? ', etc.' : '')
				    		]); 
				    	})
				   	]);
    }
}
