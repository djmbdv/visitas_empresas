<?php

require_once "core/Controller.php";


/**
 * 
 */
class HomeController extends Controller
{
	
	
	function index(){
		Session::load();
		$user = UserModel::user_logged();
		if(is_null($user)){
			header('location: /login/');
			return;
		}
		$user->load();
		//print_r($user);
		$main_view = new MainView(['user'=>$user]);

		return $main_view->render();
	}

	function saludo(){
		Session::load();
		$user = UserModel::user_logged();
		if(is_null($user)){
			header('location: /login/');
			return;
		}
		$user->load();
		//print_r($user);
		$main_view = new SaludoView(['user'=>$user]);
		return $main_view->render();
	}
	function error(){
		http_response_code(404);
		$error_view = new ErrorView();
		return $error_view->render();
	}
}