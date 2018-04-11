<?php

Route::group(['prefix' => 'api/zona', 'middleware' => ['web']], function() {
    $controllers = (object) [
        'index'     => 'Bantenprov\Zona\Http\Controllers\ZonaController@index',
        'create'    => 'Bantenprov\Zona\Http\Controllers\ZonaController@create',
        'show'      => 'Bantenprov\Zona\Http\Controllers\ZonaController@show',
        'store'     => 'Bantenprov\Zona\Http\Controllers\ZonaController@store',
        'edit'      => 'Bantenprov\Zona\Http\Controllers\ZonaController@edit',
        'update'    => 'Bantenprov\Zona\Http\Controllers\ZonaController@update',
        'destroy'   => 'Bantenprov\Zona\Http\Controllers\ZonaController@destroy',
    ];

    Route::get('/',             $controllers->index)->name('zona.index');
    Route::get('/create',       $controllers->create)->name('zona.create');
    Route::get('/{id}',         $controllers->show)->name('zona.show');
    Route::post('/',            $controllers->store)->name('zona.store');
    Route::get('/{id}/edit',    $controllers->edit)->name('zona.edit');
    Route::put('/{id}',         $controllers->update)->name('zona.update');
    Route::delete('/{id}',      $controllers->destroy)->name('zona.destroy');
});

Route::group(['prefix' => 'api/master-zona', 'middleware' => ['web']], function() {
    $controllers = (object) [
        'index'     => 'Bantenprov\Zona\Http\Controllers\MasterZonaController@index',
        'create'    => 'Bantenprov\Zona\Http\Controllers\MasterZonaController@create',
        'show'      => 'Bantenprov\Zona\Http\Controllers\MasterZonaController@show',
        'store'     => 'Bantenprov\Zona\Http\Controllers\MasterZonaController@store',
        'edit'      => 'Bantenprov\Zona\Http\Controllers\MasterZonaController@edit',
        'update'    => 'Bantenprov\Zona\Http\Controllers\MasterZonaController@update',
        'destroy'   => 'Bantenprov\Zona\Http\Controllers\MasterZonaController@destroy',
    ];

    Route::get('/',             $controllers->index)->name('master-zona.index');
    Route::get('/create',       $controllers->create)->name('master-zona.create');
    Route::get('/{id}',         $controllers->show)->name('master-zona.show');
    Route::post('/',            $controllers->store)->name('master-zona.store');
    Route::get('/{id}/edit',    $controllers->edit)->name('master-zona.edit');
    Route::put('/{id}',         $controllers->update)->name('master-zona.update');
    Route::delete('/{id}',      $controllers->destroy)->name('master-zona.destroy');
});
