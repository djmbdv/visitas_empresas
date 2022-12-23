<?php
require_once "core/Controller.php";



class ApiController extends Controller{

	public function search_habitantes(){
		header("Content-type:application/json");
		$nombre = $_POST["s"] ?? "";
		$apartamento = $_POST["apartamento"]??null;
		print_r(HabitanteModel::search_nombre($nombre,12,$apartamento));
	}
	public function search_users(){
		header("Content-type:application/json");
		$nombre = $_POST["s"]?? "";
		print_r(UserModel::search_nombre($nombre,12));
	}
	public function search_tipos(){
		header("Content-type:application/json");
		$nombre = $_POST["s"] ?? "";
		print_r(TipoModel::search_descripcion($nombre,12));
	}
	public function search_plans(){
		header("Content-type:application/json");
		$nombre = $_POST["s"] ?? "";
		print_r(PlanModel::search_descripcion($nombre,12));
	}
	public function search_apartamentos(){
		header("Content-type:application/json");
		$nombre = $_POST["s"] ??  "";
		$edificio = $_POST["edificio"]??null;
		print_r(ApartamentoModel::search_nombre($nombre,12,$edificio));
	}
	public function search_edificios(){

		header("Content-type:application/json");
		$nombre = $_POST["s"] ?? "";
		print_r(EdificioModel::search_nombre($nombre,12));
	}
	public function get_tipo(){
		header("Content-type:application/json");
		$id  = $_POST['key'];
		$h = new TipoModel();
		$h->ID = $id;
		$h->load();
		echo  $h->get_json();
	}
	public function get_edificio(){
		header("Content-type:application/json");
		$id  = $_POST['key'];
		$h = new EdificioModel();
		$h->ID = $id;
		$h->load();
		$user = UserModel::user_logged();
		echo  ($user->is_admin())?$h->get_json():$h->get_json(['cliente']);
	}
	public function get_user(){
		header("Content-type:application/json");
		$id  = $_POST['key'];
		$h = new UserModel();
		$h->ID = $id;
		$h->load();
		echo  $h->get_json();
	}

	public function get_habitante(){
		header("Content-type:application/json");
		$id  = $_POST['key'];
		$h = new HabitanteModel();
		$h->ID = $id;
		$h->load();
		$user = UserModel::user_logged();
		echo  ($user->is_admin())?$h->get_json():$h->get_json(['cliente']);
	}
	public function get_apartamento(){
		header("Content-type:application/json");
		$id  = $_POST['key'];
		$a = new ApartamentoModel();
		$a->ID = $id;
		$a->load();
	//	var_dump($a);

		$user = UserModel::user_logged();
		echo  ($user->is_admin())?$a->get_json():$a->get_json(['cliente']);	}

}