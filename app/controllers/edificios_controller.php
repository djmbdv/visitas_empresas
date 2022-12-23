<?php





require_once "core/Controller.php";
require_once "core/Session.php";


/**
 * 
 */
class EdificiosController extends ControllerRest
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
			$vars = array_filter(EdificioModel::get_vars(),function($a){ return $a != 'cliente';});
			$count = EdificioModel::count($condicion);
			$items = EdificioModel::all_where_and($condicion,20,$page);	
		}else{
			$vars = EdificioModel::get_vars();
			$count =EdificioModel::count();
			$items = EdificioModel::all(20,$page);
		}
		$hv = new EdificiosView( array(
			'items' => $items,
			'user'=> $user,
			"table_vars" => $vars,
			"modal_vars" => $vars,
			"modal_class" => 'EdificioModel',
			'page'=> $page,
			'count'=> $count,
			'title'=>'Edificios'
		));
		return $hv->render();
	}
	public function post(){
		$user = UserModel::user_logged();
		if(is_null($user)){
			header('location: /login/');
			return;
		}
		$u = new EdificioModel();
		if(isset($this->_POST["nombre"])  && strlen($this->_POST["nombre"]) >= 1)$u->nombre = $this->_POST["nombre"]; 
	//	if(isset($this->_POST["direccion"]))$u->direccion = $this->_POST["direccion"];
		if(isset($this->_POST["cliente"]) && $user->is_admin()){
			$a  = new UserModel();
			$a->ID = $this->_POST["cliente"];
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

	public function put(){
		$user = UserModel::user_logged();
		if(is_null($user)){
			header('location: /login/');
			return;
		}
		$u = new EdificioModel();
		if(isset($this->_PUT["key"]))$u->ID = $this->_PUT["key"]; 
		if(isset($this->_PUT["nombre"]))$u->nombre = $this->_PUT["nombre"]; 
//		if(isset($this->_PUT["direccion"]))$u->direccion = $this->_PUT["direccion"];
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
		else $respose->errorMsj = "Error al crear";
		header("Content-type:application/json");
		print_r(json_encode($respose)); 
	}
	public function delete(){
		$key = $this->get_param('key');
		
		$respose = new stdClass;
		if(EdificioModel::remove($key))
		$respose->ok = true;
		else $respose->errorMsj = "Error al eliminar";
		header("Content-type:application/json");
		print_r(json_encode($respose));
	}

}