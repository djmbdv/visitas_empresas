<?php

require_once "core/Model.php";

class WorkspaceModel extends Model
{
	protected $name;
	protected UserModel $client;
	public static function types_array(){
		return array(
		'name' => "VARCHAR( 150 ) NOT NULL",
		'address' => "TEXT NOT NULL",
 		'client' => "INT (11) NOT NULL"
 		);
	}

	public static function seeds(){
		$e = new WorkspaceModel();
		$e->name = "RemontePCSolution Building";
		$e->address ="Paipa, 19 a 32 312";
		$e->client = UserModel::all()[0];
		$e->save();
	}

	public static function search_name($name, $count = 20){
		$user = UserModel::user_logged();
		if(!$user)return;
		$condition = [['name','like',"%$name%"]];
		if(!$user->is_admin())$condition[] = ["client","=",$user->get_key()];
		$a = self::all_where_and($condition, $count,null, true);
		$k = array_map(function($a){return $a->no_class_values(); }, $a);
		return json_encode($k);
	}
	public static function presentation($worksapace){
		return $worksapace->name;
	}

}