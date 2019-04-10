<?php
/**
 * Created by PhpStorm.
 * User: ma3xc
 * Date: 10/11/2016
 * Time: 9:42
 */

namespace Pheaks\Http\Controllers\Admin;


use McKay\Flash;
use Pheaks\Http\Controllers\Controller;
use Auth;
use Pheaks\User;

class AdminCtrl extends Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->middleware('admin');
    }

    public function index()
    {
        return view('admin.index');
    }

    public function users()
    {
        $users = User::where('id','!=',Auth::user()->id)->get();
        return view('admin.users')->with(['users'=>$users,'page_title'=>'Users']);
    }

    public function recommend_users()
    {
        
    }
}