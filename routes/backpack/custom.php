<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    CRUD::resource('office', 'OfficeCrudController')->with(function(){
        // add extra routes to this resource
        Route::get('office/{id}/suppliers', 'OfficeCrudController@getOfficeSuppliers');
        Route::post('office/{id}/suppliers', 'OfficeCrudController@postOfficeSuppliers');
        });
    CRUD::resource('supplier', 'SupplierCrudController');
    CRUD::resource('account', 'AccountCrudController');

    Route::post('/api/country', 'Api\CountryCityFetchController@fetch');

  }); // this should be the absolute last line of this file
