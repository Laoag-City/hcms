<?php

namespace App\Http\Controllers;

use Validator;
use App\Business;
use Illuminate\Http\Request;

class BusinessController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getBusinesses()
    {
        return view('business.index', [
            'title' => 'Businesses',
            'businesses' => Business::orderBy('updated_at', 'desc')->paginate(150)
        ]);
    }

    public function searchBusinessesForPermitForm()
    {
        return collect(['results' => Business::search($this->request->q)
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
}
