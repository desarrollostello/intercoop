<?php
/**
 * Created by PhpStorm.
 * User: ma3xc
 * Date: 07/11/2016
 * Time: 1:50
 */
/*-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-*/
Route::group(['prefix'=>'socialauth'], function(){
    Route::get('/fb-login', [
        'name'  => 'fb-login',
        'as'    => 'fb-login',
        'uses'  => 'SocialAuthCtrl@loginWithFacebook'
    ]);
    Route::get('/fb-signup', [
        'name'  => 'fb-signup',
        'as'    => 'fb-signup',
        'uses'  => 'SocialAuthCtrl@signupWithFacebook'
    ]);

    Route::get('/gle-login', [
        'name'  => 'gle-login',
        'as'    => 'gle-login',
        'uses'  => 'SocialAuthCtrl@loginWithGoogle'
    ]);
});