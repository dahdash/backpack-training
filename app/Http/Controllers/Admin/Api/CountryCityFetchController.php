<?php

namespace App\Http\Controllers\Admin\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use PragmaRX\Countries\Package\Countries;

class CountryCityFetchController extends Controller
{
  // fetching cities of a Country
  public function fetch(Request $request)
  {
    $country = $request->get('selectedOption');

    $cities = Countries::where('name.common', $country)->first()
    ->hydrateCities()->cities->sortBy('name')->pluck('name')
    ->transform(function ($cityName, $key) { return utf8_decode($cityName); })
    ->toArray();

    $cityOptions = '';

    foreach ($cities as $city) {
      $cityOptions .= '<option value="'.$city.'">'.$city.'</option>';
    }

    return $cityOptions;

  }
}
