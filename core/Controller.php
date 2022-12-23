<?php 

abstract class Controller 
{

	public $argument;

	public function main_method($method = "index",$argument =  null){
		$this->argument = $argument;
		if(method_exists($this,$method)){
			return $this->{$method}();
		}else {
			$this->error();
		}
		
	}

	public function error(){
		print_r("no implemented");
	}

	public function get_param($p){
		$a = preg_split ('/\$/',$this->argument);
		foreach ($a as  $value) {
			$hh =  preg_split ('/=/',$value,2);
			if($hh[0] == $p && isset($hh[1])){
				return $hh[1];
			}
		}
		return null;
	}
	public function is_param($p){
		$a = preg_split ('/\$/',$this->argument);
		return in_array($p, $a);
	}

}

abstract class ControllerRest extends Controller{
	public function main_method($method = "index",$argument =  null){
		$this->argument = $argument;
		if($method == "index")
	 		switch($_SERVER['REQUEST_METHOD']){
				case 'GET': 
					$this->get();
				break;
				case 'POST': 
					$this->_POST= $_POST;
					$this->post();
				break;
				case 'PUT':
					parse_str(file_get_contents('php://input', false , null, 0 , $_SERVER['CONTENT_LENGTH'] ), $this->_PUT);
					$this->put();
				break;
				case 'DELETE':
					$this->delete();
				default:
					break;
		}else if(method_exists($this,$method)){
			return $this->{$method}();
		}else {
			$this->error();
		}
	}
	public function post(){
		$this->any();
	}

	public function put(){
		$this->any();
	}
	public function get(){
		$this->any();
	}
	public function delete(){
		$this->any();
	}
	public function any(){
		print_r("no implemented");
	}
}