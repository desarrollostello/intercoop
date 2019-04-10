<?php
/**
 * Created by PhpStorm.
 * User: ma3xc
 * Date: 07/11/2016
 * Time: 1:51
 */
/*-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-*/
Route::group(['prefix'=>'postajax'], function(){
    Route::post('/existsemail', [
        'name'  => 'existsemail',
        'as'    => 'existsemail',
        'uses'  => 'PostAjaxCtrl@existsemail'
    ])->middleware(['guest','auth']);
    Route::post('/existsusername', [
        'name'  => 'existsusername',
        'as'    => 'existsusername',
        'uses'  => 'PostAjaxCtrl@existsusername'
    ])->middleware(['guest','auth']);
    Route::post('/updateprofilebasicinfo', [
        'name'  => 'updateProfileBasicInfo',
        'as'    => 'updateProfileBasicInfo',
        'uses'  => 'PostAjaxCtrl@updateProfileBasicInfo'
    ])->middleware(['auth']);
    Route::post('/updateprofilepersonalinfo', [
        'name'  => 'updateprofilepersonalinfo',
        'as'    => 'updateprofilepersonalinfo',
        'uses'  => 'PostAjaxCtrl@updateProfilePersonalInfo'
    ])->middleware(['auth']);
    Route::post('/updatedescription', [
        'name'  => 'updatedescription',
        'as'    => 'updatedescription',
        'uses'  => 'PostAjaxCtrl@updatedescription'
    ])->middleware(['auth']);
    Route::post('/updateemail', [
        'name'  => 'updateemail',
        'as'    => 'updateemail',
        'uses'  => 'PostAjaxCtrl@updateemail'
    ])->middleware(['auth']);
    Route::post('/updateusername', [
        'name'  => 'updateusername',
        'as'    => 'updateusername',
        'uses'  => 'PostAjaxCtrl@updateusername'
    ])->middleware(['auth']);
    Route::post('/updatepassword', [
        'name'  => 'updatepassword',
        'as'    => 'updatepassword',
        'uses'  => 'PostAjaxCtrl@updatepassword'
    ])->middleware(['auth']);
    Route::post('/upload-avatar', [
        'name'  => 'upload-avatar',
        'as'    => 'upload-avatar',
        'uses'  => 'PostAjaxCtrl@uploadavatar'
    ])->middleware(['auth']);
    Route::post('/crop-avatar', [
        'name'  => 'crop-avatar',
        'as'    => 'crop-avatar',
        'uses'  => 'PostAjaxCtrl@cropavatar'
    ])->middleware(['auth']);
    Route::post('/addcontact', [
        'name'  => 'addcontact',
        'as'    => 'addcontact',
        'uses'  => 'PostAjaxCtrl@addcontact'
    ])->middleware(['auth']);
    Route::post('/cancelcontact', [
        'name'  => 'cancelcontact',
        'as'    => 'cancelcontact',
        'uses'  => 'PostAjaxCtrl@cancelrequestcontact'
    ])->middleware(['auth']);
    Route::post('/deletecontact', [
        'name'  => 'deletecontact',
        'as'    => 'deletecontact',
        'uses'  => 'PostAjaxCtrl@deletecontact'
    ])->middleware(['auth']);
    Route::post('/aceptcontact', [
        'name'  => 'aceptcontact',
        'as'    => 'aceptcontact',
        'uses'  => 'PostAjaxCtrl@aceptRequestContact'
    ])->middleware(['auth']);
    Route::post('/userlike', [
        'name'  => 'userlike',
        'as'    => 'userlike',
        'uses'  => 'PostAjaxCtrl@userlike'
    ])->middleware(['auth']);
    Route::post('/sendmessage', [
        'name'  => 'sendmessage',
        'as'    => 'sendmessage',
        'uses'  => 'PostAjaxCtrl@sendMessage'
    ])->middleware(['auth']);

    Route::post('/changestate', [
        'name'  => 'changestate',
        'as'    => 'changestate',
        'uses'  => 'PostAjaxCtrl@changestate'
    ])->middleware(['auth']);
    Route::post('/postphoto', [
        'name'  => 'postphoto',
        'as'    => 'postphoto',
        'uses'  => 'PostAjaxCtrl@postphoto'
    ])->middleware(['auth']);
    Route::post('/deletephoto', [
        'name'  => 'deletephoto',
        'as'    => 'deletephoto',
        'uses'  => 'PostAjaxCtrl@deletephoto'
    ]);
    Route::post('/savephoto', [
        'name'  => 'savephoto',
        'as'    => 'savephoto',
        'uses'  => 'PostAjaxCtrl@savephoto'
    ]);
    Route::post('/commentphoto', [
        'name'  => 'commentphoto',
        'as'    => 'commentphoto',
        'uses'  => 'PostAjaxCtrl@commentphoto'
    ])->middleware(['auth']);
    Route::post('/likephoto', [
        'name'  => 'likephoto',
        'as'    => 'likephoto',
        'uses'  => 'PostAjaxCtrl@likephoto'
    ])->middleware(['auth']);
    Route::post('/commentstate', [
        'name'  => 'commentstate',
        'as'    => 'commentstate',
        'uses'  => 'PostAjaxCtrl@commentstate'
    ])->middleware(['auth']);
    Route::post('/likestate', [
        'name'  => 'likestate',
        'as'    => 'likestate',
        'uses'  => 'PostAjaxCtrl@likestate'
    ])->middleware(['auth']);
});