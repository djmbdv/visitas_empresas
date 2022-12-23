<?php
require_once "core/Controller.php";
require_once "core/Session.php";

/**
 * 
 */
class HabitantesController extends ControllerRest
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
			$condicion = [[['cliente','=',$user->get_key()]]];
			$condicion2 = [[["apartamentos.id","=","habitantes.apartamento"],['apartamentos.cliente',"=",$user->get_key()]],[["edificios.id","=","apartamentos.edificio"]]];	
			$vars = array_filter(HabitanteModel::get_vars(),function($a){ return $a != 'cliente';});
			$count = HabitanteModel::count($condicion[0]);
			$items = HabitanteModel::all_inner_join_and(["apartamentos","edificios"],$condicion2,20,$page,false, "edificios.nombre");
		}else{
			$condicion = [[["apartamentos.id","=","habitantes.apartamento"]],[["edificios.id","=","apartamentos.edificio"]]];
			$vars = HabitanteModel::get_vars();
			$count = HabitanteModel::count();
			$items = HabitanteModel::all_inner_join_and(["apartamentos","edificios"],$condicion,20,$page,false, "edificios.nombre", false);
		}
		$varst  =  $vars;
		array_unshift($varst, "torre");
		$hv = new HabitantesView( array(
			'items' => $items,
			'user'=> $user,
			"table_vars" => $varst,
			"modal_vars" => $vars,
			"modal_class" => 'HabitanteModel',
			'page'=> $page,
			'count'=>$count,
			'title'=>'Residentes'
		));
		return $hv->render();
	}

	public function delete(){
		$key = $this->get_param('key');
		
		$respose = new stdClass;
		if(HabitanteModel::remove($key))
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
		$u = new HabitanteModel();
		if(isset($this->_PUT["key"]))$u->ID = $this->_PUT["key"]; 
		if(isset($this->_PUT["nombre"]))$u->nombre = $this->_PUT["nombre"]; 
		if(isset($this->_PUT["identificacion"]))$u->identificacion = $this->_PUT["identificacion"]; 
		if(isset($this->_PUT["telefono"]))$u->telefono = $this->_PUT["telefono"]; 
		if(isset($this->_PUT["email"]))$u->email = $this->_PUT["email"]; 
		if(isset($this->_PUT["foto"]) )$u->foto = $this->_PUT["foto"]; 
		
		if(isset($this->_PUT["apartamento"])){
			$a  = new ApartamentoModel();
			$a->ID = $this->_PUT["apartamento"];
			$u->apartamento = $a;
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
		$u = new HabitanteModel();
		if(isset($this->_POST["nombre"]))$u->nombre = $this->_POST["nombre"]; 
		if(isset($this->_POST["identificacion"]))$u->identificacion = $this->_POST["identificacion"]; 
		if(isset($this->_POST["telefono"]))$u->telefono = $this->_POST["telefono"]; 
		if(isset($this->_POST["email"]))$u->email = $this->_POST["email"]; 
		if(isset($this->_POST["foto"]) )$u->foto = $this->_POST["foto"]; 
		
		if(isset($this->_POST["apartamento"])){
			$a  = new ApartamentoModel();
			$a->ID = $this->_POST["apartamento"];
			$u->apartamento = $a;
		}
		if(isset($this->_POST["cliente"]) && $user->is_admin()){
			$a  = new UserModel();
			$a->ID = $this->_POST["cliente"];
			$u->cliente = $a;
		}else {
			$u->cliente = $user;
		}


		$respose = new stdClass;
		if($u->nombre != ""  && $u->save())
		$respose->ok = true;
		else $respose->errorMsj = "Error al crear";
		if($u->nombre == "")$respose->errorMsj.= "\nDebe indicar nombre.";
		header("Content-type:application/json");
		print_r(json_encode($respose));
	}

}