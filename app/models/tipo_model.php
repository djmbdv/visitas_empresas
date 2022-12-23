<?php

require_once "core/Model.php";

class TipoModel extends Model
{
	public $descripcion;
	
	public static function seeds(){
		$t = new TipoModel();
		$t->descripcion = "admin";
		$t->save();
		$t = new TipoModel();
		$t->descripcion = "client";
		$t->save();
	}
	public static function search_descripcion($aa, $cantidad = 10){
		$a = self::all($cantidad,null,true);
		$k = array_map(function($a){return $a->no_class_values(); }, $a);
		return json_encode($k);
	}
	public static function presentation($n){
		return $n->descripcion;
	}
	public static function types_array(){ 
		return 	array(
		'descripcion' => "VARCHAR( 150 ) NOT NULL",
		);
 	}

}