<?php
/**
 * Created by PhpStorm.
 * User: ma3xc
 * Date: 07/11/2016
 * Time: 1:53
 */
/*-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-*/
Route::group(['prefix' => 'profile', 'middleware'=>['auth','web']], function() {
    //Route for user profile
    Route::get('/', [
        'name'	=> 'profile',
        'as'	=> 'profile',
        'uses'	=> 'ProfileCtrl@index'
    ]);
    Route::get('/like', [
        'name'  => 'likes',
        'as'    => 'likes',
        'uses'  => 'ProfileCtrl@likes'
    ]);
    //Route for profile visitors
    Route::get('/visitors', [
        'name'  => 'visitors',
        'as'    => 'visitors',
        'uses'  => 'ProfileCtrl@visitors'
    ]);
    Route::get('/contacts', [
        'name'  => 'contacts',
        'as'    => 'contacts',
        'uses'  => 'ProfileCtrl@contacts'
    ])->middleware(['auth']);
    Route::get('/showmessages/{id}', [
        'name'  => 'showmessages',
        'as'    => 'showmessages',
        'uses'  => 'ProfileCtrl@showmessages'
    ]);
    Route::get('/edit', [
        'name'  => 'profile-edit',
        'as'    => 'profile-edit',
        'uses'  => 'ProfileCtrl@edit'
    ]);
});