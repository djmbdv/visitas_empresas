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
		$hc = new HabitantesController();
		$uc = new UsersController();
		$ac = new ApartamentosController();
		$ec = new EdificiosController();
		$adc = new AdministracionController();

	$dashboard_router->link("visitas",$vc);
	$dashboard_router->link("reporte", $vc, "reporte");
	$dashboard_router->link("residentes", $hc);
	$dashboard_router->link("usuarios", $uc);
	$dashboard_router->link("account",$uc,"account");
	$dashboard_router->link("apartamentos", $ac);
	$dashboard_router->link("apartamentos/edificio", $ac);
	$dashboard_router->link("crearApartamentos",$ac,"crear_apartamentos");
	$dashboard_router->link("edificios", $ec);
	$dashboard_router->link("administracion", $adc);
	$api_router = new Router();
	$api_router->link("habitante",$apic,"get_habitante");
	$api_router->link("habitantes",$apic,"search_habitantes");
	$api_router->link("users",$apic,"search_users");
	$api_router->link("user",$apic,"get_user");
	$api_router->link("tipos",$apic,"search_tipos");
	$api_router->link("tipo",$apic,"get_tipo");
	$api_router->link("visita",$apic,"get_visita");
	$api_router->link("visitas",$apic,"search_visitas");
	$api_router->link("apartamento",$apic,"get_apartamento");
	$api_router->link("apartamentos",$apic,"search_apartamentos");
	$api_router->link("edificios",$apic,"search_edificios");
	$api_router->link("plans",$apic,"search_plans");

	$api_router->link("edificio",$apic,"get_edificio");
	

$main_router->link("api",$api_router);
$main_router->link("dashboard",$dashboard_router);
$main_router->link("menu", $rc , "menu");
$main_router->link("activec",$rc,"active_control_visitas");
//var_dump($main_router);
$main_router->set_link($_GET['g']);

$main_router->call();
