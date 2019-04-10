<?php
/**
 * Created by PhpStorm.
 * User: ma3xc
 * Date: 07/11/2016
 * Time: 1:52
 */
/*-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-*/
Route::group(['prefix' => 'accound'], function() {
    Route::get('/{user_id}', [
        'name'	=> 'accound',
        'as'	=> 'accound',
        'uses'	=> 'AccoundCtrl@accound'
    ]);
});