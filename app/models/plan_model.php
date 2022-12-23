<?php

require_once "core/Model.php";


/**
 * 
 */
class PlanModel extends Model
{
	protected $descripcion;
	protected $iva;
	protected $precio_apartamento;
	protected $precio_edificio;
	protected $precio_habitante; 
	protected $gracia;
	public static function seeds(){
		$plan = new PlanModel();
		$plan->iva = 0.19;
		$plan->gracia = 0;
		$plan->precio_edificio= 0;
		$plan->precio_habitante = 0;
		$plan->precio_apartamento = 2500;
		$plan->descripcion = "Plan Basico";
		$plan->save();
				$plan = new PlanModel();
		$plan->iva = 0.19;
		$plan->gracia = 0;
		$plan->precio_edificio= 0;
		$plan->precio_habitante = 0;
		$plan->precio_apartamento = 2300;
		$plan->descripcion = "Plan Standard";
		$plan->save();
				$plan = new PlanModel();
		$plan->iva = 0.19;
		$plan->gracia = 0;
		$plan->precio_edificio= 0;
		$plan->precio_habitante = 0;
		$plan->precio_apartamento = 2000;
		$plan->descripcion = "Plan Premium";
		$plan->save();
	}


	public function factura_exist($client){
		$cond = [["cliente","=",$client->get_key()]];
		$cond[] = ["moth(create_at)","=",date("m")];
		$cond[] = ["year(create_at)","=",date("y")];
		$c = FacturaModel::count($cond);
		return intval( $c) > 0;
	}

	public function make_factura($client){
		$f = new  FacturaModel();
		$monto = $client->get_apartamentos_count() * $this->precio_apartamento +
		$client->get_habitantes_count() * $this->precio_habitante +
		$client->get_edificios_count()*$this->precio_edificio;
		$monto += $monto*$this->iva;
		$f->monto = $monto;
		$f->cliente = $client;
		$f->plan  = $this;
		$f->status = 0;
		$f->save();
	}
	public static function presentation($n){
		return $n->descripcion;
	}
	public static function search_descripcion($aa, $cantidad = 10){
		$a = self::all($cantidad,null,true);
		$k = array_map(function($a){return $a->no_class_values(); }, $a);
		return json_encode($k);
	}
	public static function types_array(){ 
		return 	array(
		'descripcion' => "VARCHAR (150) NOT NULL",
		'iva' => "decimal ( 4,3 ) NOT NULL",
		'precio_apartamento' =>"decimal (12,2) not null ",
		'precio_habitante' =>"decimal (12,2) not null ",
		'precio_edificio' =>"decimal (12,2) not null "
 		);
	}

}