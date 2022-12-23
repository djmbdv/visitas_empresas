<?php

require_once "core/Controller.php";
require_once "core/Session.php";


/**
 * 
 */
class ApartamentosController extends ControllerRest
{
	public function get()
	{
		$user = UserModel::user_logged();
		if(is_null($user)){
			header('location: /login/');
			return;
		}
		if(Session::g('control_visitas')){
			header('location: /');
			return;
		}
		$page = $this->get_param("page");
		$page = $page?$page:1;	

		if(!$user->is_admin()){
			$condicion = [['cliente','=',$user->get_key()]];	
			$vars = array_filter(ApartamentoModel::get_vars(),function($a){ return $a != 'cliente';});
			$count = ApartamentoModel::count($condicion);
			$items = ApartamentoModel::all_where_and($condicion,20,$page);	
		}else{
			$vars = ApartamentoModel::get_vars();
			$count = ApartamentoModel::count();
			$items = ApartamentoModel::all(20,$page);
		}
		$hv = new ApartamentosView( array(
			'items' => $items,
			'user'=> $user,
			"table_vars" => $vars,
			"modal_vars" => $vars,
			"modal_class" => 'ApartamentoModel',
			'page'=> $page,
			'count'=> $count,
			'title'=>'Apartamentos'
		));
		return $hv->render();
	}


	public function delete(){
		$key = $this->get_param('key');
		
		$respose = new stdClass;
		if(ApartamentoModel::remove($key))
		$respose->ok = true;
		else $respose->errorMsj = "Error al eliminar";
		header("Content-type:application/json");
		print_r(json_encode($respose));
	}

	public function put(){
		$user = UserModel::user_logged();
		if(is_null($user)){
			header('location: /login/');
			return;
		}
		$u = new ApartamentoModel();
		if(isset($this->_PUT["key"]))$u->ID = $this->_PUT["key"]; 
		if(isset($this->_PUT["nombre"]))$u->nombre = $this->_PUT["nombre"]; 
		
		if(isset($this->_PUT["edificio"])){
			$a  = new EdificioModel();
			$a->ID = $this->_PUT["edificio"];
			$u->edificio = $a;
		}
		if(isset($this->_PUT["cliente"]) && $user->is_admin()){
			$a  = new UserModel();
			$a->ID = $this->_PUT["cliente"];
			$u->cliente = $a;
		}else {
			$u->cliente = $user;
		}
		$respose = new stdClass;
		if($u->save())
		
		$respose->ok = true;
		else $respose->errorMsj = "Error al ingresar";
		header("Content-type:application/json");
		print_r(json_encode($respose));
	}


	public function crear_apartamentos(){
		$user = UserModel::user_logged();
		$data = ['user'=> $user];
		$amv = new ApartamentosmenuView($data);
		$amv->render();
	}

	public function post(){
		$error = false;
		$user = UserModel::user_logged();
		if(is_null($user)){
			header('location: /login/');
			return;
		}
		$u = new ApartamentoModel();
		if(isset($this->_POST["nombre"]))$u->nombre = $this->_POST["nombre"]; 
		
		if(isset($this->_POST["edificio"])){
			$a  = new EdificioModel();
			$a->ID = $this->_POST["edificio"];
			$u->edificio = $a;
		}
	/*	if(isset($this->_POST["propietario"])){
			$a  = new HabitanteModel();
			$a->ID = $this->_POST["propietario"];
			$u->propietario = $a;
		}*/
		if(isset($this->_POST["cliente"]) && $user->is_admin()){
			$a  = new UserModel();
			$a->ID = $this->_POST["cliente"];
			$u->cliente = $a;
		}else {
			$u->cliente = $user;
		}
		$cond = [["nombre","=",$u->nombre], ["edificio","=",$u->edificio->ID]];
		if(count(ApartamentoModel::all_where_and($cond)))$error = true;
		$respose = new stdClass;
		if(!$error && $u->save())
		
		$respose->ok = true;
		else $respose->errorMsj = "Error al ingresar";
		if($error) $respose->errorMsj.="\nNombre ya existe.";
		header("Content-type:application/json");
		print_r(json_encode($respose));
	}

}