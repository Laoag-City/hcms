<?php

namespace App\Http\Controllers;

use Validator;
use App\Business;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Log as ActivityLog;

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

    public function viewEditBusiness(Business $business)
    {
        if($this->request->isMethod('get'))
        {
            return view('business.view_edit', [
                'title' => $business->business_name,
                'business' => $business,
                'sanitary_permits' => $business->sanitary_permits,
            ]);
        }

        elseif($this->request->isMethod('put'))
        {
            $this->validate($this->request, [
                'business_name' => 'bail|required_if:permit_type,business|alpha_spaces|max:100',
            ]);

            $business->business_name = $this->request->business_name;
            $business->save();

            $log = new ActivityLog;
            $log->user_id = Auth::user()->user_id;
            $log->loggable_id = $business->business_id;
            $log->loggable_type = get_class($business);
            $log->description = "Updated business's info";
            $log->save();

            return back()->with('success', ['header' => 'Business updated successfully!', 'message' => null]);
        }
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
