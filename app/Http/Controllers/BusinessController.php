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
}
