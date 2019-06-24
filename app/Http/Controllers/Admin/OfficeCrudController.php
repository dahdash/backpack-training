<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\OfficeRequest as StoreRequest;
use App\Http\Requests\OfficeRequest as UpdateRequest;

use Backpack\CRUD\CrudPanel;
use PragmaRX\Countries\Package\Countries;
use App\Notifications\OfficeCreated;


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
        $this->crud->denyAccess('delete');



        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */
        //add custom button
        $this->crud->addButtonFromView('line', 'officeSuppliers', 'officeSuppliers', 'beginning');

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
        $newOffice = $this->data['entry'];
        auth()->user()->notify(new OfficeCreated($newOffice));

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

    public function  getOfficeSuppliers($id)
    {
        $this->crud->hasAccessOrFail('update');
        $this->crud->setOperation('OfficeSuppliers');
        $this->crud->settitle('Supllier for choosen office');
        $this->crud->setSubheading('Suplliers');
        $this->crud->setHeading('');

        // get entry ID from Request (makes sure its the last ID for nested resources)
        $id = $this->crud->getCurrentEntryId() ?? $id;
        /*
        |--------------------------------------------------------------------------
        | Office Suppliers fields
        |--------------------------------------------------------------------------
        */
        $this->crud->removeField('name');
        $this->crud->removeField('country');
        $this->crud->removeField('city');
        $this->crud->removeField('address');
        $this->crud->removeField('phone');
        $this->crud->addField(
          [
            'label' => "Suppliers",
            'type' => 'select2_multiple',
            'name' => 'suppliers', // the method that defines the relationship in your Model
            'entity' => 'suppliers', // the method that defines the relationship in your Model
            'attribute' => 'name', // foreign key attribute that is shown to user
            'model' => "App\Models\supplier", // foreign key model
            'pivot' => true, // on create&update, do you need to add/delete pivot table entries?
            // 'select_all' => true, // show Select All and Clear buttons?

           // optional
           'options'   => (function ($query) {
                return $query->orderBy('name', 'ASC')->get();
            }), // force the related options to be a custom query, instead of all(); you can use this to filter the results show in the select
          ]);

        // get the info for that entry

        $this->data['entry'] = $this->crud->getEntry($id);
        $this->data['column'] = $this->crud->getEntry($id);
        $this->data['crud'] = $this->crud;
        $this->data['saveAction'] = $this->getSaveAction();
        $this->data['fields'] = $this->crud->getUpdateFields($id);
        $this->data['title'] = $this->crud->getTitle() ?? trans('backpack::crud.edit').' '.$this->crud->entity_name;

        $this->data['id'] = $id;
        return view('vendor.backpack.crud.officeSuppliers', $this->data);
    }

    public function  postOfficeSuppliers(UpdateRequest $request,$id)
    {
      $this->crud->hasAccessOrFail('update');
      $this->data['entry'] = $this->crud->getEntry($id);



      $this->data['entry']->suppliers()->sync($request->suppliers);

      \Alert::success('Suppliers added.')->flash();
      $this->setSaveAction();

      return \Redirect::to($this->crud->route);
  }
}
