<?php

namespace Pheaks\Http\Controllers;

use Illuminate\Http\Request;

use Pheaks\Contacts;
use Pheaks\Http\Requests;
use Auth;
use Illuminate\Support\Facades\DB;
use Pheaks\Like;
use Pheaks\Message;
use Pheaks\Photo;
use Pheaks\User;
use Pheaks\Visitor;

class ProfileCtrl extends Controller
{
	public function __construct()
	{
        parent::__construct();
	}
    public function index()
    {
        $user_images = Photo::where([
            ['user_id'  , '=', Auth::user()->id],
            ['status', '=', 1]
        ])->orderBy('id','desc')->get();
    	return view('profile.index', ['tap_title'=>'Profile','user_images'=>$user_images]);
    }
    public function messages()
    {
        $mi_id = Auth::user()->id;
        $msg = null;
        $messages = DB::select("
            SELECT IF(user_from = $mi_id, user_to, user_from) AS user_where,
              IF(user_to = $mi_id, user_to, user_from) AS my, (
              SELECT MAX(id) as wid
              where id = id
            ) as m
            FROM messages p
            WHERE (
              IF(user_from = $mi_id, user_from, user_to)
            ) = $mi_id
            GROUP BY user_where
            ORDER BY id DESC 
        ");
        foreach ($messages as $key => $sub_msg){
            if(User::where('id',$sub_msg->user_where)->first()->status!=1){
                continue;
            }
            $msg[$key] = Message::select(DB::raw('*, IF(user_from = '.$mi_id.', user_to, user_from) AS last_user'))
                ->where('messages.id',$sub_msg->m)
                ->GroupBy('messages.user_from','messages.user_to')
                ->orderBy('messages.id','asc')->get();
            //echo User::find($sub_msg->user_where)->user_name ." - ";
            //echo $msg[$key][0]->message;
            //echo "<br><br>";
        }

        /*$all_messages = !empty($msg[0]) ?  Message::select('*')->where([
            'user_from' => $msg[0][0]->last_user
        ])->orderBy('id','desc')->get() : null;*/
        /*
         dd($messages);
        foreach ($messages as $key => $sub_msg){
            $msg[$key] = Message::select(DB::raw('*, IF(user_from = '.$mi_id.', user_to, user_from) AS user_where'))
            ->where('messages.id',$sub_msg->m)
            ->orderBy('messages.id','asc')->get();
        }

        foreach ($msg as $k => $m){
            //echo User::find($msg[$key][0]->user_where)->user_name ." : ";
            echo $m[0]->message;
            echo "<br><br>";
        }
        return;

        ->orWhere('messages.user_from', Auth::user()->id)
        ->orWhere('messages.user_to', Auth::user()->id)

        ->join('users','users.id','=','messages.user_where')
        ->leftJoin('profiles','profiles.user_id','=','messages.user_where')
        ->leftJoin('photos','photos.id','=','profiles.avatar_photo_id')
        ->orderBy('messages.id','asc');*/

    	return view('profile.messages', ['tap_title'=>'Messages','messages'=>$msg ? $msg : null]);
    }

    public function contacts()
    {
        //dd(Request::getTrustedHosts());
        /*$contacts = Contacts::where('contacts.user_from',Auth::user()->id)
            ->orWhere('contacts.user_to', Auth::user()->id)
            ->leftJoin('users','contacts.user_from','=','users.id')->get();*/
        //dd($contacts);
        /*$contacts = User::whereExists(function($query){
                $query->select(DB::raw(1))->from('contacts')
                    ->whereIn('contacts.status',[0,1])
                    ->where('locked',false)
                    ->whereRaw('contacts.user_to = '.Auth::user()->id)
                    ->orWhereRaw('contacts.user_from = '.Auth::user()->id);
            })
            ->where('users.id','!=',Auth::user()->id)
            ->where('users.status','=','1')
            ->leftJoin('profiles','users.id','=','profiles.user_id')
            ->get();*/
        $contacts = Contacts::whereIn('contacts.status',[0,1])->where('user_from',Auth::user()->id)->orWhere('user_to',Auth::user()->id)->get();

    	return view('profile.contacts', ['tap_title'=>'Contacts','users'=>$contacts]);
    }

    public function visitors()
    {
        /*$visitors = Visitor::where(['visitors.user_to'=>Auth::user()->id])
            ->join('users','visitors.user_from', '=', 'users.id')
            ->where('users.status','=','1')
            ->get();*/
        $visitors = Visitor::where(['visitors.user_to'=>Auth::user()->id])
            ->select('visitors.*', 'users.status as user_status')
            ->join('users','visitors.user_from', '=', 'users.id')
            ->get();

        //dd($visitors);
        return view('profile.visitors', ['tap_title'=>'Visitors','visitors'=>$visitors]);
    }

    public function likes()
    {
        $all_likes = Like::where('object_type',User::class)
            ->where('status','1')
            ->where('user_id',Auth::user()->id)
            ->orWhere('object_id',Auth::user()->id)
            ->groupBy('user_id','object_id')
            ->get();
        //dd($all_likes);
        return view('profile.likes', ['tap_title'=>'Likes','likes'=>$all_likes]);
    }

    public function edit()
    {
        return view('profile.edit', ['tap_title'=>'Edit profile']);
    }
}
