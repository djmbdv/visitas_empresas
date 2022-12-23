<?php

class Template {
	public $parts;
	public $parent;
	public $child;
	function __construct($model){
		$this->parts = [];
		$this->model = $model;
		$this->child = null;
		$this->parent = null;
		$this->config();
	}
	public function T($name){
		return isset($this->model[$name])?$this->model[$name]:null ;
	}
	public function add_part( $name,$template, $private_model = null){
		require_once("app/views/templates/".$template.".template.php");
		$t = ucfirst($template).'Template';
		$this->parts[$name] = new $t($private_model?$private_model:$this->model);
	}
	public function set_child(Template $child){
		$this->child = $child;
	//	$this->child->set_parent($this);
	}

	public function set_parent_object(Template $patent){
		$this->parent = $parent; 
	}


	public function set_parent($template){
		require_once("app/views/templates/".$template.".template.php");
		$t = ucfirst($template).'Template';

		$parent = new $t($this->model);
		$parent->child =$this;

		$this->parent = $parent;	
	}
	public function render_part($name){
		if(isset($this->parts[$name]))
			$this->parts[$name]->render();
	}

	public function render_child(){
		if(isset($this->child)){
			$this->child->render();
		}
	}

	public function S($res){
		return Config::$base_url."/_static/$res";
	}
	public function SS($res){
		$t = filemtime("_static/$res");
		return Config::$base_url."/_static/$res?$t";	
	}

	public function config(){
	}
	public function draw(){
		if(!is_null($this->parent))$this->parent->draw();
		else $this->render();
	}

	function render(){
		echo "Void Template";
	}
}