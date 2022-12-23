<?php

require_once "core/View.php";
/**
 * 
 */
class MenuView extends View
{
	
	function config()
	{
		$this->set_template("menu");
	}
}