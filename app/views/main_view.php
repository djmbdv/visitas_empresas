<?php

require_once "core/View.php";
/**
 * 
 */
class MainView extends View
{
	
	function config()
	{
		
		$this->set_template("home");
	}
}