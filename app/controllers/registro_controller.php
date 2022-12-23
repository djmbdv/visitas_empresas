<?php



require_once "core/Controller.php";
require_once "core/Session.php";


/**
 * 
 */
class RegistroController extends Controller
{

	function index(){
		Session::load();
		$user = UserModel::user_logged();
		if(is_null($user)){
			header('location: /login/');
			return;
		}
		
		if(Session::g('control_visitas')){
			header('location: /');
			return;
		}
		
		$rv = new RegistroView(array('user' => $user ));
		return $rv->render();
	}


	function access(){
		Session::load();
		$user = UserModel::user_logged();
		if(isset($this->_POST["pin"])){}
	}

	function menu(){
		Session::load();
		$user = UserModel::user_logged();
		if(is_null($user)){
			header('location: /login/');
			return;
		}
		if(Session::g('control_visitas')){
			header('location: /');
			return;
		}
		
		
		$mv = new MenuView(array('user' => $user ));
		return $mv->render();
	}

	function active_control_visitas(){
		Session::load( array('control_visitas' => true ));
		$user = UserModel::user_logged();
		if(is_null($user)){
			header('location: /logout/');
			return;
		}
		header('location: /');
	}
}