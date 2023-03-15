<?php

require_once "core/Controller.php";
require_once "core/Session.php";


/**
 * 
 */
class SectionsController extends ControllerRest
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
			$condicion = [['client','=',$user->get_key()]];	
			$vars = array_filter(SectionModel::get_vars(),function($a){ return $a != 'client';});
			$count = SectionModel::count($condicion);
			$items = SectionModel::all_where_and($condicion,20,$page, true);	
		}else{
			$vars = SectionModel::get_vars();
			$count = SectionModel::count();
			$items = SectionModel::all(20,$page,true);
		}
	//	print_r($items);
		$hv = new SectionsView( array(
			'items' => $items,
			'user'=> $user,
			"table_vars" => $vars,
			"modal_vars" => $vars,
			"modal_class" => 'SectionModel',
			'page'=> $page,
			'count'=> $count,
			'title'=>'Sections'
		));
		return $hv->render();
	}


	public function delete(){
		$key = $this->get_param('key');
		
		$respose = new stdClass;
		if(SectionModel::remove($key))
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
		$u = new SectionModel();
		if(isset($this->_PUT["key"]))$u->ID = $this->_PUT["key"]; 
		if(isset($this->_PUT["name"]))$u->name = $this->_PUT["name"]; 
		
		if(isset($this->_PUT["workspace"])){
			$a  = new WorkspaceModel();
			$a->ID = $this->_PUT["workspace"];
			$u->workspace = $a;
		}
		if(isset($this->_PUT["client"]) && $user->is_admin()){
			$a  = new UserModel();
			$a->ID = $this->_PUT["client"];
			$u->client = $a;
		}else {
			$u->client = $user;
		}
		$respose = new stdClass;
		if($u->save())
		
		$respose->ok = true;
		else $respose->errorMsj = "Error al ingresar";
		header("Content-type:application/json");
		print_r(json_encode($respose));
	}


	public function crear_sections(){
		$user = UserModel::user_logged();
		$data = ['user'=> $user];
		$amv = new SectionsmenuView($data);
		$amv->render();
	}

	public function post(){
		$error = false;
		$user = UserModel::user_logged();
		if(is_null($user)){
			header('location: /login/');
			return;
		}
		$u = new SectionModel();
		if(isset($this->_POST["name"]))$u->name = $this->_POST["name"]; 
		
		if(isset($this->_POST["workspace"])){
			$a  = new WorkspaceModel();
			$a->ID = $this->_POST["workspace"];
			$u->workspace = $a;
		}
		if(isset($this->_POST["client"]) && $user->is_admin()){
			$a  = new UserModel();
			$a->ID = $this->_POST["client"];
			$u->client = $a;
		}else {
			$u->client = $user;
		}
		$cond = [["name","=",$u->name], ["workspace","=",$u->workspace->ID]];
		if(count(SectionModel::all_where_and($cond)))$error = true;
		$respose = new stdClass;
		if(!$error && $u->save())
		
		$respose->ok = true;
		else $respose->errorMsj = "Error al ingresar";
		if($error) $respose->errorMsj.="\nNombre ya existe.";
		header("Content-type:application/json");
		print_r(json_encode($respose));
	}

}