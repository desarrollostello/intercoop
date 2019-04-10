<?php

Route::group(['prefix'=>'admin'], function(){
    Route::get('/', [
        'name'  => 'home-admin',
        'as'    => 'home-admin',
        'uses'  => '\Pheaks\Http\Controllers\Admin\AdminCtrl@index'
    ])->middleware(['auth']);
    Route::get('/users', [
        'name'  => 'users-admin',
        'as'    => 'users-admin',
        'uses'  => '\Pheaks\Http\Controllers\Admin\AdminCtrl@users'
    ])->middleware(['auth']);
});