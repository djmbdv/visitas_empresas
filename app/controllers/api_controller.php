<?php
require_once "core/Controller.php";



class ApiController extends Controller{

	public function search_employees(){
		header("Content-type:application/json");
		$name = $_POST["s"] ?? "";
		$section = $_POST["section"]??null;
		print_r(EmployeeModel::search_name($name,12,$section));
	}
	public function search_users(){
		header("Content-type:application/json");
		$name = $_POST["s"]?? "";
		print_r(UserModel::search_name($name,12));
	}
	public function search_tipos(){
		header("Content-type:application/json");
		$name = $_POST["s"] ?? "";
		print_r(TipoModel::search_descripcion($name,12));
	}
	public function search_plans(){
		header("Content-type:application/json");
		$name = $_POST["s"] ?? "";
		print_r(PlanModel::search_descripcion($name,12));
	}
	public function search_sections(){
		header("Content-type:application/json");
		$name = $_POST["s"] ??  "";
		$edificio = $_POST["edificio"]??null;
		print_r(SectionModel::search_name($name,12,$edificio));
	}
	public function search_workspaces(){
		header("Content-type:application/json");
		$name = $_POST["s"] ?? "";
		print_r(WorkspaceModel::search_name($name,12));
	}
	public function get_tipo(){
		header("Content-type:application/json");
		$id  = $_POST['key'];
		$h = new TipoModel();
		$h->ID = $id;
		$h->load();
		echo  $h->get_json();
	}
	public function get_workspace(){
		header("Content-type:application/json");
		$id  = $_POST['key'];
		$h = new WorkspaceModel();
		$h->ID = $id;
		$h->load();
		$user = UserModel::user_logged();
		echo  ($user->is_admin())?$h->get_json():$h->get_json(['client']);
	}
	public function get_user(){
		header("Content-type:application/json");
		$id  = $_POST['key'];
		$h = new UserModel();
		$h->ID = $id;
		$h->load();
		echo  $h->get_json();
	}

	public function get_employee(){
		header("Content-type:application/json");
		$id  = $_POST['key'];
		$h = new EmployeeModel();
		$h->ID = $id;
		$h->load();
		$user = UserModel::user_logged();
		echo  ($user->is_admin())?$h->get_json():$h->get_json(['client']);
	}
	public function get_section(){
		header("Content-type:application/json");
		$id  = $_POST['key'];
		$a = new SectionModel();
		$a->ID = $id;
		$a->load();
	//	var_dump($a);

		$user = UserModel::user_logged();
		echo  ($user->is_admin())?$a->get_json():$a->get_json(['client']);	}

}