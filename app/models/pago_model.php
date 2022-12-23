<?php

require_once "core/Model.php";





/**
 * 
 */
class PagoModel extends Model{
	protected $monto;
	protected UserModel $client;
	protected $detalle;
	protected UserModel $admin;
	public static function types_array(){ 
		return 	array(
		'detalle' => "VARCHAR( 150 ) NOT NULL",
		);
 	}
 }