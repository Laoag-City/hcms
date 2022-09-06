<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Applicant;
use App\Business;
use App\SanitaryPermit;
use App\Custom\PermitFileGenerator;
use App\Custom\RegistrationNumberGenerator;
use App\Custom\BrgyTrait;

class SanitaryPermitController extends Controller
{
	use BrgyTrait;

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
                'title' => 'Add Sanitary Permit Form'
            ]);
    	}

    	elseif($this->request->isMethod('post'))
    	{
            $id = $this->create_edit_logic('add');

            return redirect("sanitary_permit/$id/preview");
    	}
	}

	public function renewPermit()
    {
        $searches = null;
        $sanitary_permit = null;

        if($this->request->search)
        {
        	$applicants = Applicant::search($this->request->search)
                                    ->with('sanitary_permits')
                                    ->get();

            $businesses = Business::search($this->request->search)
                                    ->with('sanitary_permits')
                                    ->get();

            $searches = $applicants->concat($businesses);

            //if id is present in the request and in the searches
            if($this->request->id && $searches->pluck('sanitary_permits')->flatten()->where('sanitary_permit_id', $this->request->id)->isNotEmpty())
	        {
	            Validator::make($this->request->all(), [
	                'id' => 'bail|required|exists:sanitary_permits,sanitary_permit_id'
	            ])->validate();

	            $sanitary_permit = SanitaryPermit::find($this->request->id);
	        }
        }

        if($this->request->isMethod('get'))
        {
            return view('sanitary_permit.renew', [
                'title' => "Renew A Sanitary Permit",
                'searches' => $searches,
                'sanitary_permit' => $sanitary_permit,
            ]);
        }

        elseif($this->request->isMethod('put'))
        {
            $id = $this->create_edit_logic('renew', $sanitary_permit);

            return redirect("sanitary_permit/{$id}/preview");
        }
    }

    public function SanitaryPermitsList()
    {
    	$sanitary_permits = [];

    	if($this->request->brgy)
	    	$sanitary_permits= SanitaryPermit::where('brgy', $this->request->brgy)->paginate(150);

    	return view('sanitary_permit.permits_list', [
			'title' => "Sanitary Permits List",
			'sanitary_permits' => $sanitary_permits
		]);
    }

	/*public function createSanitaryPermitExistingApplicantBusiness()
	{
		if($this->request->isMethod('get'))
    	{
    		return view('sanitary_permit.existing_applicant_create', [
                'title' => 'Add Sanitary Permit To Existing Client/Business',
            ]);
    	}

    	elseif($this->request->isMethod('post'))
    	{
            $id = $this->create_edit_logic('add');

            return redirect("sanitary_permit/$id/preview");
    	}
	}*/

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
                'title' => 'Sanitary Permit Information',
                'applicant' => $sanitary_permit->applicant,
                'permit' => $sanitary_permit
            ]);
    	}

    	elseif($this->request->isMethod('put'))
    	{
            $this->create_edit_logic('edit', $sanitary_permit);

            return redirect("sanitary_permit/$sanitary_permit->sanitary_permit_id/preview");
    	}
	}

	public function deletePermit(SanitaryPermit $sanitary_permit)
    {
        $validator = Validator::make($this->request->all(), [
            'password' => 'bail|required'
        ]);

        $validator->after(function ($validator){
            if(!app('hash')->check($this->request->password, $this->request->user()->password))
                $validator->errors()->add('password', 'Incorrect password.');
        });

        $validator->validate();

        $sanitary_permit->delete();
        return redirect(explode('?', url()->previous())[0]);
    }

	public function printPreview(SanitaryPermit $sanitary_permit)
	{
		return view('sanitary_permit.print', [
            'logo' => '/laoag_logo.png',
            'permit' => $sanitary_permit
        ]);
	}

	private function create_edit_logic($mode, SanitaryPermit $sanitary_permit = null)
	{
		if($mode == 'add')
		{
			$permit_owner_rules = [
				'business_name' => 'bail|required_if:permit_owner_type,business|max:100',

				'first_name' => 'bail|required_if:permit_owner_type,individual|alpha_spaces|max:40',
	            'middle_name' => 'nullable|bail|alpha_spaces|max:30',
	            'last_name' => 'bail|required_if:permit_owner_type,individual|alpha_spaces|max:30',
	            'suffix_name' => 'nullable|bail|in:Jr.,Sr.,I,II,III,IV,V,VI,VII,VIII,IX,X',
	            'age' => 'bail|required_if:permit_owner_type,individual|integer|min:0|max:120',
	            'gender' => 'bail|required_if:permit_owner_type,individual|in:0,1',
			];

			$specific_rules = [
				'permit_owner_type' => 'bail|required|in:individual,business',
				'has_existing_registered_name' => 'bail|sometimes|required|in:on',
				'date_of_issuance' => 'bail|required|date|before_or_equal:today',
			];

			if($this->request->has_existing_registered_name != null)
			{
				$exist_rule = '';

				if($this->request->permit_owner_type == 'individual')
					$exist_rule = '|exists:applicants,applicant_id';

				elseif($this->request->permit_owner_type == 'business')
					$exist_rule = '|exists:businesses,business_id';

				$add_rules = [
					'existing_registered_name' => 'bail|required|max:107',
					'id' => 'bail|required' . $exist_rule,
				];

				$specific_rules = array_merge($specific_rules, $add_rules);
			}
		}

		else
		{
			//if else block here are rules when changing permit owner type
			if($sanitary_permit->applicant_id != null)
			{
				$permit_owner_rules = [
					'business_name' => 'bail|nullable|required_with:permit_owner_type|max:100',
				];

            	$in_rule = 'business';
			}

            else
            {
            	$permit_owner_rules = [
					'first_name' => 'bail|nullable|required_with:permit_owner_type|alpha_spaces|max:40',
            		'middle_name' => 'nullable|bail|alpha_spaces|max:30',
            		'last_name' => 'bail|nullable|required_with:permit_owner_type|alpha_spaces|max:30',
            		'suffix_name' => 'nullable|bail|in:Jr.,Sr.,I,II,III,IV,V,VI,VII,VIII,IX,X',
            		'age' => 'bail|nullable|required_if:permit_owner_type,individual|integer|min:0|max:120',
            		'gender' => 'bail|nullable|required_with:permit_owner_type|in:0,1',
				];

            	$in_rule = 'individual';
            }

			if($mode == 'renew')
			{
                $specific_rules = [
            		'permit_owner_type' => 'bail|sometimes|in:' . $in_rule,
                	'date_of_issuance' => "bail|required|date|before_or_equal:today|after:{$sanitary_permit->dateToInput('issuance_date')}"
            	];
			}

            else
            {
                $specific_rules = [
            		'permit_owner_type' => 'bail|sometimes|in:' . $in_rule,
                	'update_mode' => 'bail|required|accepted',
                	'date_of_issuance' => 'bail|required|date|before_or_equal:today'
            	];
            }
		}

		Validator::make($this->request->all(), array_merge($specific_rules, $permit_owner_rules, [
			'establishment_type' => 'bail|required|string|max:100',
			'date_of_expiration' => 'bail|required|date|after:date_of_issuance',
			'total_employees' => 'bail|required|integer|min:0',
			'permit_classification' => 'bail|required|in:'  . implode(',', SanitaryPermit::PERMIT_CLASSIFICATIONS),
			'brgy' => 'bail|required|in:' . implode(',', $this->brgys),
			'street' => 'bail|nullable|string|max:150',
			'sanitary_inspector' => 'bail|required|string|alpha_spaces|max:100'
		]))->validate();

		if($mode == 'add')
		{
			if($this->request->id == null)
			{
				if($this->request->permit_owner_type == 'individual')
				{
					$permit_holder = new Applicant;
		            $permit_holder->first_name = $this->request->first_name;
		            $permit_holder->middle_name = $this->request->middle_name == null ? null : $this->request->middle_name;
		            $permit_holder->last_name = $this->request->last_name;
		            $permit_holder->suffix_name = $this->request->suffix_name == null ? null : $this->request->suffix_name;
		            $permit_holder->age = $this->request->age;
		            $permit_holder->gender = $this->request->gender;
		            $permit_holder->save();
	        	}

	        	else
	        	{
	        		$permit_holder = new Business;
	        		$permit_holder->business_name = $this->request->business_name;
	        		$permit_holder->save();
	        	}
			}

			else
			{
				if($this->request->permit_owner_type == 'individual')
				{
					$permit_holder = Applicant::find($this->request->id);
					$permit_holder->age = $this->request->age;
					$permit_holder->save();
				}

				else
					$permit_holder = Business::find($this->request->id);
			}

			$sanitary_permit = new SanitaryPermit;

			if($permit_holder instanceof Applicant)
				$sanitary_permit->applicant_id = $permit_holder->applicant_id;

			else
				$sanitary_permit->business_id = $permit_holder->business_id;

			$sanitary_permit->establishment_type = $this->request->establishment_type;
			$sanitary_permit->total_employees = $this->request->total_employees;
			$sanitary_permit->permit_classification = $this->request->permit_classification;
			$sanitary_permit->brgy = $this->request->brgy;
			$sanitary_permit->street = $this->request->street;
			$sanitary_permit->issuance_date = $this->request->date_of_issuance;
			$sanitary_permit->expiration_date = $this->request->date_of_expiration;
			$sanitary_permit->sanitary_inspector = $this->request->sanitary_inspector;
			$sanitary_permit->is_expired = false;
            $sanitary_permit->sanitary_permit_number = (new RegistrationNumberGenerator)->getRegistrationNumber('App\SanitaryPermit', 'sanitary_permit_number');
			$sanitary_permit->save();
		}

		else
		{
			//if changing permit owner type
			if($this->request->permit_owner_type != null)
			{
				if($this->request->permit_owner_type == 'individual')
				{
					$permit_holder = new Applicant;
		            $permit_holder->first_name = $this->request->first_name;
		            $permit_holder->middle_name = $this->request->middle_name == null ? null : $this->request->middle_name;
		            $permit_holder->last_name = $this->request->last_name;
		            $permit_holder->suffix_name = $this->request->suffix_name == null ? null : $this->request->suffix_name;
		            $permit_holder->age = $this->request->age;
		            $permit_holder->gender = $this->request->gender;
		            $permit_holder->save();

		            $sanitary_permit->applicant_id = $permit_holder->applicant_id;
		            $sanitary_permit->business_id = null;
	        	}

	        	else
	        	{
	        		$permit_holder = new Business;
	        		$permit_holder->business_name = $this->request->business_name;
	        		$permit_holder->save();

	        		$sanitary_permit->applicant_id = null;
	        		$sanitary_permit->business_id = $permit_holder->business_id;
	        	}
			}

			$sanitary_permit->establishment_type = $this->request->establishment_type;
			$sanitary_permit->total_employees = $this->request->total_employees;
			$sanitary_permit->permit_classification = $this->request->permit_classification;
			$sanitary_permit->brgy = $this->request->brgy;
			$sanitary_permit->street = $this->request->street;
			$sanitary_permit->issuance_date = $this->request->date_of_issuance;
			$sanitary_permit->expiration_date = $this->request->date_of_expiration;
			$sanitary_permit->sanitary_inspector = $this->request->sanitary_inspector;

			//if renewing and it's already next year, update sanitary permit number
            if($mode == 'renew')
            {   
                if((int)explode('-', $sanitary_permit->sanitary_permit_number)[0] < (int)date('Y', strtotime('now')))
                    $sanitary_permit->sanitary_permit_number = (new RegistrationNumberGenerator)->getRegistrationNumber('App\SanitaryPermit', 'sanitary_permit_number');
            }

			$sanitary_permit->save();

			$sanitary_permit->checkIfExpired();
		}

		if($mode != 'edit')
        {
	    	//(new PermitFileGenerator($sanitary_permit))->generatePDF();
	    	return $sanitary_permit->sanitary_permit_id;
        }

        /*else
        	(new PermitFileGenerator($sanitary_permit))->updatePDF();*/
	}
}
