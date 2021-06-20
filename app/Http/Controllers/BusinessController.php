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
                        ->with('sanitary_permits')
                        ->get()
                        ->transform(function($item, $key){
                            return collect([
                                'id' => $item->business_id,
                                'whole_name' => $item->business_name, 
                                'basic_info' => $item->sanitary_permits->sortByDesc('sanitary_permit_id')
                                                        ->take(3)->pluck('establishment_type')
                                                        ->implode(', ') . 
                                                        ($item->sanitary_permits->count() > 3 ? ', etc.' : '')
                            ]); 
                        })
                    ]);
    }
}
