<?php
require_once "core/View.php";
/**
 * 
 */
class ErrorView extends View
{
	
	function config()
	{
		$this->set_template("error");
	}
}