<?php
/**
 * Created by PhpStorm.
 * User: ma3xc
 * Date: 19/09/2016
 * Time: 12:47
 */

namespace Pheaks\Http\Libraries;

use Auth;
use Pheaks\Comment;
use Pheaks\Contacts;
use Pheaks\Like;
use Pheaks\Photo;
use Pheaks\Post;
use Pheaks\Profiles;
use Pheaks\State;
use Pheaks\User;

class Checks
{
    public function __construct()
    {

    }

    public static function is_contact($user_id=null)
    {
        $contact = \Pheaks\Contacts::where([
                'user_to'   => Auth::user()->id,
                'user_from'   => $user_id,
                'locked'    => false,
                'status'    => 1
            ])->orWhere([
                'user_from' => Auth::user()->id,
                'user_to'   => $user_id,
                'locked'    => false,
                'status'    => 1
            ])->get();

        return count($contact->toArray())>0 ? true :  false;
    }

    public static function is_bloqued($user_id=null)
    {
        if($user_id!==null){
            //$select = Db::table('blocked')->get();
        }else{
            return false;
        }
    }

    public static function is_liked($type=null,$object=null)
    {
        if($type!=null){
            switch ($type){
                case 'contact':
                    $query = new Contacts();
                    break;
                case 'post':
                    $query = new Post();
                    break;
                case 'state':
                    $query = Like::where('object_id','=',$object)
                        ->where('object_type','=',State::class)
                        ->where('user_id','=',Auth::user()->id)
                        ->where('status','=','1')->first();
                    break;
                case 'photo':
                    $query = Like::where('object_id','=',$object)
                    ->where('object_type','=',Photo::class)
                    ->where('user_id','=',Auth::user()->id)
                    ->where('status','=','1')->first();
                    break;
                case 'user':
                    $query = Like::where('object_id','=',$object)
                    ->where('object_type','=',User::class)
                    ->where('user_id','=',Auth::user()->id)
                    ->where('status','=','1')->first();
                    break;

                default :
            }
            //dd($query);
            return ($query !== null && count($query->toArray())>0) ? true : false;
        }
    }

    static function contact_is_request($user_id=null){
        $contact = \Pheaks\Contacts::where('user_to',Auth::user()->id)
            ->where('user_from', $user_id)
            ->where('status',0)->get();

        if(count($contact->toArray())>0){
            return true;
        }else{
            return false;
        }
    }

    public static function contact_request_sended($user_id=null)
    {
        $contact = \Pheaks\Contacts::where('user_from',Auth::user()->id)
        ->where('user_to', $user_id)
        ->where('status',0)->get();

        if(count($contact->toArray())>0){
            return true;
        }else{
            return false;
        }
    }
}