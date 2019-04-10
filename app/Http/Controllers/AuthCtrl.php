<?php

namespace Pheaks\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;
use Pheaks\Http\Libraries\EmailSender;
use Pheaks\Http\Requests;
use File,
    Auth,
    View,
	Pheaks\User,
	Redirect,
	Pheaks\Http\Libraries\Flash,
	Pheaks\Http\Requests\SignupAuthRequest,
    Pheaks\Profiles;
use Pheaks\Photo;
use Pheaks\SocialConnect;

class AuthCtrl extends Controller
{
    public function __construct()
    {
    	parent::__construct();
        $users = User::where('profiles.sex_preference','!=',"")
        //->where('profiles.sex_preference',Auth::user()->sex)
        ->where('users.status','!=','0')
        ->leftJoin('profiles','users.id','=','profiles.user_id')
        ->limit(5)
        ->orderByRaw("RAND()")
        ->get();
        view::share('users', $users);
    }

    public function index()
    {


    	return view('auth.login');
    }

    public function login(Request $request)
    {
    	$this->middleware('guest');
        if($request->isMethod('post')){
            $field = filter_var($request['email'], FILTER_VALIDATE_EMAIL) ? 'email' : 'user_name';
            $request->merge([ $field => $request['email'] ]);
        	$user_info = $request->only($field, 'password');
            if(!isset($_SESSION)){
                $_SESSION['help'] = "";
            }
            $firstFindUser = User::where($field,'=',$user_info[$field])->first();
            if($firstFindUser!=null){
                $socialConnect = $user_info[$field] != null ? SocialConnect::where('user_id', '=', $firstFindUser->id)->where('register_used', '=', '1')->first() : null;

                if($socialConnect!=null){
                    $socialName = $socialConnect->social_name;
                    Flash::toastWarning('Your account is linked to '.$socialName);
                    return redirect()->back()->with('flash', Flash::all());
                }
            }
            if(\Auth::attempt($user_info, $request->remember_me)){
	        	if(Auth::user()->status==0){        		
	        		Flash::toastInfo('Your accound is inactive.');
	        	}elseif(Auth::user()->status==2){
	        	    $firstFindUser->update(['status'=>'1']);
	        	    Flash::toastInfo('Your account has been reactivated');
                }
	        	unset($_SESSION['help']);
	            return redirect()->route('home')->with('flash', Flash::all());
	        }else{
	        	/*Flash::toastSuccess('This is a success message.');
	        	Flash::toastInfo('This is a info message.');
	        	Flash::toastWarning('This is a warning message.');
	        	Flash::toastError('This is a error message.');**/

	        	Flash::toastError('Credentials not match.');
	        	//return Redirect::to(route('login'))-
                unset($_SESSION['help']);
	        	return redirect()->route('login')->with('flash', Flash::all())->withInput(Input::except('password'));
	        }

        }     
        return view('auth.login');   
    }

    public function signup(SignupAuthRequest $request)
    {
    	$this->middleware('guest');
        if ($request->isMethod('post')) {
            $user = new User();

            $user->user_name = $request->user_name;
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->birthday = $request->birth_year . "-" . $request->birth_month . "-" . $request->birth_day;
            $user->email = $request->email;
            $user->sex = $request->sex;
            $user->interest = $request->interest;
            $user->password = bcrypt($request->password);
            $user->status = 0;
            if ($user->save()) {
                Auth::login($user);

                $public_folder = "users" . DS . uniqid(time()) . DS;
                File::makeDirectory($public_folder, 0777);
                //Create an avatar user
                $avatar = new Photo();

                $avatar->user_id   = $user->id;
                $avatar->is_avatar = true;
                $avatar->original  = "img/default_avatar.png";
                $avatar->large     = "img/default_avatar.png";
                $avatar->medium    = "img/default_avatar.png";
                $avatar->small     = "img/default_avatar.png";
                $avatar->save();

                //Create an user profile
                $profile = new Profiles();
                $profile->user_id    = $user->id;
                $profile->avatar_photo_id   = $avatar->id;
                $profile->public_folder = $public_folder;
                //$profile->sex_preference = $request->interest;
                $profile->save();

                Flash::toastSuccess('Te haz registrado correctamente');

                try{
                    $sendemail_status = EmailSender::send_activate_accound($user);
                }catch (\Exception $e){
                    $sendemail_status['status'] = "error";
                    $mail_message = $e->getMessage();
                }
                if($sendemail_status['status']=='success'){
                    Flash::toastInfo('Te hemos enviado un corre de validacion para tu cuenta.');
                }else{
                    Flash::toastWarning(isset($mail_message) ? $mail_message : 'Error al enviar el correo de validacion: '.$sendemail_status['message']);
                }

                //return Redirect::to('/')->withInput();
                return redirect()->route('home')->with('flash', Flash::all());
            }
        }else{
            return redirect()->route('auth', ['tab_title'=>'Signup']);
        }
        if(session()->has('fb_id')){
            Auth::logout();
        }
    }

    public function logout()
    {
        $this->middleware('auth');
        Auth::logout();
        return Redirect::to('/?logout=success');
    }
}
