<?php

require_once "core/View.php";
/**
 * 
 */
class LoginView extends View
{
	
	function config()
	{
		$this->set_template("login");
	}
}