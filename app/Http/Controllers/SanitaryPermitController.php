<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Applicant;
use App\SanitaryPermit;
use App\Custom\PermitFileGenerator;
use App\Custom\RegistrationNumberGenerator;

class SanitaryPermitController extends Controller
{
    protected $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function createSanitaryPermit()
	{
		if($this->request->isMethod('get'))
    	{
    		return view('sanitary_permit.create', [
                'title' => 'New Sanitary Permit'
            ]);
    	}

    	elseif($this->request->isMethod('post'))
    	{
            $id = $this->create_edit_logic(true);

            return redirect("sanitary_permit/$id/preview");
    	}
	}

	public function createSanitaryPermitExistingApplicant(Applicant $applicant)
	{
		if($this->request->isMethod('get'))
    	{
    		return view('sanitary_permit.existing_applicant_create', [
                'title' => 'Add Sanitary Permit',
                'applicant' => $applicant
            ]);
    	}

    	elseif($this->request->isMethod('post'))
    	{
            $id = $this->create_edit_logic(true, $applicant);

            return redirect("sanitary_permit/$id/preview");
    	}
	}

	/*public function sanitaryPermits(Applicant $applicant)
	{
		return view('sanitary_permit.permits_list', [
			'title' => "Client's Sanitary Permits",
			'applicant' => $applicant,
			'sanitary_permits' => $applicant->sanitary_permits
		]);
	}*/

	public function viewEditSanitaryPermit(SanitaryPermit $sanitary_permit)
	{
		if($this->request->isMethod('get'))
    	{
    		return view('sanitary_permit.edit', [
                'title' => 'Update/Renew Sanitary Permit',
                'applicant' => $sanitary_permit->applicant,
                'permit' => $sanitary_permit
            ]);
    	}

    	elseif($this->request->isMethod('put'))
    	{
            $this->create_edit_logic(false, $sanitary_permit->applicant, $sanitary_permit);

            return redirect("sanitary_permit/$sanitary_permit->sanitary_permit_id/preview");
    	}
	}

	public function printPreview(SanitaryPermit $sanitary_permit)
	{
		return view('sanitary_permit.print', [
            'logo' => '/laoag_logo.png',
            'permit' => $sanitary_permit
        ]);
	}

	private function create_edit_logic($is_create, Applicant $applicant = null, SanitaryPermit $sanitary_permit = null)
	{
		if($is_create)
		{
			if($applicant != null)
				$rules = [
					'date_of_issuance' => 'bail|required|date|before_or_equal:today',
				];

			else
				$rules = [
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
			if($this->request->update_mode != null && $this->request->update_mode == 'edit_renew')
                $date_of_issuance_rule = "bail|required|date|before_or_equal:today|after:{$sanitary_permit->dateToInput('issuance_date')}";
            else
                $date_of_issuance_rule = 'bail|required|date|before_or_equal:today';

            $rules = [
                'update_mode' => 'bail|required|in:edit,edit_renew',
                'date_of_issuance' => $date_of_issuance_rule
            ];
		}

		Validator::make($this->request->all(), array_merge($rules, [
			'permit_type' => 'bail|required|in:individual,business',
			'establishment_type' => 'bail|required|string|max:100',
			'date_of_expiration' => 'bail|required|date|after:date_of_issuance',
			'address' => 'bail|required|string|max:150',
			'sanitary_inspector' => 'bail|required|string|alpha_spaces|max:100'
		]))->validate();

		if($is_create)
		{
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

			$sanitary_permit = new SanitaryPermit;
			$sanitary_permit->applicant_id = $applicant->applicant_id;
			$sanitary_permit->establishment_type = $this->request->establishment_type;
			$sanitary_permit->address = $this->request->address;
			$sanitary_permit->issuance_date = $this->request->date_of_issuance;
			$sanitary_permit->expiration_date = $this->request->date_of_expiration;
			$sanitary_permit->sanitary_inspector = $this->request->sanitary_inspector;
			$sanitary_permit->is_expired = false;
            $sanitary_permit->sanitary_permit_number = (new RegistrationNumberGenerator)->getRegistrationNumber('App\SanitaryPermit', 'sanitary_permit_number');
			$sanitary_permit->save();
		}

		else
		{
			$sanitary_permit->establishment_type = $this->request->establishment_type;
			$sanitary_permit->address = $this->request->address;
			$sanitary_permit->issuance_date = $this->request->date_of_issuance;
			$sanitary_permit->expiration_date = $this->request->date_of_expiration;
			$sanitary_permit->sanitary_inspector = $this->request->sanitary_inspector;
			$sanitary_permit->save();

			$sanitary_permit->checkIfExpired();
		}

		if($is_create)
        {
	    	//(new PermitFileGenerator($sanitary_permit))->generatePDF();
	    	return $sanitary_permit->sanitary_permit_id;
        }

        /*else
        	(new PermitFileGenerator($sanitary_permit))->updatePDF();*/
	}
}
