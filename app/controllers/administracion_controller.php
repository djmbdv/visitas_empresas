<?php

require_once "core/Controller.php";
require_once "core/Session.php";


/**
 * 
 */
class AdministracionController extends ControllerRest{

	function get(){

		
		//echo FacturaModel::count();
	//	return;
		Session::load();
		VisitaModel::create_table();
		$user = UserModel::user_logged();

		if(is_null($user)){
			header('location: /login/');
			return;
		}
		if(Session::g('control_visitas')){
			header('location: /');
			return;
		}
		$headers  = VisitaModel::get_vars();
		$headers[] = "fecha";
		$page = $this->get_param("page");
		$desde = $this->get_param("desde");
		$hasta = $this->get_param("hasta");
		$apartamento =  $this->get_param("apartamento");
		$condicion = [["tipo","=","2"]];
		$visitado = $this->get_param("visitado");
		$page = $page?$page:1;
		$vars =["username", "name","plan","cargo"];
		$count = UserModel::count($condicion);
		$items = UserModel::all_where_and($condicion,20,$page);	
		
		$vv = new AdministracionView(array(
			'items' => $items,
			'filtros'=> ['desde' => $desde ,'hasta' => $hasta ,'visitado' => $visitado,'apartamento'=>$apartamento],
			'user'=> $user,
			"table_vars" => $vars,
			'page'=> $page,
			'count'=>$count,
			"modal_class" => 'UserModel',
            'hide_modified' => true,
            'hide_actions' => true,
            'hide_create' => true
		));
		return $vv->render();
	}
}