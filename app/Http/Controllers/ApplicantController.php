<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Applicant;
use App\HealthCertificate;
use App\Custom\CertificateFileGenerator;
use App\Custom\PermitFileGenerator;
use Validator;

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
    		'applicants' => Applicant::with('health_certificates')->orderBy('updated_at', 'asc')->paginate(150)
    	]);
	}

	public function viewEditApplicant(Applicant $applicant)
	{
		if($this->request->isMethod('get'))
    	{
    		return view('applicant.view_edit', [
    			'title' => $applicant->formatName(),
    			'applicant' => $applicant,
                'health_certificates' => $applicant->health_certificates,
                'sanitary_permits' => $applicant->sanitary_permits,
                'picture_url' => $applicant->health_certificates ? (new CertificateFileGenerator($applicant->health_certificates->first()))->getPicturePathAndURL()['url'] : null
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
    		]);

            if($applicant->health_certificates != null)
            {
                $old_certificate_file_generator = new CertificateFileGenerator($applicant->health_certificates->first());
                $old_applicant_certificate_folder = $old_certificate_file_generator->getHealthCertificateFolder()['applicant_folder'];
            }

            if($applicant->sanitary_permits->isNotEmpty())
            {
                $old_permit_file_generator = new PermitFileGenerator($applicant->sanitary_permits->first());
                $old_applicant_permit_folder = $old_permit_file_generator->getSanitaryPermitFolder()['applicant_folder'];
            }

    		$applicant->first_name = $this->request->first_name;
    		$applicant->middle_name = $this->request->middle_name == null ? null : $this->request->middle_name;
    		$applicant->last_name = $this->request->last_name;
    		$applicant->suffix_name = $this->request->suffix_name == null ? null : $this->request->suffix_name;
    		$applicant->age = $this->request->age;
    		$applicant->gender = $this->request->gender;
    		$applicant->save();

            if($applicant->health_certificates != null)
            {
                $new_certificate_file_generator = new CertificateFileGenerator($applicant->health_certificates->first()->refresh());
                $new_applicant_certificate_folder = $new_certificate_file_generator->getHealthCertificateFolder()['applicant_folder'];

                if($old_applicant_certificate_folder != $new_applicant_certificate_folder)
                    $new_certificate_file_generator->updateApplicantFolder($old_applicant_certificate_folder);
            }

            if($applicant->sanitary_permits->isNotEmpty())
            {
                $new_permit_file_generator = new PermitFileGenerator($applicant->sanitary_permits->first()->refresh());
                $new_applicant_permit_folder = $new_permit_file_generator->getSanitaryPermitFolder()['applicant_folder'];

                if($old_applicant_permit_folder != $new_applicant_permit_folder)
                    $new_permit_file_generator->updateApplicantFolder($old_applicant_permit_folder);
            }

    		return back()->with('success', ['header' => 'Applicant updated successfully!', 'message' => null]);
    	}
	}

    /*Commented out because end users do not need it yet. If they'll need it, update its logic because it is outdated
    public function bulkPrintCertificates()
    {
        if($this->request->isMethod('get'))
        {
            return view('applicant.bulk_print', [
                'title' => 'Bulk Print Health Certificates'
            ]);
        }

        elseif($this->request->isMethod('post'))
        {
            Validator::make($this->request->all(), [
                'ids' => 'required|array',
                'ids.*' => 'distinct|exists:applicants,applicant_id'
            ])->validate();

            $this->request->session()->flash('print_ids', $this->request->ids);

            return redirect('health_certificate/bulk_print_preview');
        }
    }
    */

    public function searchApplicantsForHealthCertificate()
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

    public function searchApplicants()
    {
    	return view('applicant.search', [
            'title' => 'Search Results',
            'keyword' => $this->request->q,
            'applicants' => Applicant::search($this->request->q)->paginate(150)
        ]);
    }
}
