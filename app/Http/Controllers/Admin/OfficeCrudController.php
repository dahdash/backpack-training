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
        //add custom button
        $this->crud->addButtonFromView('line', 'officeSuppliers', 'officeSuppliers', 'beginning');

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

    public function  getOfficeSuppliers($id)
    {
        $this->crud->hasAccessOrFail('update');
        $this->crud->setOperation('OfficeSuppliers');
        $this->crud->settitle('Supllier for choosen office');
        $this->crud->setOperation('show');
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

      // fallback to global request instance
      if (is_null($request)) {
          $request = \Request::instance();
      }

      $this->data['entry']->suppliers()->sync($request->suppliers);

      \Alert::success('Suppliers added.')->flash();
      $this->setSaveAction();

      return \Redirect::to($this->crud->route);
  }
}
