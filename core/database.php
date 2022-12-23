<?php 
require_once 'config.php';
class DB{
	private static $conn = null;
	public static function getDBName(){ 
		return Config::$dbname;
	}
	public static function get(){
		$username = Config::$username;
		$dbname = Config::$dbname;
		$servername = Config::$servername;
		$password = Config::$password;
		if(is_null(self::$conn))self::$conn =  new PDO("mysql:host=$servername;port=3306;dbname=$dbname;charset=utf8mb4", $username, $password);
		self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return self::$conn;
	}
}