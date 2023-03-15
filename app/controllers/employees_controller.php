<?php
require_once "core/Controller.php";
require_once "core/Session.php";

/**
 * 
 */
class EmployeesController extends ControllerRest
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
			$condicion = [[['client','=',$user->get_key()]]];
			$condicion2 = [[["sections.id","=","employees.section"],['sections.client',"=",$user->get_key()]],[["workspaces.id","=","sections.workspace"]]];	
			$vars = array_filter(EmployeeModel::get_vars(),function($a){ return $a != 'client';});
			$count = EmployeeModel::count($condicion[0]);
			$items = EmployeeModel::all_inner_join_and(["sections","workspaces"],$condicion2,20,$page,true, "workspaces.name");
		}else{
			$condicion = [[["sections.id","=","employees.section"]],[["workspaces.id","=","sections.workspace"]]];
			$vars = EmployeeModel::get_vars();
			$count = EmployeeModel::count();
			$items = EmployeeModel::all_inner_join_and(["sections","workspaces"],$condicion,20,$page,true, "workspaces.name", false);
		}
		$varst  =  $vars;
		array_unshift($varst, "torre");
		$hv = new EmployeesView( array(
			'items' => $items,
			'user'=> $user,
			"table_vars" => $varst,
			"modal_vars" => $vars,
			"modal_class" => 'EmployeeModel',
			'page'=> $page,
			'count'=>$count,
			'title'=>'Empleados'
		));
		return $hv->render();
	}

	public function delete(){
		$key = $this->get_param('key');
		
		$respose = new stdClass;
		if(EmployeeModel::remove($key))
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
		$u = new EmployeeModel();
		if(isset($this->_PUT["key"]))$u->ID = $this->_PUT["key"]; 
		if(isset($this->_PUT["name"]))$u->name = $this->_PUT["name"]; 
		if(isset($this->_PUT["identificacion"]))$u->identificacion = $this->_PUT["identificacion"]; 
		if(isset($this->_PUT["telefono"]))$u->telefono = $this->_PUT["telefono"]; 
		if(isset($this->_PUT["email"]))$u->email = $this->_PUT["email"]; 
		if(isset($this->_PUT["photo"]) )$u->photo = $this->_PUT["photo"]; 
		
		if(isset($this->_PUT["section"])){
			$a  = new SectionModel();
			$a->ID = $this->_PUT["section"];
			$u->section = $a;
		}
		if(isset($this->_PUT["client"]) && $user->is_admin()){
			$a  = new UserModel();
			$a->ID = $this->_PUT["client"];
			$u->cliente = $a;
		}else {
			$u->cliente = $user;
		}
     
		$respose = new stdClass;
		if($u->save())
		
		$respose->ok = true;
		else $respose->errorMsj = "Error al actualizar";
		header("Content-type:application/json");
		print_r(json_encode($respose));
	}

	public function post(){
		$user = UserModel::user_logged();
		if(is_null($user)){
			header('location: /login/');
			return;
		}
		$u = new EmployeeModel();
		if(isset($this->_POST["name"]))$u->name = $this->_POST["name"]; 
		if(isset($this->_POST["identificacion"]))$u->identificacion = $this->_POST["identificacion"]; 
		if(isset($this->_POST["telefono"]))$u->telefono = $this->_POST["telefono"]; 
		if(isset($this->_POST["email"]))$u->email = $this->_POST["email"]; 
		if(isset($this->_POST["photo"]) )$u->photo = $this->_POST["photo"]; 
		
		if(isset($this->_POST["section"])){
			$a  = new SectionModel();
			$a->ID = $this->_POST["section"];
			$u->section = $a;
		}
		if(isset($this->_POST["client"]) && $user->is_admin()){
			$a  = new UserModel();
			$a->ID = $this->_POST["client"];
			$u->client = $a;
		}else {
			$u->client = $user;
		}


		$respose = new stdClass;
		if($u->name != ""  && $u->save())
		$respose->ok = true;
		else $respose->errorMsj = "Error al crear";
		if($u->name == "")$respose->errorMsj.= "\nDebe indicar name.";
		header("Content-type:application/json");
		print_r(json_encode($respose));
	}

}