<?php



require_once "core/Controller.php";


/**
 * 
 */
class LoginController extends ControllerRest
{

	function get(){
		$create = new UserModel();
		if(Session::g('control_visitas')){
			header('location: /');
			return;
		}
		if(UserModel::user_logged()){
			header('location: /menu/');
			return;
		}
		$lv = new LoginView(array(["var" => 1,]));
		return $lv->render();
	}
	function post(){
		$user = $_POST['username'];
		$password = $_POST['password'];
		if(UserModel::login($user,$password)){
			header('location: /menu/');
			return;
		}
		else
		$lv = new LoginView(array("error" => 1,));
		return $lv->render();
	}

	function logout(){
		Session::destroy();
		header('location: /login/');
	}
}