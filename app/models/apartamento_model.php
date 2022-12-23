<?php

require_once "core/Model.php";

class ApartamentoModel extends Model
{


	protected $nombre;
	protected EdificioModel $edificio;
	protected UserModel $cliente;
	
	public static function types_array(){
		return array(
			'nombre' => "VARCHAR( 150 ) NOT NULL",
			'edificio' => 'VARCHAR( 11 ) NOT NULL',
			'cliente' => 'INT (11) NOT NULL'
	 	);
	}
	public static function form_types_array(){
		return array(
		'edificio' => "select"
 		);
	}

	public static function descriptions_array(){
		return array(
		'nombre' => "Nombre o Número de apartamento",
 		);
	}

	public static function seeds(){
		$propietarios = HabitanteModel::all();
		for($i = 0; $i < 25; $i++){
			$a =  new ApartamentoModel();
			$a->nombre = "A - ".random_int(1000, 2000);
			$a->edificio = EdificioModel::all()[0];
			$a->cliente = UserModel::all()[0]; 
		    $a->save();
		 }
	}
	public static function search_nombre($nombre, $cantidad = 20,$edificio = null){
		$usuario = UserModel::user_logged();
		if(!$usuario)return;
		$condicion = [['nombre','like',"%$nombre%"]];
		if($edificio)$condicion[] = ['edificio','=',$edificio];
		if(!$usuario->is_admin())$condicion[] = ["cliente","=",$usuario->get_key()];
		$a = self::all_where_and($condicion, $cantidad,null, true);
		$k = array_map(function($a){return $a->no_class_values(); }, $a);
		return json_encode($k);
	}
	public static function presentation($a){
		if($a->edificio->exist())$a->edificio->load();
		return $a->nombre;
	}

}