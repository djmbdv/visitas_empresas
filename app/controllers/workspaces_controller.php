<?php





require_once "core/Controller.php";
require_once "core/Session.php";


/**
 * 
 */
class WorkspacesController extends ControllerRest
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
			$vars = array_filter(WorkspaceModel::get_vars(),function($a){ return $a != 'client';});
			$count = WorkspaceModel::count($condicion);
			$items = WorkspaceModel::all_where_and($condicion,20,$page);	
		}else{
			$vars = WorkspaceModel::get_vars();
			$count =WorkspaceModel::count();
			$items = WorkspaceModel::all(20,$page);
		}
		$hv = new WorkspacesView( array(
			'items' => $items,
			'user'=> $user,
			"table_vars" => $vars,
			"modal_vars" => $vars,
			"modal_class" => 'WorkspaceModel',
			'page'=> $page,
			'count'=> $count,
			'title'=>'Workspaces'
		));
		return $hv->render();
	}
	public function post(){
		$user = UserModel::user_logged();
		if(is_null($user)){
			header('location: /login/');
			return;
		}
		$u = new WorkspaceModel();
		if(isset($this->_POST["name"])  && strlen($this->_POST["name"]) >= 1)$u->name = $this->_POST["name"]; 
	//	if(isset($this->_POST["direccion"]))$u->direccion = $this->_POST["direccion"];
		if(isset($this->_POST["client"]) && $user->is_admin()){
			$a  = new UserModel();
			$a->ID = $this->_POST["client"];
			$u->client = $a;
		}else {
			$u->client = $user;
		}
		$respose = new stdClass;
		if($u->save())
		
		$respose->ok = true;
		else $respose->errorMsj = "Error al crear";
		header("Content-type:application/json");
		print_r(json_encode($respose)); 
	}

	public function put(){
		$user = UserModel::user_logged();
		if(is_null($user)){
			header('location: /login/');
			return;
		}
		$u = new WorkspaceModel();
		if(isset($this->_PUT["key"]))$u->ID = $this->_PUT["key"]; 
		if(isset($this->_PUT["name"]))$u->name = $this->_PUT["name"]; 
//		if(isset($this->_PUT["direccion"]))$u->direccion = $this->_PUT["direccion"];
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
		else $respose->errorMsj = "Error al crear";
		header("Content-type:application/json");
		print_r(json_encode($respose)); 
	}
	public function delete(){
		$key = $this->get_param('key');
		
		$respose = new stdClass;
		if(WorkspaceModel::remove($key))
		$respose->ok = true;
		else $respose->errorMsj = "Error al eliminar";
		header("Content-type:application/json");
		print_r(json_encode($respose));
	}

}