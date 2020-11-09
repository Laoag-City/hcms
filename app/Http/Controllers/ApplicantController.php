<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Applicant;
use App\HealthCertificate;

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
    		'title' => 'Health Certificates',
    		'applicants' => Applicant::orderBy('last_name', 'asc')->paginate(100)
    	]);
	}

    public function showPicture(Applicant $applicant)
    {
        return response()->file(storage_path("app/public/{$applicant->picture}"), ['Cache-Control' => 'No-Store']);
    }

	public function viewEditApplicant(Applicant $applicant)
	{
		if($this->request->isMethod('get'))
    	{
    		return view('applicant.view_edit', [
    			'title' => $applicant->formatName(),
    			'applicant' => $applicant,
    			'health_certificates' => HealthCertificate::where('applicant_id', '=', $applicant->applicant_id)
                                                            ->orderBy('created_at', 'desc')
                                                            ->paginate(50)
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

    		$applicant->first_name = $this->request->first_name;
    		$applicant->middle_name = $this->request->middle_name;
    		$applicant->last_name = $this->request->last_name;
    		$applicant->suffix_name = $this->request->suffix_name;
    		$applicant->age = $this->request->age;
    		$applicant->gender = $this->request->gender;
    		$applicant->save();

    		return back()->with('success', ['header' => 'Applicant updated successfully!', 'message' => null]);
    	}
	}

    public function searchApplicantsForHealthCertificate()
    {
    	return collect(['results' => Applicant::search($this->request->q)
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
				    						'basic_info' => "{$item->getGender()} / $item->age yrs. old"
				    				]); 
				    	})
				   	]);
    }

    public function searchApplicants()
    {
    	return view('applicant.search', [
            'title' => 'Search Results',
            'keyword' => $this->request->q,
            'applicants' => Applicant::search($this->request->q)->paginate(50)
        ]);
    }
}
