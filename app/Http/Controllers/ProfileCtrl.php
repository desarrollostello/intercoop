<?php

namespace Pheaks\Http\Controllers;

use Illuminate\Http\Request;

use Pheaks\Contacts;
use Pheaks\Http\Libraries\Checks;
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

    public function messages(Request $request)
    {
        $user_id = Auth::user()->id;
        $msg = null;
        $messages = $this->__listMessagesContacts($user_id);
        foreach ($messages as $key => $sub_msg){
            $msg[$key] = Message::select(DB::raw('*, IF(user_from = '.$user_id.', user_to, user_from) AS last_user'))
                ->where('id',$sub_msg->new_id)
                ->orderBy('created_at','desc')->get();
        }
        $colle = collect($msg);

        if($msg[0]!=null) {
            $first_messages = Message::join('users', function ($join) {
                $join->on('users.id', '=', 'messages.user_from')->orOn('users.id', '=', 'messages.user_to');
            })->select(DB::raw('*,messages.created_at as created'))
                ->where(function ($query) use ($msg) {
                    $query->where([
                        'messages.user_from' => Auth::user()->id,
                        'messages.user_to' => $msg[0]->last()->last_user
                    ]);
                })->orWhere(function ($query) use ($msg) {
                    $query->where([
                        'messages.user_to' => Auth::user()->id,
                        'messages.user_from' => $msg[0]->last()->last_user
                    ]);
                })->groupBy('messages.id')->get();
        }
        //dd($first_messages);
        return view('profile.messages', ['tap_title'=>'Messages','messages'=>$msg ? $msg : null,'first_messages'=>isset($first_messages)?$first_messages:null]);
    }

    public function messagesUser($u_id)
    {
        $contact_id = decrypt($u_id);
        $user_id = Auth::user()->id;
        $msg = null;
        $messages = $this->__listMessagesContacts($user_id);
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

    public function showmessages($id, Request $request){
        if($request->ajax()){
            $id = decrypt($id);
            if($id == Auth::user()->id){
                $response = "<li>
                    <a class='orange lighten-1'>
                        <p>Unable display messages</p>
                    </a>
                </li>";
                return $response;
            }
            if(Checks::is_contact($id)) {
                $first_messages = Message::join('users', function ($join) {
                    $join->on('users.id', '=', 'messages.user_from')->orOn('users.id', '=', 'messages.user_to');
                })->where('users.status','1')->select(DB::raw('*,messages.created_at as created'))
                    ->where(function ($query) use ($id) {
                        $query->where([
                            'messages.user_from' => Auth::user()->id,
                            'messages.user_to' => $id
                        ]);
                    })->orWhere(function ($query) use ($id) {
                        $query->where([
                            'messages.user_to' => Auth::user()->id,
                            'messages.user_from' => $id
                        ]);
                    })->groupBy('messages.id')->get();

                return view('partials.showmessages')->with(['messages' => $first_messages]);
            }else{
                $response = "<li>
                    <a class='orange lighten-1'>
                        <p>".User::find($id)->user_name." not is your contact</p>
                    </a>
                </li>";
                return $response;
            }
        }else{
            return abort(404);
        }
    }

    protected function __listMessagesContacts($user_id)
    {
        $messages = DB::select("
            SELECT MAX(m.id) AS new_id
            FROM messages m
            WHERE CASE WHEN m.user_from = $user_id THEN m.user_from END
            OR CASE WHEN m.user_to = $user_id THEN m.user_to END
            GROUP BY CASE WHEN m.user_from = $user_id THEN m.user_to ELSE CASE WHEN m.user_to = $user_id THEN m.user_from END END
            ORDER BY new_id DESC
        ");

        return $messages;
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
        $visitors = Visitor::where(['user_to'=>Auth::user()->id]);
        //dd($visitors);
    	return view('profile.visitors', ['tap_title'=>'Visitors','visitors'=>$visitors]);
    }

    public function likes()
    {
        $all_likes = Like::where('object_type',User::class)
        ->where('user_id',Auth::user()->id)
        ->orWhere('object_id',Auth::user()->id)->get();
        //dd($all_likes);
        return view('profile.likes',['likes'=>$all_likes]);
    }

    public function edit()
    {
        return view('profile.edit', ['tap_title'=>'Edit profile']);
    }
}
