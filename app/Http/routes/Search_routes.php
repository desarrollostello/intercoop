<?php
/**
 * Created by PhpStorm.
 * User: ma3xc
 * Date: 07/11/2016
 * Time: 1:48
 */

/*-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-*/
Route::get('/search', [
    'name'  => 'search',
    'as'    => 'search',
    'uses'  => 'SearchCtrl@index'
])->middleware(['auth']);
