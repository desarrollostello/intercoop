<?php

namespace Pheaks\Http\Controllers;

use Carbon\Carbon;
use Faker\Provider\UserAgent;
use Hashids;
use Illuminate\Http\Request;

use Illuminate\Http\Response;
use Pheaks\Http\Requests;
use Pheaks\Message;
use Pheaks\Newsfeed;
use Pheaks\Notify;
use Pheaks\Photo;
use Auth;
use Pheaks\State;

class GetAjaxCtrl extends Controller
{
    public function __construct(Request $request)
    {
        parent::__construct();
        if(!$request->ajax()){
            return abort(404);
        }
    }

    public function getRegions(Request $request)
    {
        if(!Auth::check()){
            return (new Response)->setStatusCode(402, 'Please first login.');
        }
        $regions = \Pheaks\Regions::where('country',$request->iso_code)->get();
        return json_encode($regions);
    }

    public function getCities(Request $request)
    {
        if(!Auth::check()){
            return (new Response)->setStatusCode(402, 'Please first login.');
        }
        $cities = \Pheaks\Cities::where('country', $request->country)->where('region', $request->region)->get();
        return json_encode($cities);
    }

    public function showPhoto(Request $request)
    {
        if(!Auth::check()){
            return (new Response)->setStatusCode(402, 'Please first login.');
        }
        $device = $this->agent->device();

        $photo_id = decrypt($request->_phot_id);
        $photo_data = Photo::where(['id'=>$photo_id,'status'=>'1'])->first();
        if(empty($photo_data)){
            return ['status'=>'error','message'=>'Photo not found.'];
        }
        //dd($photo_data->likes);
        $devide_detect = new \Jenssegers\Agent\Agent();

        if($devide_detect->isMobile()){
            return view('modals.show-photo-mobile', ['photo_info' => $photo_data]);
        }else {
            return view('modals.show-photo', ['photo_info' => $photo_data]);
        }
    }

    public function editphoto(Request $request)
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
            return view('modals.edit-photo')->with(['photo'=>$photo_info]);
        }else{
            return ['status'=>'error','message'=>'Photo not found.'];
        }
    }

    public function getNotifies()
    {
        if(!Auth::check()){
            return (new Response)->setStatusCode(402, 'Please first login.');
        }
        $notifies = Notify::where('notifies.user_to', Auth::user()->id)
            //->where('viewed',false)
            ->whereIn('notifies.status', ['','0','1',null])->orderBy('created_at','desc')->limit(10);
        //return dd($notifies);
        echo view('partials.notifies')->with(['notifies'=>$notifies->get(),'more'=>true]);
        $notifies->update(['viewed'=>true]);
        return;
    }

    public function getMoreNotifies(Request $request)
    {
        if(!Auth::check()){
            return (new Response)->setStatusCode(402, 'Please first login.');
        }
        if(!$request->last){
            return ['status'=>'error','message'=>'Unrecognized last field'];
        }
        $last_id = \Hashids::decode($request->last);
        $notifies = Notify::where('notifies.user_to', Auth::user()->id)
            //->where('viewed',false)
            ->where('id','<',$last_id)
            ->whereIn('notifies.status', ['','0','1',null])->orderBy('created_at','desc')->limit(5);
        //return dd($notifies);
        echo view('partials.notifies')->with(['notifies'=>$notifies->get(),'more'=>false]);
        $notifies->update(['viewed'=>true]);
        return;
    }

    public function getMessages()
    {
        if(!Auth::check()){
            return (new Response)->setStatusCode(402, 'Please first login.');
        }
        $messages = Message::where([
            'messages.user_to'   => Auth::user()->id,
            'messages.status'    => 1 || null,
        ])
        ->orderBy('messages.id','des')
        ->groupBy('messages.user_from');
        echo view('partials.messages')->with(['messages'=>$messages->get()]);
        $messages->update(['messages.viewed'=>'1']);
        return;
    }

    public function getMoreMessages($lastMessage)
    {
        if(!Auth::check()){
            return (new Response)->setStatusCode(402, 'Please first login.');
        }
    }

    public function morefeedcomments(Request $request)
    {
        if(!$request->last||!$request->type||!$request->object){
            return ['status'=>'error','messages'=>'Unknown error'];
        }
        try{
            $last_id = Hashids::decode($request->last);
            $type   = Hashids::decode($request->type);
            $object = Hashids::decode($request->object);
        }catch (\Exception $e){
            return ['status'=>'error','message'=>$e->getMessage()];
        }
        //dd($last_id);
        if(is_array($last_id)&&is_array($type)&&is_array($object)){
            if(array_key_exists('0', $last_id)&&array_key_exists('0', $type)&&array_key_exists('0', $object)){
                switch ($type[0]){
                    case 0:
                        $comments = State::find($object[0])->comments()->where('id','<',$last_id[0])->orderBy('id','desc')->limit(5)->get();
                        if($comments->count()>0) {
                            return view('partials.comments-feed')->with(['comments' => $comments]);
                        }else{
                            return ['status'=>'success','message'=>'No more comments.'];
                        }
                        break;
                    case 1:

                        break;
                    case 2:
                        $comments = Photo::find($object[0])->comments()->where('id','<',$last_id[0])->orderBy('id','desc')->limit(5)->get();
                        if($comments->count()>0) {
                            return view('partials.comments-feed')->with(['comments' => $comments]);
                        }else{
                            return ['status'=>'success','message'=>'No more comments.'];
                        }
                        break;
                    case 3:

                        break;
                    case 4:

                        break;
                    default:
                        return ['status'=>'error','message'=>'Content not found'];
                }
            }else{
                return ['status'=>'error','messages'=>'Unknown error'];
            }
        }else{
            return ['status'=>'error','messages'=>'Unknown error'];
        }
    }

    public function morefeeds(Request $request){
        if(!$request->last){
            return ['status'=>'error','message'=>'Could not get last article.'];
        }
        $last_article = Hashids::decode($request->last);
        //return $last_article[0];
        $feeds = Newsfeed::where('newsfeed.id','<',$last_article[0])
            ->where('newsfeed.status','=',1)
            ->leftJoin('users','newsfeed.user_id','=','users.id')
            ->leftJoin('photos','users.id','=','photos.user_id')
            ->leftJoin('profiles','users.id','=','profiles.user_id')
            ->leftJoin('states','users.id','=','states.user_id')
            ->where('photos.is_avatar', true)
            ->where('profiles.sex_preference','!=',"''")
            ->where('users.sex','=',\Auth::user()->profile->sex_preference)
            ->where('photos.status', '=', '1')
            ->where('users.status', '=', '1')
            ->select([
                'newsfeed.id as feed_id', 'newsfeed.type','newsfeed.user_id','newsfeed.status','newsfeed.object','newsfeed.created_at',
                'users.id as user_id','users.user_name','users.first_name','users.last_name','users.sex',
                'photos.id','photos.original','photos.large','photos.medium','photos.small'
            ])
            ->limit(4)
            ->groupBy('newsfeed.id')
            ->orderBy('newsfeed.id', 'desc')->get();

        return view('partials.ajax-feeds')->with(['feeds'=>$feeds]);
    }
}
