<?php


/**
 * 
 */
class LayoutTemplate extends Template
{
	
	function config(){
		$this->add_part('header','header');
		$this->add_part('footer','footer');
	}

	function render(){
		$this->render_part('header');
		$this->render_child();
		$this->render_part('footer');
	}
}