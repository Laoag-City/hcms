<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Applicant;
use App\SanitaryPermit;

class SanitaryPermitController extends Controller
{
    protected $request;

	public function __construct(Request $request)
	{
		$this->request = $request;
	}

	public function createSanitaryPermit(Applicant $applicant)
	{
		if($this->request->isMethod('get'))
    	{
    		return view('sanitary_permit.create', [
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

	public function sanitaryPermits(Applicant $applicant)
	{
		return view('sanitary_permit.permits_list', [
			'title' => "Client's Sanitary Permits",
			'applicant' => $applicant,
			'sanitary_permits' => $applicant->sanitary_permits
		]);
	}

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

	public function bulkPrintPreview()
	{
		
	}

	private function create_edit_logic($is_create, Applicant $applicant, SanitaryPermit $sanitary_permit = null)
	{
		if($is_create)
			$rules = [
				'date_of_issuance' => 'bail|required|date|before_or_equal:today',
			];

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
			'establishment_type' => 'bail|required|string|alpha_spaces|max:100',
			'date_of_expiration' => 'bail|required|date|after:date_of_issuance',
			'address' => 'bail|required|string|max:150',
			'sanitary_inspector' => 'bail|required|string|alpha_spaces|max:100'
		]))->validate();

		if($is_create)
		{
			$sanitary_permit = new SanitaryPermit;
			$sanitary_permit->applicant_id = $applicant->applicant_id;
			$sanitary_permit->establishment_type = $this->request->establishment_type;
			$sanitary_permit->address = $this->request->address;
			$sanitary_permit->issuance_date = $this->request->date_of_issuance;
			$sanitary_permit->expiration_date = $this->request->date_of_expiration;
			$sanitary_permit->sanitary_inspector = $this->request->sanitary_inspector;
			$sanitary_permit->is_expired = false;

			$year_now = date('Y', strtotime('now'));
            $total_registrations_this_year = SanitaryPermit::where('sanitary_permit_number', 'like', "$year_now%")->count();
            $registration_number = "$year_now-" . sprintf('%05d', $total_registrations_this_year + 1);

            $sanitary_permit->sanitary_permit_number = $registration_number;
			$sanitary_permit->save();

			return $sanitary_permit->sanitary_permit_id;
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
	}
}
