<?php

require_once "core/Model.php";
/**
 * 
 */
class VisitaModel extends Model
{
	public $name;
	public $telephone;
	public $document_id;
	public SectionModel $section;
	public $photo;
	public EmployeeModel $host;
	public $subject;
	public UserModel $client;


	public static function types_array(){
		return array(
			'name' => "VARCHAR( 150 ) NOT NULL",
			'destiny' => "INT( 11 ) NOT NULL",
			'photo' => ' MEDIUMBLOB NOT NULL',
			'host'=>'int (11) NOT NULL',
			'telephone' => 'VARCHAR (20) NOT NULL',
			'document_id'=>'VARCHAR (20) NOT NULL',
			'client' => 'int (11) NOT NULL'
 		);
	}
	public static function p_destino($x){
		$str ="";
		if($x->destiny->exist()){
		 $x->destiny->load();
		 $x->destiny->workspace->load();
		 $str="Workspace: ". $x->destiny->workspace->name." |  Section:".$x->section->name ;
		}
		return $str;
	}
	public static function array_presentation(){
		return [ "host" => "p_host"];
	}
}