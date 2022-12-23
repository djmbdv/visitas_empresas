<?php

require_once "core/Model.php";
require_once "core/Session.php";
require_once "core/database.php";
/**
 * 
 */
class UserModel extends Model{
	protected $username;
	protected $name;
	protected $password;
	protected $email;
	protected TipoModel $tipo;
	protected PlanModel $plan;
	protected $image;
	protected $titulo;
	protected $pin;
	public static function types_array(){ 
		return 	array(
		'username' => "VARCHAR( 80 ) NOT NULL UNIQUE",
		'name' => "VARCHAR( 120 ) NOT NULL",
		'password' => "VARCHAR( 80 ) NOT NULL",
		'email' => 'varchar ( 100 ) NOT NULL',
		'tipo' => 'INT( 9)  NOT NULL',
		'plan' => 'INT( 9) ',
		'image'=>	'MEDIUMBLOB ',
		'titulo'=> 'VARCHAR (200) ',
		'pin' => 'VARCHAR (200)'
 		);
	}
	public static function form_types_array(){
		return array(
		'email' => "email",
		'password' => "password",
		'image' =>"file",
		'tipo' => "select",
		'plan'=> "select"
 		);
	}

	public function get_habitantes_count(){
		$cond = [["cliente","=",$this->get_key()]];
		return HabitanteModel::count($cond);
	}
	public function get_edificios_count(){

		$cond = [["cliente","=",$this->get_key()]];
		return EdificioModel::count($cond);
	}
	public function get_apartamentos_count(){
		$cond = [["cliente","=",$this->get_key()]];
		return ApartamentoModel::count($cond);
	}
	public static function seeds(){
		$tipos = TipoModel::all();
		$client  = new UserModel();
		$client->username = 'cliente';
		$client->name = 'Cliente de Prueba';
		$client->password =md5( '1234');
		$client->email = "client@ejemplo.com";
		$client->titulo = "Complejo de prueba";
		$client->tipo = $tipos[1];
		$client->pin = "1234";
		$client->plan = PlanModel::all()[0];
		$client->save();
		$client  = new UserModel();
		$client->username = 'fabian';
		$client->name = 'Fabian Espejo';
		$client->password =md5( 'fabianjose');
		$client->titulo = "Complejo de prueba";
		$client->email = "fabian@remotepcsolutions.com";
		$client->tipo = $tipos[0];
		$client->pin = "1234";
		$client->save();
		//exit();
	}
	public static function user_logged(){
		Session::load();
		if(isset(Session::$values["username"]))
			return self::find_username(Session::$values["username"]);
		else return null;
	}
	public static function search_nombre($nombre, $cantidad = 20){
		$a = self::all_where_like("name",$nombre,$cantidad,null,true);
		$k = array_map(function($a){return $a->no_class_values(); }, $a);
		return json_encode($k);
	}
	public function is_admin(){
		return $this->tipo->get_key() == TipoModel::all()[0]->get_key();
	}
	public static function find_username($username){
		try{
			$pdo = DB::get();
			$tabla = self::get_table_name();
			$sql = "select ID from $tabla where username = '$username'";
			$stmt = $pdo->prepare($sql);
			$stmt->execute();
			$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
			if(!isset($res[0]))return null;
			$um = new UserModel();

			$um->ID = $res[0]['ID'];
			$um->load();
			return $um;
		} catch (Exception $e) {
			return null;	
		}
	}
	public static function presentation($h){
		return $h->username.' | '.$h->name; 
	}

	public static function p_cargo($c){
		return "Apartamentos: ".$c->get_apartamentos_count()."<br>Edificios: ".$c->get_edificios_count();
	}
	public static function array_presentation(){
		return [ "cargo" => "p_cargo"];
	}

	public static function login($username, $password){
		$user = self::find_username($username);
		if(!is_null($user) && $user->password == md5($password)){
			Session::load( array('login' => true,'username' => $username,'logged_at' => time() ));
			return true;
		}
		else return false;
	}

}