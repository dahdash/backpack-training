<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PragmaRX\Countries\Package\Countries;


class CountriesPackageTinkerController extends Controller
{
    public function index()
    {
      dd(Countries::all()->where('geo.region', 'Europe'));
    }
}
