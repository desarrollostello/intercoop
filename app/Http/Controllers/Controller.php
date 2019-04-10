<?php

namespace Pheaks\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesResources;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Pheaks\Message;
use Pheaks\Notify;
use Session;
use Auth;
use View;
use Route;
use App;
use JavaScript;

class Controller extends BaseController
{
    public $agent;
    public $pusher;
	public function __construct()
	{
		/*if(Request::isMethod('post')){
			if ( Session::getToken() != Input::get('_token')) {
        		//throw new Illuminate\Session\TokenMismatchException;
        		return view('errors.503');
    		}
		}*/
		if(!Auth::check()){
		    Session::put('role', 'guest');

        }else{
            Session::put('role', Auth::user()->role);
            $this->pusher = App::make('pusher');
            $message = Message::where(['messages.user_to'=>Auth::user()->id,'messages.viewed'=>false,'messages.status'=>'1'])
                ->join('users','messages.user_from','=','users.id')
                ->where('users.status','1')
                ->count();
            $notifies = Notify::where(['notifies.user_to'=>Auth::user()->id,'notifies.viewed'=>false])
                ->join('users','notifies.user_from','=','users.id')
                ->where('users.status','1')
                ->count();
            JavaScript::put([
                'id'        => Auth::user()->id,
                'crypted_id'=> encrypt(Auth::user()->id),
                'user_name' => Auth::user()->user_name,
                'first_name'=> Auth::user()->first_name,
                'last_name' => Auth::user()->last_name,
                'lang'      => Auth::user()->language
            ]);
            /*if(Auth::user()->language){
                Carbon::setLocale(Auth::user()->language);
                App::setLocale(Auth::user()->language);
            }else{
                $lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2);

                Carbon::setLocale($lang);
                App::setLocale($lang);
            }*/
        }
        $this->agent = new \Agent();

        View::share([
            'routename' => Route::currentRouteName(),
            'count_messages'    => @$message ? $message : null,
            'count_notifies'    => @$notifies ? $notifies : null
        ]);
	}
    use AuthorizesRequests, AuthorizesResources, DispatchesJobs, ValidatesRequests;

    public function __destruct()
    {
    	
    }
}
