<?php

namespace Pheaks\Exceptions;

use McKay\Flash,
    Request,
    Exception,
    Illuminate\Validation\ValidationException,
    Illuminate\Auth\Access\AuthorizationException,
    Illuminate\Database\Eloquent\ModelNotFoundException,
    Symfony\Component\HttpKernel\Exception\HttpException,
    Illuminate\Foundation\Exceptions\Handler as ExceptionHandler,
    OAuth\Common\Http\Exception\TokenResponseException,
    Illuminate\Session\TokenMismatchException,
    Symfony\Component\HttpKernel\Exception\NotFoundHttpException,
    View,
    Auth,
    Route;
use \Illuminate\Session\Middleware\StartSession;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
        \Illuminate\Session\Middleware\StartSession::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $e
     * @return void
     */
    public function report(Exception $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $e
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
        /*if ($e instanceof ModelNotFoundException) {
            $e = new NotFoundHttpException($e->getMessage(), $e);
        }

        if(Request::isMethod('post')){
            if ( !Input::get('_token')) {
                //throw new Illuminate\Session\TokenMismatchException;
                Flash::toastInfo('Token match exeption.');
                return redirect()->route('login')->with('flash', Flash::all());
            }
        }

        if ($e instanceof TokenMismatchException) {
            Flash::toastInfo('Token match exeption.');
            return redirect()->route('login')->with('flash', Flash::all());
        }*/

        if($e instanceof TokenResponseException){
            switch ($e->getCode()){
                case 500:
                    $message = "Internal server error";
                    break;
                case 400:
                    $message = "Page not found.";
                    break;
                default:
                    $message = "Unknown error ocurrent.";
            }
            if($request->ajax()){
                $response['status'] = 'error';
                $response['message']= $message;
                return response()->json($response);
            }else {
                Flash::toastError($message);
                return redirect()->back()->with('flash', Flash::all());
            }
        }
        if ($e instanceof NotFoundHttpException){
            if($request->ajax()){

            }else{
                View::share(['routename'=> 'NotFound','flash'=>$request]);
            }
        }
        if ($e instanceof TokenMismatchException) {
            if($request->ajax()){
                $response['status'] = 'error';
                $response['message']= 'Token error.';
                return response()->json($response);
            }else {
                Flash::toastError('Unknown error.');
                return redirect('/')->with('flash', Flash::all());
            }
        }
        if($e instanceof MethodNotAllowedHttpException){
            $message = $e->getMessage();
            Flash::toastError($message);
            return redirect()->back()->with('flash', Flash::all());
        }
        return parent::render($request, $e);
    }
}
