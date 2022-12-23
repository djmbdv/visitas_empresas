<?php

require_once "core/View.php";
/**
 * 
 */
class SaludoView extends View
{
	
	function config()
	{
		$this->set_template("saludo");
	}
}