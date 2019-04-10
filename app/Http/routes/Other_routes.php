<?php
/**
 * Created by PhpStorm.
 * User: ma3xc
 * Date: 07/11/2016
 * Time: 1:53
 */

Route::get('/', function () {

    if(Auth::check()){
        $request = Request::create(route('home'));
        return Route::dispatch($request)->getContent();
    }else{
        $request = Request::create(route('auth'));
        return Route::dispatch($request)->getContent();
    }
});

/*Route::get('/{user_name}', [
    'name'  => 'username',
    'as'    => 'username',
    'uses'  => function(){
        return "Route For User";
    }
]);*/

//Route for profile messages
Route::get('/messages', [
    'name'  => 'messages',
    'as'    => 'messages',
    'uses'  => 'ProfileCtrl@messages'
]);
Route::get('/messages/{u_id}', [
    'name'  => 'messages-user',
    'as'    => 'messages-user',
    'uses'  => 'HomeCtrl@m_user'
]);

Route::get('/home', [
    'name'	=> 'home',
    'as'	=> 'home',
    'uses'	=> 'HomeCtrl@index'
]);

Route::get('download/{filename}', [
    'name'  => 'download-file',
    'as'    => 'download-file',
    'uses'  => function($filename){
        $file = decrypt($filename);
        return response()->download($file);
    }
]);

Route::post('/disableaccound', [
    'name'  => 'disableaccound',
    'as'    => 'disableaccound',
    'uses'  => function(){
        $user = Pheaks\User::where('id',Auth::user()->id)->first();
        try{
            $user->update(['status'=>'2']);

            Auth::logout();
            return [
                'status'    => 'success',
                'message'   => 'Your account has been disabled.<br>You can activate it by logging in.'
            ];
        }catch (Exception $e){
            return ['status'=>'error','message'=>$e->getMessage()];
        }
    }
])->middleware(['auth','web']);

/*Route::get('/testemail', function(){

    $test = \Pheaks\Http\Libraries\EmailSender::test_message();
    dd($test);
})->middleware(['auth']);*/

Route::post('/sendemailactivation', [
    'name'  => 'sendemailactivation',
    'as'    => 'sendemailactivation',
    'uses'  => function(){
        if(Auth::user()->status==0){
            if(Auth::user()->email!="") {
                try {
                    $user = new stdClass();
                    $user->email = Auth::user()->email;
                    $user->first_name = Auth::user()->first_name;
                    $user->last_name = Auth::user()->last_name;
                    $user->id = Auth::user()->id;
                    \Pheaks\Http\Libraries\EmailSender::send_activate_accound($user);
                    Flash::toastInfo('A validation email has been sent.<br>Check your email inbox');
                } catch (Exception $e) {
                    Flash::toastInfo($e->getMessage());
                }
            }else{
                Flash::toastInfo('You must add an email');
            }
        }else{
            Flash::toastInfo('Your account is already activated');
        }
        return redirect()->back()->with('flash',Flash::all());
    }
])->middleware(['auth','web']);

Route::post('/pusher/auth',[
    'name'  => 'pusher-auth',
    'as'    => 'pusher-auth',
    'uses'  => 'HomeCtrl@pusherAuth'
])->middleware('auth');
