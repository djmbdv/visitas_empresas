<?php

require_once "core/Utils.php";
require 'vendor/autoload.php';

function autoload_controller($nombreClase) {
	if(preg_match("/([\S]*)Controller/", $nombreClase, $matches)){
		$archivo = "app/controllers/".strtolower($matches[1]).'_controller.php';
		if(file_exists($archivo)) {
        	require_once($archivo);
    	} else {

       		 die("El archivo $archivo no se ha podido encontrar.");
    	}
	}
}

spl_autoload_register('autoload_controller');

function autoload_view($nombreClase) {
	if(preg_match("/([\S]*)View/", $nombreClase, $matches)){
		$archivo = "app/views/".strtolower($matches[1]).'_view.php';
		if(file_exists($archivo)) {
        	require_once($archivo);
    	} else {
       		 die("El archivo $archivo no se ha podido encontrar.");
    	}
	}
}

spl_autoload_register('autoload_view');

function autoload_model($nombreClase) {
	if(preg_match("/([\S]*)Model/", $nombreClase, $matches)){
		$archivo = "app/models/".strtolower($matches[1]).'_model.php';
		if(file_exists($archivo)) {
        	require_once($archivo);
    	} else {
    		throw new Exception("Error Processing Request", 1);
    		
       		 die("El archivo $archivo no se ha podido encontrar.");
    	}
	}
}



spl_autoload_register('autoload_model');