<?php

namespace App\Http\Controllers\Admin;

use Backpack\CRUD\app\Http\Controllers\CrudController;

// VALIDATION: change the requests to match your own file names if you need form validation
use App\Http\Requests\AccountRequest as StoreRequest;
use App\Http\Requests\AccountRequest as UpdateRequest;
use Backpack\CRUD\CrudPanel;

/**
 * Class AccountCrudController
 * @package App\Http\Controllers\Admin
 * @property-read CrudPanel $crud
 */
class AccountCrudController extends CrudController
{
    public function setup()
    {
        /*
        |--------------------------------------------------------------------------
        | CrudPanel Basic Information
        |--------------------------------------------------------------------------
        */
        $this->crud->setModel('App\Models\Account');
        $this->crud->setRoute(config('backpack.base.route_prefix') . '/account');
        $this->crud->setEntityNameStrings('account', 'accounts');

        /*
        |--------------------------------------------------------------------------
        | CrudPanel Configuration
        |--------------------------------------------------------------------------
        */

        //Columns

        $this->crud->addColumn([
                'label' => 'Office Name',
                'type' => 'select',
                'name' => 'office_id',
                'entity' => 'office',
                'attribute' => "name",
                'model' => "App\Models\Account",
        ]);


        $this->crud->addcolumns([

            [
                'label' => 'Account Name',
                'name' => 'name',
                'type' => 'text',
            ],

            [
                'label' => 'Opening Balance',
                'name' => 'opening_balance',
                'type' => 'number',
                'decimals' => 2,
            ],

            [
                'label' => 'Bank Name',
                'name' => 'bank_name',
                'type' => 'text',
                'visibleInTable' => false,
            ],

            [
                'label' => 'Bank Phone',
                'name' => 'bank_phone',
                'type' => 'number',
                'visibleInTable' => false,
            ],

            [
                'label' => 'Bank Address',
                'name' => 'bank_address',
                'type' => 'text',
                'visibleInTable' => false,
            ],

            [
                'label' => 'Status',
                'name' => 'enabled',
                'type' => 'check'
            ]


        ]);


        // ------ CRUD DETAILS ROW
        $this->crud->enableDetailsRow();
        $this->crud->allowAccess('details_row');
        $this->crud->setDetailsRowView('vendor.backpack.crud.details_row.account');

        //Fields

        $this->crud->addField([
                'label' => "Office Name",
                'type' => "select2",
                'name' => 'office_id',
                'entity' => 'office',
                'attribute' => "name",
                'model' => "App\Models\Office",
        ]);

        $this->crud->addFields([
            [
                'label' => 'Account Name',
                'name' => 'name',
                'type' => 'text'
            ],

            [
                'label' => 'Opening Balance',
                'name' => 'opening_balance',
                'type' => 'number',
                'attributes' => ["step" => "any"],
            ],

            [
                'label' => 'Bank Name',
                'name' => 'bank_name',
                'type' => 'text'
            ],

            [
                'label' => 'Bank Phone',
                'name' => 'bank_phone',
                'type' => 'number',
            ],

            [
                'label' => 'Bank Address',
                'name' => 'bank_address',
                'type' => 'text'
            ],

            [
                'label' => 'Enabled',
                'name' => 'enabled',
                'type' => 'checkbox'
            ]
        ]);

        // add asterisk for fields that are required in AccountRequest
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
