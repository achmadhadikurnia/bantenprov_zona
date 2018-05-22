<?php

Route::group(['prefix' => 'api/master-zona', 'middleware' => ['web','role:superadministrator']], function() {
    $class          = 'Bantenprov\Zona\Http\Controllers\MasterZonaController';
    $name           = 'master-zona';
    $controllers    = (object) [
        'index'     => $class.'@index',
        'get'       => $class.'@get',
        'create'    => $class.'@create',
        'show'      => $class.'@show',
        'store'     => $class.'@store',
        'edit'      => $class.'@edit',
        'update'    => $class.'@update',
        'destroy'   => $class.'@destroy',
    ];

    Route::get('/',             $controllers->index)->name($name.'.index');
    Route::get('/get',          $controllers->get)->name($name.'.get');
    Route::get('/create',       $controllers->create)->name($name.'.create');
    Route::get('/{id}',         $controllers->show)->name($name.'.show');
    Route::post('/',            $controllers->store)->name($name.'.store');
    Route::get('/{id}/edit',    $controllers->edit)->name($name.'.edit');
    Route::put('/{id}',         $controllers->update)->name($name.'.update');
    Route::delete('/{id}',      $controllers->destroy)->name($name.'.destroy');
});

Route::group(['prefix' => 'api/zona', 'middleware' => ['web']], function() {
    $class          = 'Bantenprov\Zona\Http\Controllers\ZonaController';
    $name           = 'zona';
    $controllers    = (object) [
        'index'     => $class.'@index',
        'get'       => $class.'@get',
        'create'    => $class.'@create',
        'show'      => $class.'@show',
        'store'     => $class.'@store',
        'edit'      => $class.'@edit',
        'update'    => $class.'@update',
        'destroy'   => $class.'@destroy',
    ];

    Route::get('/',             $controllers->index)->name($name.'.index')->middleware('role:admin_sekolah|superadministrator');
    Route::get('/get',          $controllers->get)->name($name.'.get')->middleware('role:admin_sekolah|superadministrator');
    Route::get('/create',       $controllers->create)->name($name.'.create')->middleware('role:admin_sekolah|superadministrator');
    Route::get('/{id}',         $controllers->show)->name($name.'.show')->middleware('role:admin_sekolah|superadministrator');
    Route::post('/',            $controllers->store)->name($name.'.store')->middleware('role:admin_sekolah|superadministrator');
    Route::get('/{id}/edit',    $controllers->edit)->name($name.'.edit')->middleware('role:admin_sekolah|superadministrator');
    Route::put('/{id}',         $controllers->update)->name($name.'.update')->middleware('role:admin_sekolah|superadministrator');
    Route::delete('/{id}',      $controllers->destroy)->name($name.'.destroy')->middleware('role:superadministrator');
});
