<?php

namespace Pheaks\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Support\Facades\App;
use Pheaks\Http\Requests;
use Pheaks\Newsfeed;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Pheaks\Http\Libraries\Flash;
use Pheaks\User;
use Pheaks\Message;
use Auth;

class HomeCtrl extends Controller
{
	public function __construct(){
	    parent::__construct();
        //App::setLocale('es');
        //Carbon::setLocale('es');
		$this->middleware('auth');
	}
    public function index()
    {
        $feed = Newsfeed::where('newsfeed.status','=',1)
            ->leftJoin('users','newsfeed.user_id','=','users.id')
            ->leftJoin('photos','users.id','=','photos.user_id')
           // ->leftJoin('profiles','users.id','=','profiles.user_id')
          //  ->leftJoin('states','users.id','=','states.user_id')
           // ->where('photos.is_avatar', true)
            //->where('profiles.sex_preference','!=',"''")
            //->where('users.sex','=',\Auth::user()->profile->sex_preference)
          //  ->where('photos.status', '=', '1')
          //  ->where('users.status', '=', '1')
            ->select([
                'newsfeed.id as feed_id', 'newsfeed.type','newsfeed.user_id','newsfeed.status','newsfeed.object','newsfeed.created_at',
                'users.id as user_id','users.user_name','users.first_name','users.last_name','users.sex',
                'photos.id','photos.original','photos.large','photos.medium','photos.small'
            ])
            ->groupBy('newsfeed.id')
            ->limit(5)
            ->orderBy('newsfeed.id', 'desc')->get();
    	return view('home.index', ['feeds'=>$feed]);
    }

    public function m_user($u_id)
    {
        try {
            $contact_id = decrypt($u_id);
        }catch (\Exception $e){
            abort(404, $e->getMessage());
        }

        if(User::where('id',$contact_id)->first()->status!='1'){
            return abort(404, 'User not found.');
        }
        $user_id = Auth::user()->id;
        $msg = null;
        $messages = DB::select("
            SELECT MAX(m.id) AS new_id
            FROM messages m
            WHERE CASE WHEN m.user_from = $user_id THEN m.user_from END
            OR CASE WHEN m.user_to = $user_id THEN m.user_to END
            GROUP BY CASE WHEN m.user_from = $user_id THEN m.user_to ELSE CASE WHEN m.user_to = $user_id THEN m.user_from END END
            ORDER BY new_id DESC
        ");

        foreach ($messages as $key => $sub_msg){
            $msg[$key] = Message::select(DB::raw('*, IF(user_from = '.$user_id.', user_to, user_from) AS last_user'))
                ->where('id',$sub_msg->new_id)
                ->orderBy('created_at','desc')->get();
        }
        $colle = collect($msg);

        $first_messages = Message::join('users', function ($join) {
            $join->on('users.id', '=', 'messages.user_from')->orOn('users.id', '=', 'messages.user_to');
        })->select(DB::raw('*,messages.created_at as created'))
            ->where(function($query) use($contact_id){
                $query->where([
                    'messages.user_from'  => Auth::user()->id,
                    'messages.user_to'    => $contact_id
                ]);
            })->orWhere(function($query) use($contact_id){
                $query->where([
                    'messages.user_to'  => Auth::user()->id,
                    'messages.user_from'    => $contact_id
                ]);
            })->groupBy('messages.id')->get();
        //dd($contact_id);
        return view('profile.messages-user', ['tap_title'=>User::find($contact_id)->user_name,'messages'=>$msg ? $msg : null,'first_messages'=>$first_messages]);
    }

    public function pusherAuth(Request $request){
	    if($request->channel_name&&$request->channel_name!=null&&$request->socket_id&&$request->socket_id!=null) {
            return $this->pusher->socket_auth($request->channel_name, $request->socket_id);
        }
    }
}
