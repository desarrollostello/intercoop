<?php

namespace Pheaks\Http\Controllers;

use Illuminate\Http\Request;

use Pheaks\Http\Requests;
use Pheaks\Http\Libraries\Flash;
use Auth;
use Illuminate\Support\Facades\DB;
use Pheaks\User;

class SearchCtrl extends Controller
{
    public function __construct()
    {
    	parent::__construct();
    }

    public function index()
    {
        if(!Auth::user()->profile->sex_preference){
            Flash::toastWarning('Please complete your profile.');
            return redirect(route('profile-edit'))->with('flash', Flash::all());
        }

        /*$user = \Pheaks\User::where('id','!=',Auth::user()->id)
            //->where('')
            ->limit(1)
            ->orderByRaw("RAND()")
            ->get();*/
        DB::enableQueryLog();
        $user = User::whereNotExists(function($query){
                $query->from('contacts')
                    ->whereIn('contacts.status',[0,1])
                    ->where('contacts.locked',false)
                    ->where('contacts.user_from',Auth::user()->id)
                    ->whereRaw('contacts.user_to = users.id');
            })
            ->WhereNotExists(function($query){
                $query->from('contacts')
                    ->whereIn('contacts.status',[0,1])
                    ->where('contacts.locked',false)
                    ->where('contacts.user_to',Auth::user()->id)
                    ->whereRaw('contacts.user_from = users.id');
            })
            ->where('users.id','!=',Auth::user()->id)
            ->where('profiles.sex_preference','!=',"")
            ->where('users.sex','=',Auth::user()->profile->sex_preference)
            ->where('profiles.sex_preference',Auth::user()->sex)
            ->where('users.status','!=','0')
            ->leftJoin('profiles','users.id','=','profiles.user_id')
            ->limit(1)
            ->orderByRaw("RAND()")
            ->get();
        //dd($user);
    	return view('search.index', ['tap_title'=>'Search','user'=>@$user[0] ? $user[0] : null]);
    }
}
