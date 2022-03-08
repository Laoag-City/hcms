<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Applicant;
use App\Business;
use App\HealthCertificate;
use App\SanitaryPermit;
use Illuminate\Validation\Rule;

class SearchController extends Controller
{
    protected $request;   

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function viewSearches()
    {
        $this->validate($this->request, [
            'q' => 'required',
            'c' => [
                'required',
                Rule::in('Client Name', 'Business Name', 'HC Reg. No.', 'SP Number', 'Work Type', 'Establ. Name (HC)', 'Establ. Type (SP)')
            ]
        ]);

        $results = null;

        switch($this->request->c)
        {
            case 'Client Name':
                $results = Applicant::search($this->request->q);
                break;
            case 'Business Name':
                $results = Business::search($this->request->q);
                break;
            case 'HC Reg. No.':
                $results = HealthCertificate::search($this->request->q, ['registration_number'])->with(['applicant']);
                break;
            case 'SP Number':
                $results = SanitaryPermit::search($this->request->q, ['sanitary_permit_number'])->with(['applicant', 'business']);
                break;
            case 'Work Type':
                $results = HealthCertificate::search($this->request->q, ['work_type'])->with(['applicant']);
                break;
            case 'Establ. Name (HC)':
                $results = HealthCertificate::search($this->request->q, ['establishment'])->with(['applicant']);
                break;
            case 'Establ. Type (SP)':
                $results = SanitaryPermit::search($this->request->q, ['establishment_type'])->with(['applicant', 'business']);
                break;
        }

        return view('search.index', [
            'title' => 'Search Results',
            'keyword' => $this->request->q,
            'criteria' => $this->request->c,
            'results' => $results->paginate(150)
        ]);
    }
}
