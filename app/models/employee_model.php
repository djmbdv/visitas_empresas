<?php

require_once "core/Model.php";

/**
 * 
 */
class EmployeeModel extends Model
{
	
	protected SectionModel $section;
	protected $email;
//	protected $telefono;
	protected $name;
//	protected $identificacion;
	protected UserModel $client;
	public static function types_array(){
		return array(
		'name' => "VARCHAR( 150 ) NOT NULL",
		'section' => "INT( 11 ) ",
		'photo' => ' MEDIUMBLOB',	
 		);
	}
	public static function descriptions_array(){
		return array(
		'name' => "Nombre Completo",
		'section' => "Seleccione un Apartamento"	
 		);
	}

	public static function form_types_array(){
		return array(
		'email' => "email",
		'section' => "select"
 		);
	}

	public static function p_torre($x){
		$str ="";
		if($x->section->exist()){
		 $x->section->load();
		 $x->section->workspace->load();
		 $str= $x->section->workspace->name;
		}
		return $str;
	}
	public static function array_presentation(){
		return [ "torre" => "p_torre"];
	}


	public static function search_name($name, $cantidad = 20, $section = null){
		$user = UserModel::user_logged();
		if(!$user)return;
		$condicion = [['name','like',"%$name%"]];
		if($section)$condicion[] = ['section','=',$section];
		if(!$user->is_admin())$condicion[] = ["client","=",$user->get_key()];
		$a = self::all_where_and($condicion, $cantidad,null, true);
		$k = array_map(function($a){return $a->no_class_values(); }, $a);
		return json_encode($k);
	}
	public static function presentation($h){
		return $h->name; 
	}
	public static function seeds(){
	  //return;
		$foto = 'data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHoAAAB6CAMAAABHh7fWAAAAaVBMVEX///8AAADo6Oja2tojIyPd3d0mJiYNDQ26uroQEBDIyMjh4eHl5eXW1tbr6+sHBwdOTk6Hh4eTk5NBQUGcnJzx8fEWFhZbW1srKyszMzNvb28eHh53d3dWVlZ/f39HR0epqallZWU6Ojo1/jOrAAACqklEQVRoge2a6XaqMBRGCRZk1IrggBWp7/+Q90ZKV1uL5Hz5hP7IfgD2WhkOZ4jnWZI0KrH9BkJenJQ6VJN7/faiNM3E3iqpT6qjmFS8Krfqk/cJxUmtvtFO5K3KpfrJeYozntd33o63KHuqODkPiDXxtkmedc0eijuOTf4Ecfo+Kr5R0xc+MhNrIq65NDeTY0whMVPdrcxMXPPsPoiMELPO2lAYecAbx7yQm5VKKWrhGesoKertuOieC8O8ekHUISOcBzGi3jE2e7FG1OvFbOqlUzu1U/9ltfhvfVMHs6ljp3Zqp/7DaixBoqhzxKwUo9DeYOqNvRnKwjXWmbigpP+JbbmZ4GrbjlaFq63rDyhR0Oxszd4eVe+t1aIGzlfsy1z4iNv3UwJUTYik4Dlb25u9V0z9SlDPF8PRc8bo2gVYqkDpXkGbzdhqcMU5XVIf6F6FK4oaCeP2AbwDuF6Mq6UBNpvVEE/lak5j+D8XqZlztTTitjRv+CFeceKsSziCII0fbmQytU9Uy3abM3z4RPAP4R3vjsy41I2py605mqqPbLN3MFUf2ObqNC7tOLFH96lxmrSkxe8PBG0N9psBwY+T/VJkvgcDkul5S1YLkiRWctQzXyAVFfjM30dlHEU7rjx1IzMTt9s8iPbQnhsCbTtWWAEeh9Qcc3WVq6+cFYca4pR/SAb1C/f2qfhKfLF6GrsSe1XsULNSuwKXV2WIizVhCZ621jgTHObQAuKIINYcpZlDAtzlQbkktCXiWv4xF1N5Pv5UVczZJMQEQMQ2oR7rj/twBBmneVQHVmAD2pTN4DWHJyzm/J62TSD+Xd6KkyCUl/abOBKmnHZ8CXABOFnBOfc37QkhZNT9cZehh6J2hL5TO7VTO7VTM9TyMZY9fYMrhZ+9oNxK4H/iGzEkYE2a3gAAAABJRU5ErkJggg==';
		for ($i=0; $i < 15; $i++) { 
			$employee = new EmployeeModel();
			$apellidos = array('Rios','Gutierrez','Martinez', 'Gonzalez', 'Patiño','Alzolar', 'Noriega', 'Pastrano', 'Peres','Ruiz', 'Aguilera','Sarmiento','Garcia','Hernandez','Coa', 'Espejo', 'Calvo', 'Cabello','Bello','Feo','Leon', 'Sotillo','Bolivar','Marcano','Miranda', 'Smith','Matsumoto', 'Chang', 'Marquez','Suarez','Herrera', 'Arenas','Landaez', 'Fuentes', 'Fernandez', 'Padilla','Infante','Gomez', 'Doni', 'Bozzi','Pacheco','Agreda','Espada', 'Sierra','Colmenares');
			$array = array("Juan" ,"Fabio",
				"Alfredo","Jaime","Adolfo","Casimiro", "Fabio", "Jean", "Doni","Tarek","Daniel", "Maria", "Espejo","Fabian", "Rosa", "David", "Juan","Pedro","McGregor", "Messi", "Antonia", "Adriana", "Jonh", "Linda" );
			$employee->section = SectionModel::all()[0] ?? new SectionModel();
	//		$h->telefono = random_int(1000, 2000);
			$employee->email = strtolower($array[random_int(0,count($array)-1)].random_int(1000, 2000).'@gmail.com');
			$employee->name = ucfirst( $array[random_int(0,count($array)-1)])." ".ucfirst($apellidos[random_int(0,count($apellidos)-1)]);
		//	$h->identificacion =  random_int(1000000, 90000000);
		//	$employee->photo = $foto;
		//var_dump($h);
			$employee->client = UserModel::all()[0];
			$employee->save();
		}
	}
}