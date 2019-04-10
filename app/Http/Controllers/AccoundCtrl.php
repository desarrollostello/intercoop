<?php

namespace Pheaks\Http\Controllers;

use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Log;

use Pheaks\Http\Libraries\Flash;
use Pheaks\Http\Requests;
use Pheaks\Http\Libraries\Checks;
use Auth;
use Pheaks\Notify;
use Pheaks\Photo;
use Pheaks\Profiles;
use Pheaks\User;
use Exception;
use Pheaks\Visitor;
use phpDocumentor\Reflection\Types\Array_;

class AccoundCtrl extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function accound($user_id=null)
    {

        if($user_id!=null) {
            try{
                $decrypt_userId = decrypt($user_id ? $user_id : request('key'));
            }catch (Exception $e){
                Flash::toastError($e->getMessage());
                return redirect()->back()->with('flash', Flash::all());
            }

            if(Auth::check()){
                if ($decrypt_userId == Auth::user()->id) {
                    return redirect(route('profile'));
                }
            }
            $user = User::where('id', $decrypt_userId)
                //->where('users.id','=',$decrypt_userId)
                ->where('users.status', 1)->get();
            $images = Photo::where([
                'user_id'   => $decrypt_userId,
                'status'    => 1,
                'privacy'   => 1
            ])->orderBy('id', 'desc')->get();

            if(Auth::check()) {
                if($user) {
                    try{
                        $html = "<a href='".route('accound', encrypt(Auth::user()->id))."' class='white-text'><img src='" . asset(Auth::user()->profile->avatar->small) . "' class='responsive-img circle' width='25' style='display:inline-block;vertical-align: middle'> <small>visit your profile</small></a>";
                        $test = $this->pusher->trigger('private-' . $user->first()->user_name,'event-notify',[
                            'text' => $html,
                            'from' => encrypt(Auth::user()->id),
                            'from_user_name'  => Auth::user()->user_name,
                            'image_url' => asset(Auth::user()->profile->avatar->small),
                            'str_to_time'=> strtotime(date('Y-m-d H:i:s')),
                            'type'  => 'visit'
                        ]);
                        if(!$test){
                            Log::notice('Error to send pusher message to '.$user->first()->user_name.'.');
                        }

                    }catch (\Exception $e){
                        Log::notice($e->getMessage());
                    }

                    try{
                        $visitor = Visitor::where([
                            'user_from' => Auth::user()->id,
                            'user_to'  => $decrypt_userId,
                        ])->firstOrFail();
                        //dd($visitor);
                        $visitor->update([
                            'count_visits' => $visitor->count_visits + 1
                        ]);
                        $visitor->touch();
                    }catch (Exception $e){
                        Visitor::create([
                            'user_from' => Auth::user()->id,
                            'user_to'   => $decrypt_userId,
                            'count_visits'  => 1
                        ]);
                        $notify = new Notify();
                        $notify->user_from = Auth::user()->id;
                        $notify->user_to = $decrypt_userId;
                        $notify->status = 1;
                        $notify->viewed = false;
                        $notify->type = 8;
                        $notify->object = Auth::user()->id;
                        $notify->save();
                    }
                }

                return view('accound.index', [
                    'tap_title' => @$user[0] ? $user[0]->user_name : null,
                    'user' => @$user[0] ? $user[0] : null,
                    'users_images' => $images
                ]);
            }else{
                return view('accound.unlogget', [
                    'tap_title' => @$user[0] ? $user[0]->user_name : null,
                    'user' => @$user[0] ? $user[0] : null,
                    'users_images' => $images
                ]);
            }
        }elseif($user_id == "activate"){
            $this->activate();
        }else{
           return abort(404);
        }
    }

    public function activate(Request $request)
    {
        if($request->key&&$request->hash)
        {
            try{
                $user_id = decrypt($request->key);
            }catch(\Exception $e){
                Flash::toastError($e->getMessage());
                return redirect()->route(Auth::check() ? 'home' : 'login')->with('flash', Flash::all());
            }

            $user = User::where('id','=',$user_id)->where('status','=','0')->first();

            $update_status = $user!=null ? $user->update(['status' => '1']) : null;

            if($update_status) {
                Flash::toastSuccess('Your accound has been activated.');
                Auth::login($user);
            }else{
                Flash::toastInfo('Your account is already active.');
            }
            return redirect()->route(Auth::check() ? 'home' : 'login')->with('flash', Flash::all());
        }
    }
}
