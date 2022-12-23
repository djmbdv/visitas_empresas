<?php

require_once "core/Model.php";

/**
 * 
 */
class FacturaModel extends Model
{
	protected $monto;
	protected UserModel $client;
	protected $status;
	protected PlanModel $plan;

	public static function types_array(){ 
		return 	array(
		'monto' => "DECIMAL(50,2) NOT NULL",
		'client' => "int( 9 ) NOT NULL",
		'status' => "int( 3 ) NOT NULL",
		'plan' => "int (9) not null"
 		);
	}
}