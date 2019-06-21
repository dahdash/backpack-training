<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\OfficeRequest as StoreRequest;
use App\Http\Requests\OfficeRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;
use PragmaRX\Countries\Package\Countries;

/**
 * Class OfficeCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class OfficeCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Office');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/office');
        $this->crud->setEntityNameStrings('office', 'offices');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        // Fields and Columns
        $this->crud->setColumns(['name', 'country', 'city', 'address', 'phone']);

        // Fields
        $this->crud->addField([
          'name' => 'name',
          'label' => 'Office Name',
          'type' => 'text',
          'attributes' => [
             'placeholder' => 'Office Name',
             'required' => 'required'
           ]
        ]);

        $countryOptions = Countries::all()->where('geo.region', 'Europe')->pluck('name.common');
        $associativeCountryOptionsArray = $countryOptions->combine($countryOptions)->toArray();
        $associativeCountryOptionsArray = ['' => '--choose a country--'] + $associativeCountryOptionsArray;
        $this->crud->addField(
          [   // select_from_array_ajax
            'name' => 'country',
            'label' => "Country",
            'type' => 'select2_from_array_ajax',
            'options' => $associativeCountryOptionsArray,
            'allows_null' => false,
            'dependant_field' => 'city',
            'attributes' => ['required' => 'required']

            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
          ]);


        $this->crud->addField(
          [   // select_from_array
            'name' => 'city',
            'label' => "City",
            'type' => 'select2_from_array',
            'options' => ['' => '--no country selected--'],
            'allows_null' => false,
            'attributes' => ['required' => 'required']
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
          ]);

        $this->crud->addField(
          [ // Textarea
              'name' => 'address',
              'label' => "Address",
              'type' => 'textarea',

              // optional
              'attributes' => [
                 'placeholder' => 'Address',
                 'style' => 'resize: none;',
                 'required' => 'required'
               ]
          ]);

        $this->crud->addField(
          [   // Number
            'name' => 'phone',
            'label' => 'Phone Number',
            'type' => 'number',
            // optionals
            'attributes' => [
              // "step" => "any",
              'placeholder' => '123456789',
              'required' => 'required',
            ], // allow decimals
            // 'prefix' => "$",
            // 'suffix' => ".00",
          ]);

        // add asterisk for fields that are required in OfficeRequest
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
    }

    public function store(StoreRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::storeCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }

    public function update(UpdateRequest $request)
    {
        // your additional operations before save here
        $redirect_location = parent::updateCrud($request);
        // your additional operations after save here
        // use $this->data['entry'] or $this->crud->entry
        return $redirect_location;
    }
}
