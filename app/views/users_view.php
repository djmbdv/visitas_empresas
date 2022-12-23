<?php
require_once "core/View.php";
/**
 * 
 */
class UsersView extends View
{
	
	function config()
	{
		$this->set_template("users");
	}
}