<?php

require_once "core/Model.php";

class SectionModel extends Model
{
	protected $name;
	protected WorkspaceModel $workspace;
	protected UserModel $client;
	
	public static function types_array(){
		return array(
			'name' => "VARCHAR( 150 ) NOT NULL",
			'workspace' => 'VARCHAR( 11 ) NOT NULL',
			'client' => 'INT (11) NOT NULL'
	 	);
	}

	public static function form_types_array(){
		return array(
		'workspace' => "select"
 		);
	}

	public static function seeds(){
		$propietarios = EmployeeModel::all();
		for($i = 0; $i < 25; $i++){
			$a =  new SectionModel();
			$a->name = "office - ".random_int(1000, 2000);
			$a->workspace = WorkspaceModel::all()[0];
			$a->client = UserModel::all()[0]; 
		    $a->save();
		 }
	}
	public static function search_name($name, $count = 20,$workspace = null){
		$user = UserModel::user_logged();
		if(!$user)return;
		$condition = [['name','like',"%$name%"]];
		if($workspace)$condition[] = ['workspace','=',$workspace];
		if(!$user->is_admin())$condition[] = ["client","=",$user->get_key()];
		$a = self::all_where_and($condition, $count,null, true);
		$k = array_map(function($a){return $a->no_class_values(); }, $a);
		return json_encode($k);
	}
	public static function presentation($a){
		return $a->name;
	}

}