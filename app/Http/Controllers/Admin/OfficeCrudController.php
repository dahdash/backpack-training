<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\OfficeRequest as StoreRequest;
use App\Http\Requests\OfficeRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

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

        // TODO $this->crud->addField();
        $this->crud->addField([
          'name' => 'name',
          'type' => 'text',
          'label' => 'Office Name',
        ]);
        $this->crud->addField([
          'label' => 'Country',
          'type' => 'select',
          'name' => 'Country',
          'entity' => 'country',
          'attribute' => 'name'
        ]);
        /*
        $this->crud->addField([    // SELECT2
            'label'         => ‘Category',
            'type'          => 'select',
            'name'          => ‘category',
            'entity'        => 'category',
            'attribute'     => 'name',
        ]);

        $this->crud->addField([ // select2_from_ajax: 1-n relationship
            'label'                => "Article", // Table column heading
            'type'                 => 'select2_from_ajax_multiple',
            'name'                 => ‘articles', // the column that contains the ID of that connected entity;
            'entity'               => 'article', // the method that defines the relationship in your Model
            'attribute'            => 'title', // foreign key attribute that is shown to user
            'data_source'          => url('api/article'), // url to controller search function (with /{id} should return model)
            'placeholder'          => 'Select an article', // placeholder for the select
            'minimum_input_length' => 0, // minimum characters to type before querying results
            'dependencies'         => [‘category’], // when a dependency changes, this select2 is reset to null
            // ‘method'                    => ‘GET’, // optional - HTTP method to use for the AJAX call (GET, POST)
        ]);
        */


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
