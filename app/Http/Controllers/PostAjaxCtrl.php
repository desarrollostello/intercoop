<?php

namespace Pheaks\Http\Controllers;

use Illuminate\Auth\Access\Response;
use Illuminate\Contracts\Logging\Log;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Hash;
use Hashids;
use Intervention\Image\ImageManagerStatic as Image;
use Pheaks\Comment;
use Pheaks\Contacts;
use Pheaks\Http\Libraries\Checks;
use Pheaks\Http\Libraries\Croppic;
use Illuminate\Support\Facades\Auth;
use Pheaks\Http\Libraries\EmailSender;
use \Waavi\Sanitizer\Sanitizer;
use Pheaks\Http\Requests;
use Pheaks\Like;
use Pheaks\Message;
use Pheaks\Newsfeed;
use Pheaks\Notify;
use Pheaks\Photo;
use Pheaks\Profiles;
use Pheaks\State as Status;
use Pheaks\State;
use Pheaks\User;
use Route;

class PostAjaxCtrl extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct();
        if(!$request->ajax()){
            return abort(404);
        }
    }

    public function existsemail(Request $request)
    {
        if($request->ajax()){
            $user_email = \Pheaks\User::where('email', $request->email)->first();

            if(empty($user_email)){
                return 0;
            }else{
                return 1;
            }
        }
    }

    public function existsusername(Request $request)
    {
        if($request->ajax()){
            $user_email = \Pheaks\User::where('user_name', $request->user)->first();

            if(empty($user_email)){
                return 0;
            }else{
                return 1;
            }
        }
    }

    public function updateProfileBasicInfo(Request $request){
        //$fields['user_name']    = $request->user_name;
        $fields['first_name']   = $request->first_name;
        $fields['last_name']    = $request->last_name;
        //$fields['email']        = $request->email;
        $fields['birthday']     = $request->birthday;
        $profile = User::where('id',Auth::user()->id)->update($fields);
        if($profile){
            $response['status'] = 'success';
            $response['message'] = 'Your information has been updated';
        }else{
            $response['status'] = 'error';
            $response['message'] = 'An unknown error occurred!';
        }
        return json_encode($response);
    }

    public function updateProfilePersonalInfo(Request $request)
    {
        if($request->ajax()){
            $profile = Profiles::where('user_id',Auth::user()->id)->first();
            if($profile !== null) {
                $profile->zodiac_sign = $request->zodiac_sign;
                $profile->height = $request->height;
                $profile->complexion = $request->complexion;
                $profile->civil_status = $request->civil_status;
                $profile->children = $request->children;
                $profile->sex_preference = $request->sex_preference;
                $profile->education = $request->education;
                $profile->smoking = $request->smoking;
                $profile->country = $request->country;
                $profile->region = $request->region;
                $profile->citie = $request->citie;
                try{
                    $profile->save();
                    $response['status'] = 'success';
                    $response['message'] = 'Your information has been updated';
                }catch (\Exception $e){
                    $response['status'] = 'error';
                    $response['message'] = $e->getMessage();
                }
            }else{
                $profile_new = new Profiles();
                $profile_new->user_id = Auth::user()->id;
                $profile_new->avatar_small = 'http://lorempixel.com/50/50/people/';
                $profile_new->avatar_medium = 'http://lorempixel.com/100/100/people/';
                $profile_new->avatar_large = 'http://lorempixel.com/150/150/people/';
                $profile_new->description = null;
                $profile_new->zodiac_sign = $request->zodiac_sign;
                $profile_new->height = $request->height;
                $profile_new->complexion = $request->complexion;
                $profile_new->civil_status = $request->civil_status;
                $profile_new->children = $request->children;
                $profile_new->education = $request->education;
                $profile_new->smoking = $request->smoking;
                $profile_new->drink = null;
                $profile_new->laboral_sector = null;
                $profile_new->salary = null;
                $profile_new->country = $request->country;
                $profile_new->region = $request->region;
                $profile_new->citie = $request->citie;
                try {
                    $profile_new->save();
                    $response['status'] = 'success';
                    $response['message'] = 'Your information has been updated.';
                }catch(\Exception $e){
                    $response['status'] = 'error';
                    $response['message'] = $e->getMessage()."!";
                }
            }
            Auth::user()->update(['language'=>$request->language]);
            return json_encode($response);
        }else{
            return abort(401);
        }
    }

    public function updateemail(Request $request){
        if(!$request->email){
            $response['stauts'] = "error";
            $response['message'] = "Insert a valid email";
            return json_encode($response);
        } else{
            $user_email = \Pheaks\User::where('email', $request->email)->first();

            if($request->email == Auth::user()->email){
                $response['stauts'] = "error";
                $response['message'] = 'This is your current email.';
                return json_encode($response);
            }elseif(!empty($user_email)){
                $response['stauts'] = "error";
                $response['message'] = 'This email has already been used.';
                return json_encode($response);
            }


            $user = User::where('id','=',Auth::user()->id)->first();
            try{
                //if(Auth::user()->status=='0'){
                $user->email = $request->email;
                $sendemail_status = EmailSender::send_activate_accound($user);
                if($sendemail_status['status']=='success'){
                    $response['status'] = 'success';
                    $response['message'] = 'We send you a validation email to your account.';
                    return json_encode($response);
                }else{
                    $response['status'] = 'error';
                    $response['message'] = 'Error sending mail validation: '.$sendemail_status['message'];
                    return json_encode($response);
                }
                //}
            }catch (\Exception $e){
                $response['status'] = 'success';
                $response['message'] = $e->getMessage();
                return json_encode($response);
            }
            try{
                $user->update([
                    'email'  => $request->email
                ]);
            }catch (\Exception $e){
                $response['stauts'] = "error";
                $response['message'] = $e->getMessage();
                return json_encode($response);
            }
        }
        return json_encode($response);
    }

    public function updateusername(Request $request)
    {
        if(!$request->user_name){
            $response['stauts'] = "error";
            $response['message'] = "Insert a valid email";
        } else{
            $user_email = \Pheaks\User::where('user_name', $request->user_name)->first();

            if($request->user_name == Auth::user()->user_name){
                $response['stauts'] = "error";
                $response['message'] = 'This is your current username.';
                return json_encode($response);
            }elseif(!empty($user_email)){
                $response['stauts'] = "error";
                $response['message'] = 'This username has already been used.';
                return json_encode($response);
            }


            $user = User::where('id','=',Auth::user()->id)->first();
            try{
                $user->update([
                    'user_name'  => $request->user_name
                ]);
            }catch (\Exception $e){
                $response['stauts'] = "error";
                $response['message'] = $e->getMessage();
                return json_encode($response);
            }
            $response['status'] = 'success';
            $response['message'] = 'Your username has been updated.';
        }
        return json_encode($response);
    }

    public function updatedescription(Request $request)
    {
        if(!$request->description||$request->description==""){
            return ['status'=>'error','message'=>'Insert your description.'];
        }
        $profile = Profiles::where('user_id',Auth::user()->id)->first();

        try{
            $sanitizer = (new Sanitizer($request->all(), ['description'=>'trim|escape']))->sanitize();
            $profile->update([
                'description'   => $sanitizer['description']
            ]);
            return ['status'=>'success','message'=>'Your description has been updated'];
        }catch (\Exception $e){
            return ['status'=>'error','message'=>$e->getMessage()];
        }
    }

    public function updatepassword(Request $request)
    {
        try {
            $this->validate($request, [
                'password' => 'required|confirmed',
            ]);
            $credentials = $request->only(
                'password', 'password_confirmation'
            );
        }catch(\Exception $e){
            $response['status'] = "error";
            $response['message'] = "Passwords do not match.";
            return json_encode($response);
        }

        $hash = Hash::check($request->current_pass, Auth::user()->password);
        if(!$hash){
            $response['status'] = "error";
            $response['message'] = "Your current password does not match.";
            return json_encode($response);
        }else{
            $user = Auth::user();

            try{
                $user->update([
                    'password' => $request->password
                ]);
                $response['status'] = "success";
                $response['message'] = "Your password has been updated.";
                return json_encode($response);
            }catch(\Exception $e){
                $response['status'] = "error";
                $response['message'] = $e->getMessage();
                return json_encode($response);
            }
        }
    }

    public function uploadavatar()
    {
        $croppic = new Croppic();
        return $croppic->save();
    }

    public function cropavatar()
    {
        $croppic = new Croppic();
        return $croppic->crop();
    }

    public function postphoto(Request $request)
    {
        if(!$request->file_name||$request->file_name==null||$request->file_name=='undefined'){
            return ['status'=>'error','message'=>'Please select a file.'];
        }
        if(!in_array($request->privacy,[0,1])){
            return ['status'=>'error','message'=>'Privacy option not is valid.'];
        }
        $croppic = new Croppic;
        return $croppic->create_photo($request);
    }

    public function deletephoto(Request $request)
    {
        if(!$request->photo){
            return ['status'=>'error','message'=>'Missing parameters to send.'];
        }
        try {
            $photo_id = Hashids::decode($request->photo);
        }catch (\Exception $e){
            return ['status'=>'error','message'=>'Error getting photo from server.'];
        }
        $photo_info = Photo::where(['id'=>$photo_id[0],'user_id'=>Auth::user()->id,'status'=>'1'])->first();

        if($photo_info!=null){
            if($photo_info->is_avatar=='1'){
                return ['status'=>'error','message'=>'Please change your profile picture first.'];
            }else{
                try {
                    $photo_info->update([
                        'status'    => '2'
                    ]);
                    return ['status'=>'success','message'=>'Photo has been deleted'];
               }catch (\Exception $e){
                   return ['status'=>'error','message'=>'Could not delete photo, try again.'];
               }
            }
        }else{
            return ['status'=>'error','message'=>'Photo not found.'];
        }
    }

    public function savephoto(Request $request)
    {
        if(!$request->photo){
            return ['status'=>'error','message'=>'Missing parameters to send.'];
        }
        if(!in_array($request->privacy,[0,1])){
            return ['status'=>'error','message'=>'Privacy option not is valid.'];
        }
        try {
            $photo_id = Hashids::decode($request->photo);
        }catch (\Exception $e){
            return ['status'=>'error','message'=>'Error getting photo from server.'];
        }
        $photo_info = Photo::where(['id'=>$photo_id[0],'user_id'=>Auth::user()->id,'status'=>'1'])->first();
        if($photo_info!=null){
            if($request->is_avatar){
                try{
                    foreach (Photo::where(['user_id'=>Auth::user()->id,'is_avatar'=>'1'])->get() as $avatar){
                        $avatar->update(['is_avatar'=>false]);
                    }

                    $photo_info->update([
                        'is_avatar' => true,
                        'privacy'   => '1',
                    ]);
                    Auth::user()->profile()->update(['avatar_photo_id'=>$photo_info->id]);
                    return [
                        'status'=>'success',
                        'message'=>'Your photo has been updated.',
                        'small' => $photo_info->small,
                        'large' => $photo_info->medium
                    ];
                }catch (\Exception $e){
                    return ['status'=>'error','message'=>$e->getMessage()];
                }
            }else{
                try {
                    $photo_info->update([
                        'privacy'    => $request->privacy
                    ]);
                    return ['status'=>'success','message'=>'Your photo has been updated.'];
                }catch (\Exception $e){
                    return ['status'=>'error','message'=>'Could not delete photo, try again.'];
                }
            }
        }else{
            return ['status'=>'error','message'=>'Photo not found.'];
        }
    }

    public function addcontact(Request $request)
    {

        $user = User::where('id','=',decrypt($request->_user))->first();
        $contact = Contacts::where([
            ['user_from','=',decrypt($request->_user)],
            ['user_to','=',Auth::user()->id]
        ])->orWhere([
            ['user_from','=',Auth::user()->id],
            ['user_to','=',decrypt($request->_user)]
        ])->first();
        if(Checks::contact_request_sended(decrypt($request->_user)) || Checks::is_contact(decrypt($request->_user))) {
            $result['status'] = 'error';
            $result['message'] = $user->user_name.' is already added in your contact list';

        }else{
            if($contact==null) {
                $contact = new Contacts();
                $contact->user_from = Auth::user()->id;
                $contact->user_to = decrypt($request->_user);
                $contact->status = 0;
                $contact->created_at = date('Y-m-d H:i:s', time());
                if ($contact->save()) {
                    $result['status'] = 'success';
                    $result['message'] = 'Request send.';

                    $notify = new Notify;

                    $notify->user_from = Auth::user()->id;
                    $notify->user_to   = decrypt($request->_user);
                    $notify->viewed    = false;
                    $notify->type      = '1';
                    $notify->object    = Auth::user()->id;
                    try {
                        $notify->save();

                        $html = "<img src='" . asset(Auth::user()->profile->avatar->small) . "' class='responsive-img circle' width='25' style='display:inline-block;vertical-align: middle'> <small>". Auth::user()->user_name." has sent a request contact.</small>";
                        $this->pusher->trigger('private-' . $user->user_name,'event-notify',[
                            'text' => $html,
                            'from' => encrypt(Auth::user()->id),
                            'from_user_name'  => Auth::user()->user_name,
                            'image_url' => asset(Auth::user()->profile->avatar->small),
                            'str_to_time'=> strtotime(date('Y-m-d H:i:s'))
                        ]);
                    }catch (\Exception $e){
                        return json_encode(['status'=>'error','message'=>'Unknown error']);
                    }
                } else {
                    $result['status'] = 'error';
                    $result['message'] = 'It could not be added.';
                }
            }else{
                if($contact->user_to==Auth::user()->id){
                    $contact->update([
                        'user_from' => Auth::user()->id,
                        'user_to'   => decrypt($request->_user),
                        'status'    => '0'
                    ]);
                }else {
                    $contact->update([
                        'status' => '0'
                    ]);
                }
                $result['status'] = 'success';
                $result['message'] = 'Request send.';
            }
        }
        return json_encode($result);
    }

    public function cancelrequestcontact(Request $request)
    {
        //For cancel request or delete contact, update status field to 2 value
        if($request->ajax()) {
            $decryptUser = decrypt($request->_user);
            $userInstance = Contacts::where([
                ['user_from', '=', $decryptUser],
                ['user_to', '=', Auth::user()->id]
            ])->orWhere([
                ['user_from', '=', Auth::user()->id],
                ['user_to', '=', $decryptUser]
            ])->first();


            if($userInstance!=null){
                $check = Route::currentRouteName() == 'cancelcontact' ? Checks::contact_request_sended($decryptUser) : Checks::is_contact($decryptUser);
                if ($check) {
                    $userInstance->update([
                        'status'=> '2'
                    ]);
                    $status['status'] = 'success';
                    $status['message'] = 'You has delete to '.User::find($decryptUser)->user_name;

                } else {
                    $status['status'] = 'error';
                    $status['message'] = 'This user is not added in your contacts list';
                }
            }else{
                $status['status'] = 'error';
                $status['message'] = 'The contact is not added in your contacts list';
            }
            return json_encode($status);
        }
    }

    public function aceptRequestContact(Request $req)
    {
        $user_id = decrypt($req->_user);
        $contact = Contacts::where([
            'user_to'   => Auth::user()->id,
            'user_from' => $user_id,
            'status'    => '0',
            'locked'    => false
        ])->first();
        
        if(count($contact->toArray())>0){
            try {
                $contact->update(['status' => '1']);
                $notify = new Notify;

                $notify->user_from = Auth::user()->id;
                $notify->user_to   = $user_id;
                $notify->viewed    = false;
                $notify->type      = '0';
                $notify->object    = Auth::user()->id;
                $notify->save();

                CommentPhotoNotify($user_id);
                $response['status'] = 'success';
                $response['message'] = 'Now <b>'.User::find($user_id)->user_name.'</b> is your contact';
            }catch (\Exception $e){
                $response['status'] = 'error';
                $response['message'] = $e->getMessage();
            }
            return json_encode($response);
        }
    }

    public function deletecontact(Request $request)
    {
        //For delete contact, update status field to 2 value
        try{
            $user = decrypt($request->_user);
        }catch (\Exception $e){
            return json_encode([
                'status'    => 'error',
                'message'   => $e->getMessage()
            ]);
        }
        $contact = Contacts::where([
            ['user_from', '=', $user],
            ['user_to', '=', Auth::user()->id]
        ])->orWhere([
            ['user_from', '=', Auth::user()->id],
            ['user_to', '=', $user]
        ])->first();

        if (count($contact)>0) {
            if ($contact->update(['status' => '2'])) {
                return json_encode([
                    'status' => 'success',
                    'message' => 'Removed from your contacts.'
                ]);
            }else{
                return json_encode([
                    'status'    => 'error',
                    'message'   => 'Contact not updated'
                ]);
            }
        }else{
            return json_encode([
                'status'    => 'error',
                'message'   => 'Contact not found'
            ]);
        }
    }

    public function userlike(Request $request)
    {
        if(!$request->_user){
            return json_encode(['status'=>'error','message'=>'Error in request params.']);
        }

        $user = User::find(decrypt($request->_user));
        //dd($user);
        $user->likes()->create([
            'user_id' => Auth::user()->id,
            'status' => '1'
        ]);
        $notify = new Notify;

        $notify->user_from = Auth::user()->id;
        $notify->user_to   = $user->id;
        $notify->viewed    = false;
        $notify->type      = '3';
        $notify->object    = $user->id;
        try{
            $notify->save();

            $html = "<img src='" . asset(Auth::user()->profile->avatar->small) . "' class='responsive-img circle' width='25' style='display:inline-block;vertical-align: middle'> <small>". Auth::user()->user_name." likes you</small>";
            $this->pusher->trigger('private-' . $user->user_name,'event-notify',[
                'text' => $html,
                'from' => encrypt(Auth::user()->id),
                'from_user_name'  => Auth::user()->user_name,
                'image_url' => asset(Auth::user()->profile->avatar->small),
                'str_to_time'=> strtotime(date('Y-m-d H:i:s'))
            ]);

            $response['status'] = 'success';
        }catch (\Exception $e){
            $response['status'] = 'error';
            $response['message'] = $e->getMessage();
        }

        return json_encode($response);
    }

    public function sendMessage(Request $request)
    {
        if($request->_message && $request->_message!=null){
            $decrypt_user = decrypt($request->_user);
            $user = User::find($decrypt_user);

            if(Checks::is_contact($decrypt_user)) {
                $message = new Message();
                $message->user_from = Auth::user()->id;
                $message->user_to   = $decrypt_user;
                $message->message   = $request->_message;
                $message->type      = 0;
                $message->save();

                $html = "<img src='" . asset(Auth::user()->profile->avatar->small) . "' class='responsive-img circle' width='25' style='display:inline-block;vertical-align: middle'> <small>" . substr($request->_message, 0, 20) . "</small>" . (strlen($request->_message) > 20 ? "..." : "");
                try{
                    $test = $this->pusher->trigger('private-' . $user->user_name,'event-message',[
                        'text' => $html,
                        'from' => encrypt(Auth::user()->id),
                        'from_user_name'  => Auth::user()->user_name,
                        'image_url' => asset(Auth::user()->profile->avatar->small),
                        'str_text'  => $request->_message,
                        'str_to_time'=> strtotime(date('Y-m-d H:i:s'))
                    ]);
                    if(!$test){
                        \Log::notice('Error to send pusher message to '.$user->user_name.'.');
                    }

                }catch (\Exception $e){
                    Log::notice($e->getMessage());
                }
                return ['status' => 'success', 'message' => 'Your message is sended'];
            }else{
                return ['status'=>'error','message'=>$user->user_name.' is not your contact.'];
            }
        }else{
            return ['stauts'=>'error','message'=>'Please write your message'];
        }
    }

    public function changestate(Request $request)
    {
        if(!in_array($request->privacy,[0,1,2,3,4])){
            return ['status'=>'error','message'=>'Privacy option not is valid.'];
        }
        if(!$request->state){
            return ['status'=>'error','message'=>'Please insert your state.'];
        }
        $new_state = new Status();

        $new_state->user_id   = Auth::user()->id;
        $new_state->type      = '0';
        $new_state->state     = $request->state;
        $new_state->photo_id  = null;
        $new_state->privacy   = $request->privacy;
        $new_state->tags      = '';
        $new_state->from_ip_address= $request->ip();
        $new_state->status      = '1';

        try{
            $new_state->save();

            $feed = new Newsfeed();

            $feed->user_id   = Auth::user()->id;
            $feed->type      = 0;
            $feed->status    = 1;
            $feed->object    = $new_state->id;
            $feed->save();
        }catch (\Exception $e){
            \Log::notice($e->getMessage());
            return ['status'=>'error','message'=>'Failed to post your state, please try again.'];
        }
        return ['status'=>'success','message'=>'Your state has been published.'];
    }

    public function commentphoto(Request $request)
    {
        if(!$request->comment_photo_text){
            return [
                'status'    => 'error',
                'message'   => 'Please insert your comment.'
            ];
        }
        if(!$request->content_elment){
            return ['status'    => 'error','message'=>'Photo not found'];
        }else {
            try {
                $photo_id = decrypt($request->content_elment);
            }catch (\Exception $e){
                return ['status'=>'error','message'=>$e->getMessage()];
            }
            $photo = Photo::find($photo_id);
            if(!$photo){
                return ['status'    => 'error','message'=>'Photo not found'];
            }
            $user = User::find($photo->user_id);
        }

        try{

            $photo->comments()->create([
                'comment' => $request->comment_photo_text,
                'user_id' => Auth::user()->id,
                'object_id' => $photo_id,
                'object_type' => Photo::class,
                'type' => 1
            ]);
            if($user->id!=Auth::user()->id) {
                $html = "<img src='" . asset(Auth::user()->profile->avatar->small) . "' class='responsive-img circle' width='25' style='display:inline-block;vertical-align: middle'> <small>Comment your photo</small>";
                $this->pusher->trigger('private-' . $user->user_name, 'event-notify', [
                    'text' => $html,
                    'from' => encrypt(Auth::user()->id),
                    'from_user_name' => Auth::user()->user_name,
                    'image_url' => asset(Auth::user()->profile->avatar->small),
                    'str_to_time' => strtotime(date('Y-m-d H:i:s'))
                ]);

                $notify = new Notify;

                $notify->user_from = Auth::user()->id;
                $notify->user_to = $user->id;
                $notify->viewed = false;
                $notify->type = '5';
                $notify->object = $photo_id;
                $notify->save();
            }
        }catch (\Exception $e){
            //return ['status' => 'error', 'message' => 'Error commenting, please try again.'];
            return ['status' => 'error', 'message' => $e->getMessage()];
        }


        return ['status' => 'success', 'message' => 'Your comment is published!'];
    }

    public function likephoto(Request $request)
    {
        if(!$request->photo){
            return ['status'=>'error','message'=>'Photo not found'];
        }
        try {
            $photo_id = decrypt($request->photo);
        }catch (\Exception $e){
            return ['status'=>'error','message'=>$e->getMessage()];
        }
        $photo = Photo::find($photo_id);
        if(!$photo){
            return ['status'=>'error','message'=>'Photo not found.'];
        }
        $user = User::find($photo->user_id);
        //return dd($photo_id);
        if($photo){

            $update_like = Like::where('user_id', Auth::user()->id)
            ->where('object_type', Photo::class)
            ->where('object_id', $photo_id)->first();
            if($update_like!=null) {
                if ($update_like->status == '1') {
                    try {
                        $update_like->update([
                            'status' => '0'
                        ]);
                    } catch (\Exception $e) {
                        return ['status' => 'error', 'message' => 'Error, please try again.'];
                    }
                } else {
                    try {
                        $update_like->update([
                            'status' => '1'
                        ]);
                    } catch (\Exception $e) {
                        return ['status' => 'error', 'message' => 'Error, please try again.'];
                    }
                }
            }else {
                try {
                    $photo->likes()->create([
                        'user_id' => Auth::user()->id,
                        'object_id' => $photo_id,
                        'status' => '1'
                    ]);
                    if($user->id!=Auth::user()->id) {
                        $html = "<img src='" . asset(Auth::user()->profile->avatar->small) . "' class='responsive-img circle' width='25' style='display:inline-block;vertical-align: middle'> <small>".Auth::user()->user_name." like your photo</small>";
                        $this->pusher->trigger('private-' . $user->user_name, 'event-notify', [
                            'text' => $html,
                            'from' => encrypt(Auth::user()->id),
                            'from_user_name' => Auth::user()->user_name,
                            'image_url' => asset(Auth::user()->profile->avatar->small),
                            'str_to_time' => strtotime(date('Y-m-d H:i:s'))
                        ]);

                        $notify = new Notify;

                        $notify->user_from = Auth::user()->id;
                        $notify->user_to = $user->id;
                        $notify->viewed = false;
                        $notify->type = '4';
                        $notify->object = $photo_id;
                        $notify->save();
                    }
                } catch (\Exception $e) {
                    return ['status' => 'error', 'message' => 'Error, please try again.'];
                }
            }
        }
        return ['status'=>'success','message'=>'You like photo'];
    }

    public function commentstate(Request $request)
    {
        if(!$request->comment_state_text){
            return [
                'status'    => 'error',
                'message'   => 'Please insert your comment.'
            ];
        }
        if(!$request->content_elment){
            return ['status'    => 'error','message'=>'Comment not found'];
        }else {
            try {
                $state_id = decrypt($request->content_elment);
            }catch (\Exception $e){
                return ['status'=>'error','message'=>$e->getMessage()];
            }
            $state = State::find($state_id);
            if(!$state){
                return ['status'    => 'error','message'=>'Photo not found'];
            }
            $user = User::find($state->user_id);
        }

        try{

            $state->comments()->create([
                'comment' => $request->comment_state_text,
                'user_id' => Auth::user()->id,
                'object_id' => $state_id,
                'object_type' => State::class,
                'type' => 1
            ]);
            if($user->id!=Auth::user()->id) {
                $html = "<img src='" . asset(Auth::user()->profile->avatar->small) . "' class='responsive-img circle' width='25' style='display:inline-block;vertical-align: middle'> <small>Comment your state</small>";
                $this->pusher->trigger('private-' . $user->user_name, 'event-notify', [
                    'text' => $html,
                    'from' => encrypt(Auth::user()->id),
                    'from_user_name' => Auth::user()->user_name,
                    'image_url' => asset(Auth::user()->profile->avatar->small),
                    'str_to_time' => strtotime(date('Y-m-d H:i:s'))
                ]);

                $notify = new Notify;

                $notify->user_from = Auth::user()->id;
                $notify->user_to = $user->id;
                $notify->viewed = false;
                $notify->type = '6';
                $notify->object = $state_id;
                $notify->save();
            }
        }catch (\Exception $e){
            //return ['status' => 'error', 'message' => 'Error commenting, please try again.'];
            return ['status' => 'error', 'message' => $e->getMessage()];
        }


        return ['status' => 'success', 'message' => 'Your comment is published!'];
    }

    public function likestate(Request $request)
    {
        if(!$request->state){
            return ['status'=>'error','message'=>'State not found'];
        }
        try {
            $state_id = decrypt($request->state);
        }catch (\Exception $e){
            return ['status'=>'error','message'=>$e->getMessage()];
        }
        $state = State::find($state_id);
        //return $state;
        if(!$state){
            return ['status'=>'error','message'=>'State not found.'];
        }
        $user = User::find($state->user_id);
        //return dd($photo_id);
        if($state){

            $update_like = Like::where('user_id', Auth::user()->id)
                ->where('object_type', State::class)
                ->where('object_id', $state_id)->first();
            if($update_like!=null) {
                if ($update_like->status == '1') {
                    try {
                        $update_like->update([
                            'status' => '0'
                        ]);
                    } catch (\Exception $e) {
                        return ['status' => 'error', 'message' => 'Error, please try again.'];
                    }
                } else {
                    try {
                        $update_like->update([
                            'status' => '1'
                        ]);
                    } catch (\Exception $e) {
                        return ['status' => 'error', 'message' => 'Error, please try again.'];
                    }
                }
            }else {
                try {
                    $state->likes()->create([
                        'user_id' => Auth::user()->id,
                        'object_id' => $state_id,
                        'status' => '1'
                    ]);
                    if($user->id!=Auth::user()->id) {
                        $html = "<img src='" . asset(Auth::user()->profile->avatar->small) . "' class='responsive-img circle' width='25' style='display:inline-block;vertical-align: middle'> <small>".Auth::user()->user_name." like your state</small>";
                        $this->pusher->trigger('private-' . $user->user_name, 'event-notify', [
                            'text' => $html,
                            'from' => encrypt(Auth::user()->id),
                            'from_user_name' => Auth::user()->user_name,
                            'image_url' => asset(Auth::user()->profile->avatar->small),
                            'str_to_time' => strtotime(date('Y-m-d H:i:s'))
                        ]);

                        $notify = new Notify;

                        $notify->user_from = Auth::user()->id;
                        $notify->user_to = $user->id;
                        $notify->viewed = false;
                        $notify->type = '7';
                        $notify->object = $state_id;
                        $notify->save();
                    }
                } catch (\Exception $e) {
                    return ['status' => 'error', 'message' => 'Error, please try again.'];
                }
            }
        }
        return ['status'=>'success','message'=>'You like state'];
    }
}
