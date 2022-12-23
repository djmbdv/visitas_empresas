<?php

require_once "core/Model.php";

class EdificioModel extends Model
{
	protected $nombre;
//	protected $direccion;
	protected UserModel $cliente;
	public static function types_array(){
		return array(
		'nombre' => "VARCHAR( 150 ) NOT NULL",
		'direccion' => "TEXT NOT NULL",
 		'cliente' => "INT (11) NOT NULL"
 		);
	}

	public static function seeds(){
		$e = new EdificioModel();
		$e->nombre = "Torre A";
		$e->direccion ="Primera Esquina frente la calle Ciega";
		$e->cliente = UserModel::all()[0];
		$e->save();
	}

	public static function search_nombre($nombre, $cantidad = 20){
		$usuario = UserModel::user_logged();
		if(!$usuario)return;
		$condicion = [['nombre','like',"%$nombre%"]];
		if(!$usuario->is_admin())$condicion[] = ["cliente","=",$usuario->get_key()];
		$a = self::all_where_and($condicion, $cantidad,null, true);
		$k = array_map(function($a){return $a->no_class_values(); }, $a);
		return json_encode($k);
	}
	public static function presentation($h){
		return $h->nombre;
	}

}