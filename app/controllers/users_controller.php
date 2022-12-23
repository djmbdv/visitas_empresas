<?php


require_once "core/Controller.php";
require_once "core/Session.php";

class UsersController extends ControllerRest
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
		$hv = new UsersView( array(
			'items' => UserModel::all(20,$page),
			'user'=> $user,
			"table_vars" => UserModel::get_vars(),
			"modal_vars" => UserModel::get_vars(),
			"modal_class" => 'UserModel',
			'page'=> $page,
			'count'=>UserModel::count(),
			'title'=>'Usuarios'
		));
		return $hv->render();
	}

	public function delete(){
		$key = $this->get_param('key');
		
		$respose = new stdClass;
		if(UserModel::remove($key))
		$respose->ok = true;
		else $respose->errorMsj = "Error al eliminar";
		header("Content-type:application/json");
		print_r(json_encode($respose));
	}

	public function put(){
		$u = new UserModel();

		if(isset($this->_PUT["key"]))$u->ID = $this->_PUT["key"]; 
		$u->load();
		if(isset($this->_PUT["name"]))$u->name = $this->_PUT["name"]; 
		if(isset($this->_PUT["username"]))$u->username = $this->_PUT["username"]; 
		if(isset($this->_PUT["password"]) && strlen($this->_PUT["password"]) >= 4)$u->password = $this->_PUT["password"]; 
		if(isset($this->_PUT["email"]))$u->email = $this->_PUT["email"];
		if(isset($this->_PUT["image"]))$u->image = $this->_PUT["image"];
		if(isset($this->_PUT["titulo"]))$u->titulo = $this->_PUT["titulo"]; 
		if(isset($this->_PUT["tipo"])){
			$t  = new TipoModel();
			$t->ID = $this->_PUT["tipo"];
			$u->tipo = $t;
		}
		$p = new PlanModel();
		if(isset($this->_PUT["plan"])){
			$p->ID =  $this->_PUT["plan"]; 
			$u->plan = $p;
		}
		$respose = new stdClass;
		if($u->save())
		$respose->ok = true;
		else $respose->errorMsj = "Error al crear";
		header("Content-type:application/json");
		print_r(json_encode($respose));
	}
	public function post(){
		$u = new UserModel();
		
		if(isset($this->_POST["name"]))$u->name = $this->_POST["name"]; 
		if(isset($this->_POST["username"]))$u->username = $this->_POST["username"]; 
		if(isset($this->_POST["password"] ) && strlen($this->_POST["password"] >= 4) )$u->password = $this->_POST["password"]; 
		if(isset($this->_POST["email"]))$u->email = $this->_POST["email"]; 
		if(isset($this->_POST["image"]))$u->image = $this->_POST["image"]; 
		if(isset($this->_POST["titulo"]))$u->titulo = $this->_POST["titulo"]; 
		$p = new PlanModel();
		if(isset($this->_POST["plan"])){
			$p->ID =  $this->_POST["plan"]; 
			$u->plan = $p;
		}
		if(isset($this->_POST["tipo"])){
			$t  = new TipoModel();
			$t->ID = $this->_POST["tipo"];
			$u->tipo = $t;
		}
		$respose = new stdClass;
		if($u->save())
		
		$respose->ok = true;
		else $respose->errorMsj = "Error al crear";
		header("Content-type:application/json");
		print_r(json_encode($respose));
	}
	public function account(){
		$user = UserModel::user_logged();
		if(is_null($user)){
			header('location: /login/');
			return;
		}
		if(Session::g('control_visitas')){
			header('location: /');
			return;
		}
		$user = UserModel::user_logged();
		$hv = new AccountView( array(
			'user'=> $user
		));
		return $hv->render();
	}
}