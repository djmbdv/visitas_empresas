<?php

require_once 'core/Router.php';

$hc  = new HomeController();
$lc = new LoginController();
$fc = new FotoController();
$main_router = new Router();
$main_router->link("", $hc);
$main_router->setNoRoute($hc, "error");
$main_router->link("login",$lc );
$main_router->link("logout",$lc,"logout");
$main_router->link("foto", $fc);
$main_router->link("saludo", $hc, "saludo");
$main_router->link("visita",$fc,"visita");

// ruta /registro
	$rc = new RegistroController();
	$apic = new ApiController();
		
	$dashboard_router = new Router();
	$dashboard_router->link("",$rc);


		//ruta /registro/visitas
		$vc = new VisitasController();
		$hc = new EmployeesController();
		$uc = new UsersController();
		$ac = new SectionsController();
		$ec = new WorkspacesController();
		$adc = new AdministracionController();

	$dashboard_router->link("visitas",$vc);
	$dashboard_router->link("reporte", $vc, "reporte");
	$dashboard_router->link("employees", $hc);
	$dashboard_router->link("users", $uc);
	$dashboard_router->link("account",$uc,"account");
	$dashboard_router->link("sections", $ac);
	$dashboard_router->link("sections/workspace", $ac);
	$dashboard_router->link("crearApartamentos",$ac,"crear_apartamentos");
	$dashboard_router->link("workspaces", $ec);
	$dashboard_router->link("administracion", $adc);
	$api_router = new Router();
	$api_router->link("employee",$apic,"get_employee");
	$api_router->link("employees",$apic,"search_employees");
	$api_router->link("users",$apic,"search_users");
	$api_router->link("user",$apic,"get_user");
	$api_router->link("tipos",$apic,"search_tipos");
	$api_router->link("tipo",$apic,"get_tipo");
	$api_router->link("visita",$apic,"get_visita");
	$api_router->link("visitas",$apic,"search_visitas");
	$api_router->link("section",$apic,"get_section");
	$api_router->link("sections",$apic,"search_sections");
	$api_router->link("workspaces",$apic,"search_workspaces");
	$api_router->link("bloodTypes",$apic,"search_bloodTypes");
	$api_router->link("eps",$apic,"search_eps");
	$api_router->link("arl",$apic,"search_arl");
	$api_router->link("plans",$apic,"search_plans");

	$api_router->link("workspace",$apic,"get_workspace");
	

$main_router->link("api",$api_router);
$main_router->link("dashboard",$dashboard_router);
$main_router->link("menu", $rc , "menu");
$main_router->link("activec",$rc,"active_control_visitas");
//var_dump($main_router);
$main_router->set_link($_GET['g']);

$main_router->call();
