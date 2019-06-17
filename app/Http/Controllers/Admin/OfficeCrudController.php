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
        ]);

        $this->crud->addField(
          [   // select_from_array
            'name' => 'country',
            'label' => "Country",
            'type' => 'select2_from_array',
            'options' => Countries::all()->pluck('name.common'),
            'allows_null' => false,
            // 'allows_multiple' => true, // OPTIONAL; needs you to cast this to array in your model;
          ]);

        // add asterisk for fields that are required in OfficeRequest
        $this->crud->setRequiredFields(StoreRequest::class, 'create');
        $this->crud->setRequiredFields(UpdateRequest::class, 'edit');
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
