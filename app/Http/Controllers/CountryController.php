<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::select('id', 'name')->get();
        
        return response()->json(['countries' => $countries]);
    }

    public function countryStates(Country $country)
    {
        return response()->json(['states' => $country->states]);
    }


}
