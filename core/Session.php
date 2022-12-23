<?php

class Session{
	public static $values;
	public static $session_loaded = false;
	public static function load($array = array( )){
		if(self::$session_loaded){
			return;
		}
		session_start();
		foreach ($array as $key => $value) {
			$_SESSION[$key] =  $value;
		}
		self::$values = $_SESSION;
		session_commit();
		self::$session_loaded = true;
	}


	public static function g($v){
		return isset(self::$values[$v])? self::$values[$v]:null;
	}
	public static function destroy(){
		if(self::$session_loaded){
			throw new Exception("Session cargada", 1);
		}
		session_start();
		session_destroy();
		session_commit();
	}
}