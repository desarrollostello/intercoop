<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
* Para agregar un virtualhost en windows
* tenemos que editar los siguientes archivos:
* httpd.conf C:/server/apache/conf/httpd:conf
* httpd-vhosts.conf -> C:/server/apache/conf/extra/httpd-vhosts.conf
*/
use Pheaks\Http\Libraries\Flash;

$dir = __DIR__ . DS . "routes";
$files = glob($dir . '/*.php');

/*$segment = \Request::segment(1);
$user_name = \Pheaks\User::where('user_name', $segment)->first();
if($user_name){
    Route::group(['prefix'=>$user_name->user_name], function() use($user_name){
        Route::get('/', function() use($user_name){
            if(Auth::check()){
                if($user_name->user_name == Auth::user()->user_name) return redirect('profile');
            }
            $request = Request::create(route('accound',encrypt($user_name->id)));
            return Route::dispatch($request)->getContent();
        });
    });
}*/

foreach ($files as $file) {
    require($file);
}


