<?php
require_once "core/View.php";
/**
 * 
 */
class EmployeesView extends View
{
	
	function config()
	{
		$this->set_template("employees");
	}
}