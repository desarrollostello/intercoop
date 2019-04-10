<?php
/**
 * Created by PhpStorm.
 * User: ma3xc
 * Date: 07/11/2016
 * Time: 1:52
 */
/*-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-*/
Route::group(['prefix' => '/auth'], function() {
    //Routes for login - logout - signup
    Route::get('/', [
        'name'	=> 'auth',
        'as'	=> 'auth',
        'uses'	=> 'AuthCtrl@index'
    ])->middleware(['guest']);
    Route::match(['get', 'post'], '/login', [
        'name'	=> 'login',
        'as'	=> 'login',
        'uses'	=> 'AuthCtrl@login'
    ])->middleware(['guest']);
    Route::match(['get', 'post'], '/signup', [
        'name'	=> 'signup',
        'as'	=> 'signup',
        'uses'	=> 'AuthCtrl@signup'
    ])->middleware(['guest']);
    //Route for clear session or logout
    Route::get('/logout', [
        'name'	=> 'logout',
        'as'	=> 'logout',
        'uses'	=> 'AuthCtrl@logout'
    ])->middleware(['auth']);
    Route::get('/activate', [
        'name'  => 'activate-accound',
        'as'    => 'activate-accound',
        'uses'  => 'AccoundCtrl@activate'
    ]);
    //Flash::clear();
});
