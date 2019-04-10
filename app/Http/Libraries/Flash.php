<?php
namespace Pheaks\Http\Libraries;

use \McKay\Flash as ToastFlash;

/**
 * 
 */
class Flash extends ToastFlash
{	
	//Material personalized messages
	public static function toastError  ($message = NULL) {
		return static::message('red',   $message);
	}
	public static function toastInfo   ($message = NULL) {
		return static::message('light-blue',    $message);
	}
	public static function toastSuccess($message = NULL) {
		return static::message('green', $message);
	}
	public static function toastWarning($message = NULL) {
		return static::message('orange', $message);
	}
}