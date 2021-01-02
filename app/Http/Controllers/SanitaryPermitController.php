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

	public function createSanitaryPermit()
	{
		
	}

	public function viewEditSanitaryPermit(SanitaryPermit $sanitary_permit)
	{
		
	}

	public function printPreview(SanitaryPermit $sanitary_permit)
	{
		
	}

	public function bulkPrintPreview()
	{
		
	}

	private function create_edit_logic($is_create, SanitaryPermit $sanitary_permit = null)
	{
		
	}
}
