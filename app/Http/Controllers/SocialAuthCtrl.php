<?php

namespace Pheaks\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use File;
use Intervention\Image\ImageManagerStatic as Image;
use Pheaks\Http\Libraries\Flash;
use Pheaks\Http\Libraries\EmailSender;
use Pheaks\Http\Requests;
use Pheaks\Photo;
use Pheaks\Profiles;
use Pheaks\SocialConnect;
use Pheaks\User;
use Auth;

class SocialAuthCtrl extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function loginWithFacebook(Request $request)
    {
        // get data from request
        $this->middleware('guest');
        $code = $request->get('code');

        // get fb service
        $fb = \OAuth::consumer('Facebook', url(route('fb-login')));

        // check if code is valid

        // if code is provided get user data and sign in
        if ( ! is_null($code))
        {
            // This was a callback request from facebook, get the token
            $token = $fb->requestAccessToken($code);
            // Send a request with it
            $result = json_decode($fb->request('/me'), true);

            $social_find_id = SocialConnect::where('social_name','=','facebook')->where('social_id','=',$result['id'])->first();

            if($social_find_id!=null) {
                if ($social_find_id->register_used == '0') {
                    Flash::toastInfo('You cannot login with this account.');
                } elseif ($social_find_id->register_used == '1') {
                    $loginUser = User::where('id', $social_find_id->user_id)->first();
                    if(!$loginUser->email){
                        Flash::toastInfo('Go to your <a class="white-text bold-text underline" href="'. route('profile').'">profile settings</a> and add your email.');
                    }
                    Auth::loginUsingId($loginUser->id, true);
                    return redirect()->route('home')->with(['flash'=>Flash::all()]);
                }
            }else{
                Flash::toastError('User not found');
            }
            return redirect('/')->with(['flash'=>Flash::all()]);
        }
        // if not ask for permission first
        else
        {
            // get fb authorization
            $url = $fb->getAuthorizationUri();

            // return to facebook login url
            return redirect((string)$url);
        }
    }

    public function signupWithFacebook(Request $request)
    {
        // get data from request
        $this->middleware('guest');
        $code = $request->get('code');

        // get fb service
        try {
            $fb = \OAuth::consumer('Facebook', url(route('fb-signup')));
        }catch(\Exception $e){
            Flash::toastError($e->getMessage());
            return redirect()->route('auth')->with('flash',Flash::all());
        }

        if ( ! is_null($code)){
            // This was a callback request from facebook, get the token
            $token = $fb->requestAccessToken($code);
            // Send a request with it
            $result = json_decode($fb->request('/me'), true);
            $checkIfSignedup = SocialConnect::where('social_id', '=', $result['id'])->first();
            //return dd($result);
            if ($checkIfSignedup!=null){
                if($checkIfSignedup->register_used=='0'){
                    Flash::toastInfo('This account is already linked to facebook. But you can not log on.');
                }else{
                    Flash::toastInfo('This account is already linked to facebook. Please login.');
                }
                return redirect()->route('login')->with('flash',Flash::all());
            }
            try {
                $getFbPicture = 'https://graph.facebook.com/'.$result['id'].'/picture?height=250&width=250&type=square';

                $initImage = Image::make($getFbPicture);
                switch ($initImage->mime()){
                    case 'image/png':
                        $fileType = '.png';
                        break;
                    case 'image/jpeg':
                        $fileType = '.jpeg';
                        break;
                    case 'image/gif':
                        $fileType = '.gif';
                        break;
                    default:
                        die('image type not supported');
                }
                $uniquename = uniqid(time());
                $public_unique_folder = "users" . DS . uniqid(time()) . DS;
                $userFolder = $this->__getUserFolder($public_unique_folder);
                $originalAvatarName = $userFolder.$uniquename.$fileType;
                $largeAvatarName = $userFolder."large_".$uniquename.$fileType;
                $mediumAvatarName = $userFolder."medium_".$uniquename.$fileType;
                $smallAvatarName = $userFolder."small_".$uniquename.$fileType;
                $initImage->save($originalAvatarName);
                $initImage->resize(250,250)->save($largeAvatarName);
                $initImage->resize(200,200)->save($mediumAvatarName);
                $initImage->resize(80,80)->save($smallAvatarName);
            }catch(\Exception $e){
                Flash::toastError($e->getMessage());
                return redirect()->back()->with('flash', Flash::all());
            }

            try{
                //new instance for new user
                $userNewId = User::all();
                $newUser = new User();

                $newUser->user_name = "user_".($userNewId->last()->id + 1);
                $newUser->first_name= $result['first_name'] ? $result['first_name'] : "Test name" ;
                $newUser->last_name = $result['last_name'] ? $result['last_name'] : "Test last" ;
                $newUser->email     = @$result['email'] ? $result['email'] : null;
                $newUser->birthday  = @$result['birthday'] ? date('Y', strtotime($result['birthday']))."-".date('m', strtotime($result['birthday']))."-".date('d', strtotime($result['birthday'])) : null;
                $newUser->sex       = $result['gender'] == 'male' ? 'm' : 'f';
                $newUser->password  = null;
                $newUser->status    = array_key_exists('verified',$result)&&@$result['verified']==true ? '1' : '0';
                $newUser->save();

                //new instance for avatar profile
                $avatar = new Photo();
                $avatar->user_id   = $newUser->id;
                $avatar->is_avatar = true;
                $avatar->original  = $originalAvatarName;
                $avatar->large     = $largeAvatarName;
                $avatar->medium    = $mediumAvatarName;
                $avatar->small     = $smallAvatarName;
                $avatar->status    = '1';
                $avatar->save();

                //new instance for profile user
                $profile = new Profiles();
                $profile->user_id    = $newUser->id;
                $profile->avatar_photo_id   = $avatar->id;
                $profile->public_folder = $public_unique_folder;
                $profile->sex_preference = $result['gender'] == 'male' ? 'f' : 'm';
                $profile->save();

                //new instance for socialconnect
                $social = new SocialConnect();
                $social->user_id    = $newUser->id;
                $social->social_name = 'facebook';
                $social->social_id = $result['id'];
                $social->register_used = '1';
                $social->save();

                Auth::loginUsingId($newUser->id);
                Flash::toastSuccess('Welcome to '.env('APP_NAME', APP_NAME)."!");
            }catch(\Exception $e){
                Flash::toastInfo($e->getMessage());
                return redirect('/')->with('flash',Flash::all());
            }

            if(isset($result)&&!empty($result)){
                if(isset($result['email'])&&!empty($result['email'])) {
                    $sendemail_status = EmailSender::send_activate_accound($newUser);
                    if ($sendemail_status['status'] == 'success') {
                        Flash::toastInfo('Te hemos enviado un corre de validacion para tu cuenta.');
                    } else {
                        Flash::toastWarning('Error al enviar el correo de validacion: ' . $sendemail_status['message']);
                    }
                }else{
                    //Flash::toastWarning('Para activar tu cuenta necesitas agregar un correo.');
                    //Flash::toastInfo('Vaya a la configuración de su perfil y agregue su correo electrónico.');
                    Flash::toastInfo('To activate your account, you need to add an email..');
                    Flash::toastInfo('Go to your profile settings and add your email.');
                }
            }

            return redirect('/')->with('flash',Flash::all());
        }else{
            // get fb authorization
            $url = $fb->getAuthorizationUri();

            // return to facebook login url
            return redirect((string)$url)->with('flash',Flash::all());
        }
    }

    public function loginWithGoogle(Request $request)
    {
        // get data from request
        $code = $request->get('code');

        // get google service
        $googleService = \OAuth::consumer('Google');

        // check if code is valid

        // if code is provided get user data and sign in
        if (!is_null($code)) {
            // This was a callback request from google, get the token
            $token = $googleService->requestAccessToken($code);

            // Send a request with it
            $result = json_decode($googleService->request('https://www.googleapis.com/oauth2/v1/userinfo'), true);

            $message = '<img src="' . $result['picture'] . '"/>Your unique Google user id is: ' . $result['id'] . ' and your name is ' . $result['name'];
            echo $message . "<br/>";

            //Var_dump
            //display whole array.
            //return redirect(route('login'))->with(['email'=>$result['email']]);
        } // if not ask for permission first
        else {
            // get googleService authorization
            $url = $googleService->getAuthorizationUri();

            // return to google login url
            return redirect((string)$url);
        }
    }

    public function __getUserFolder($public_unique_folder)
    {
        File::makeDirectory($public_unique_folder, 0777);

        $public_folder = $public_unique_folder.date('Y-m-d').DS;
        $user_folder = PUBLIC_PATH.DS.$public_folder.DS;
        $folder_exists = PUBLIC_PATH.DS.$public_folder;
        if(!is_dir($user_folder)){
            try{
                File::makeDirectory($user_folder);

                $index_file = PUBLIC_PATH.DS."users".DS."index.html";
                $new_index_file = $user_folder."index.html";
                if (!copy($index_file, $new_index_file)) {
                    $status = "Error al copiar $index_file...\n";
                }else{
                    $status = $folder_exists;
                }
            }catch(Exeption $e){
                $response['status'] = 'error';
                $response['messsage'] = 'Error with your images folder, please contact to admin';
                return $response;
            }
        }
        if(!is_dir($folder_exists)){
            try{
                File::makeDirectory($folder_exists,0777);
                //File($folder_exists, 0777, TRUE);

                $index_file = PUBLIC_PATH.DS."users".DS."index.html";
                $new_index_file = $folder_exists."index.html";
                if (!copy($index_file, $new_index_file)) {
                    $status = "Error al copiar $index_file...\n";
                }else{
                    $status = $folder_exists;
                }
            }catch(Exeption $e){
                $status['status'] = 'error';
                $status['message'] = $e->getMessage();
            }
            return $status;
        }else{
            return $public_folder;
        }
    }
}
