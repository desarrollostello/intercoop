<?php
/**
 * Created by PhpStorm.
 * User: ma3xc
 * Date: 07/11/2016
 * Time: 1:51
 */
/*-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-+-*/
Route::group(['prefix'=>'getajax'], function(){
    Route::get('/change-lang', function() {
        return view('modals.change-lang');
    });
    Route::get('/recovery-passwod', function(){
        return view('modals.recovery-passwod');
    });
    Route::get('/get-regions',[
        'name'  =>'get-regions',
        'as'    =>'get-regions',
        'uses'  => 'GetAjaxCtrl@getRegions'
    ])->middleware(['auth']);
    Route::get('/get-cities', [
        'name'  => 'get-cities',
        'as'    => 'get-cities',
        'uses'  => 'GetAjaxCtrl@getCities'
    ])->middleware(['auth']);
    Route::get('/editemail', function(){
        return view('modals.edit-email');
    })->middleware(['auth']);
    Route::get('/editusername', function(){
        return view('modals.edit-username');
    })->middleware(['auth']);
    Route::get('/changepassword', function(){
        return view('modals.change-password');
    })->middleware(['auth']);
    Route::get('/show-photo', [
        'name'  => 'show-photo',
        'as'    => 'show-photo',
        'uses'  => 'GetAjaxCtrl@showPhoto'
    ])->middleware(['auth']);
    Route::get('/newpost', [
        'name'  => 'new-post',
        'as'    => 'new-post',
        'uses'  => function(Illuminate\Http\Request $request){
            if($request->ajax()){
                return view('modals.new-post');
            }else{
                return abort(404);
            }
        }
    ])->middleware(['auth']);
    Route::get('/newphoto', [
        'name'  => 'newphoto',
        'as'    => 'newphoto',
        'uses'  => function(\Illuminate\Http\Request $request){
            if($request->ajax()){
                return view('modals.new-photo');
            }else{
                return abort(404);
            }
        }
    ]);
    Route::get('/editphoto', [
        'name'  => 'editphoto',
        'as'    => 'editphoto',
        'uses'  => 'GetAjaxCtrl@editphoto'
    ]);
    Route::get('/firstmessages', [
        'name'  => 'firstmessages',
        'as'    => 'firstmessages',
        'uses'  => 'GetAjaxCtrl@getMessages'
    ]);
    Route::get('/firstnotifies', [
        'name'  => 'firstnotifies',
        'as'    => 'firstnotifies',
        'uses'  => 'GetAjaxCtrl@getNotifies'
    ]);
    Route::get('/morenotifies', [
        'name'  => 'firstnotifies',
        'as'    => 'firstnotifies',
        'uses'  => 'GetAjaxCtrl@getMoreNotifies'
    ]);

    Route::get('/morefeeds', [
        'name'  => 'morefeeds',
        'as'    => 'morefeeds',
        'uses'  => 'GetAjaxCtrl@morefeeds'
    ])->middleware('auth');
    Route::get('/morefeedcomments', [
        'name'  => 'morefeedcomments',
        'as'    => 'morefeedcomments',
        'uses'  => 'GetAjaxCtrl@morefeedcomments'
    ]);
});