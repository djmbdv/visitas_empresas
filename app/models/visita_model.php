<?php

require_once "core/Model.php";
/**
 * 
 */
class VisitaModel extends Model
{
	public $nombre;
	public $identificacion;
	public ApartamentoModel $destino;
	public $foto;
	public HabitanteModel $visitado;
	public UserModel $cliente;


	public static function types_array(){
		return array(
		'nombre' => "VARCHAR( 150 ) NOT NULL",
		'destino' => "INT( 11 ) NOT NULL",
		'foto' => ' MEDIUMBLOB NOT NULL',
		'visitado'=>'int (11) NOT NULL',
		'identificacion'=>'VARCHAR (20) NOT NULL',
		'cliente' => 'int (11) NOT NULL'
 		);
	}
	public static function p_destino($x){
		$str ="";
		if($x->destino->exist()){
		 $x->destino->load();
		 $x->destino->edificio->load();
		 $str="Torre: ". $x->destino->edificio->nombre." |  Apartamento:".$x->destino->nombre ;
		}
		return $str;
	}
	public static function array_presentation(){
		return [ "destino" => "p_destino"];
	}
}