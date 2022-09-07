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

class PinkHealthCertificateController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
