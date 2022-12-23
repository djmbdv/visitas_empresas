<?php
require "database.php";

abstract class Model{
	private static  $table_name;
	private static  $index_name = "ID";
	private static $transform_in_array = array('password' => 'md5','email'=>'strtolower');
	private $isLoaded = false;

	public static function types_array(){
		return null;
	}
	public static function descriptions_array(){
		return null;
	}

	public static function seeds(){

	}
	public static function classname(){
		preg_match("/([\S]*)Model/", get_called_class(), $matches);
		return strtolower($matches[1]);
	}


	public static function remove($key){
			$pdo = DB::get();
			$table = self::get_table_name();
			$index = self::$index_name;
			$sql = "DELETE from $table where $index = :key";
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(":key", $key);
			$stmt->execute();
		return true;
	}

	public static function all_where_like($att, $value,$count = null, $page = null,$loaded = false){
		if(!self::table_exist())self::create_table();
		$sql=" where $att LIKE '%$value%'";
		return self::all($count, $page,$loaded,$sql);
	}

	public static function all_where_and($a = array(),$count = null, $page = null,$loaded = false, $order = "create_at", $desc = true ){
		if(!self::table_exist())self::create_table();
		$sql = "";
		foreach ($a as $key => $value) {
			if($key == 0)$sql=" where $value[0] $value[1] '$value[2]'";
			else $sql.=" and $value[0] $value[1] '$value[2]'";
		}
		return self::all($count, $page,$loaded,$sql, $order,$desc);
	}

	public function all_inner_join_and($tables,$condiciones = array(),$count = null, $page = null,$loaded = false, $order = "create_at", $desc = true ){
		if(!self::table_exist())self::create_table();
		$sql = "";
		foreach ($tables as $key => $table) {
			foreach ($condiciones[$key] as $key2 => $value) {
				if($key2 == 0)$sql.=" inner join $table on $value[0] $value[1] $value[2]";
				else $sql.=" and $value[0] $value[1] $value[2]";
			}
		}
		return self::all($count, $page,$loaded,$sql, $order,$desc);
	}

	public static function all_where_or($a = array(),$count = null, $page = null,$loaded = false){
		if(!self::table_exist())self::create_table();
		$sql = "";
		foreach ($a as $key => $value) {
			if($key == 0)$sql=" where $value[0] $value[1] '$value[2]'";
			else $sql.=" or $value[0] $value[1] '$value[2]'";
		}
		return self::all($count, $page,$loaded,$sql);
	}
	public static function array_presentation(){
		return [];
	}
	
	public static  function presentation_field($x, $s){
		$fun = get_called_class()::array_presentation()[$s];
		return get_called_class()::$fun($x);
	}
	public function get_json($hide = array()){
		$o = $this->no_class_values($hide);
		return json_encode($o);
	}
	public function no_class_values($hide = array()){
		$this->load();
		$o = new stdClass();
		foreach (array_diff(self::get_vars(),$hide) as $key ) {
			$o->{$key} = $this->{$key};
		}
		$o->create_at = $this->get_create_at();
		$o->modified_at = $this->get_modified_at();
		$o->presentation = $this->to_str();
		$o->id = $this->get_key();
		return $o;
	}

	public function exist(){
		if(!is_null($this->get_key())){
			$pdo = DB::get();
			$key = $this->get_key();
			$table = self::get_table_name();
			$index = self::$index_name;
			$sql = "SELECT count($index) as c from $table WHERE $index = :key";
			$stmt = $pdo->prepare($sql);
			$stmt->bindParam(":key", $key);
			$stmt->execute();
			$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
			return $res[0]['c'] != 0; 
		}
		return false;	
	}
	public function load() {
		if(!is_null($this->get_key())){
			$pdo = DB::get();
			$key = $this->get_key();
			$table = self::get_table_name();
			$index = self::$index_name;
			$sql = "SELECT * from $table WHERE $index = :key";
			$stmt  = $pdo->prepare($sql);
			$stmt->bindParam(":key", $key);
			$stmt->execute();
			$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		
			foreach (get_class_vars(get_called_class()) as $k  => $v){
				if ($k == 'table_name'||
				$k == 'types_array'||
				$k == 'index_name' ||
				$k == 'isLoaded'  ||
				$k == 'transform_in_array' ||
				$k == self::$index_name
				)continue;
				try{
					$rp = new ReflectionProperty(get_called_class(), $k);
					$tipo =  $rp->getType()->getName();
					if(is_subclass_of($tipo, get_class())){
						$o = new $tipo();
						$o->{$tipo::get_index()} = $res[0][$k];
						
						$this->{$k} = $o;
					}else throw new Exception("Error Processing Request", 1);
				}catch (Throwable $t){
					$this->{$k} = isset($res[0][$k])?$res[0][$k]:null;
				}
			}
			$this->isLoaded = true;
		}
		return $this;
	}


	public function __set($name,$value){
	//	echo "Set de atributo oculto";
		if(isset(self::$transform_in_array[$name]))$this->{$name} = self::$transform_in_array[$name]($value);
		else $this->{$name} = $value;
	}

	public  function __get($name){
	//	echo "Get de atributo oculto";
		$k =  $this->{$name};
		return $k;
	}

	public static function get_index(){
		return self::$index_name;
	}

	public function __construct(){	
		if (!self::table_exist()) {
			self::create_table();
		}
	}

	public function get_modified_at(){
		$pdo = DB::get();
		$table = self::get_table_name();
		$index = self::$index_name;
		$my_index = $this->{$index};
		$stmt  = $pdo->prepare("select modified_at from $table where $index = '$my_index'");
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $res[0]['modified_at'];
	}
	public function get_create_at(){
		$pdo = DB::get();
		$table = self::get_table_name();
		$index = self::$index_name;
		$my_index = $this->{$index};
		$stmt  = $pdo->prepare("select create_at from $table where $index = '$my_index'");
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return $res[0]['create_at'];
	}

	public static function presentation($o){
		return "".$o->ID;
	} 
	public function to_str(){
		$this->load();
		return get_called_class()::presentation($this);
	}
	public function get_attribute_description($att){
		return get_called_class()::search_description($att);
	}
	public static function search_attribute_form_type($atribute){
		$descriptions = get_called_class()::form_types_array();
		if(!is_null($descriptions))
		foreach ($descriptions as $atributo => $des) {
			if($atribute == $atributo)return $des;
		}
		return 'text';
	}
	public static function form_types_array(){
		return array();
	}

	public static function all($count = null, $page = null,$loaded = false,$sql_aditiional = "", $order = "create_at", $desc = true){
		if(!get_called_class()::table_exist())self::create_table();
		$pdo = DB::get();
		$table = self::get_table_name();
		$index = self::$index_name; 
		$sql = "select $table.$index from $table ";
		$sql.=$sql_aditiional;
		$desc = $desc? "DESC":"ASC";
		$sql.= "  ORDER BY $order $desc";
		if(!is_null($count)){
			$sql .=" limit $count";
			if (!is_null($page)) {
				$offset = (intval($page ) -1)*intval($count) ;
				$sql.=" offset $offset";;
			}
		}
		$stmt = $pdo->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		$array  = [];
		$c = get_called_class();
		foreach ($res as $key => $value) {
			$m = new $c();
			$m->{$index} = $value[$index];
			if($loaded)$m->load();
			$array[] = $m;
		}
		return $array;
	}
	public static function all_json($count = null, $page = null,$loaded = false){
		return json_encode(array_map(function($a){return $a->no_class_values();},  self::all($count, $page,$loaded)));
	}
	public static function get_vars(){
		$vars = [];
		foreach ( get_class_vars(get_called_class()) as $k => $value) {
			if ($k == 'table_name'||
				$k == 'types_array'||
				$k == 'index_name' ||
				$k == 'isLoaded'  ||
				$k == 'transform_in_array'
				)continue;
			$vars[] = $k;
		}
		return $vars;
	}

	public function get_key(){
		$c = get_called_class();
		$index = $c::get_index();
		return isset($this->{$index}) && $this->{$index} != null?$this->{$index}:null; 
	}

	public function G($atributo){
		return is_subclass_of($this->{$atributo},get_class())?
					($this->{$atributo})->to_srt():
					$this->{$atributo};
	}

	public function save(){
		$vars = get_class_vars(get_called_class());
		$table = self::get_table_name();
		$index = self::$index_name;
		
		if(!is_null($this->get_key()) ){
			$key = $this->get_key();	
			$sql = "UPDATE $table ";
			$count = 0;
			foreach ($vars as $k  => $v) {
				if ($k == 'table_name'||
				$k == 'types_array'||
				$k == 'index_name' ||
				$k == 'isLoaded'  ||
				$k == self::$index_name ||
				$k == 'transform_in_array'
				)continue;
				$value = is_subclass_of($this->{$k},get_class())?
					($this->{$k})->get_key():
					$this->{$k};
				if($count++ == 0)$sql.=" set $k = '$value' ";
				else $sql.=",  $k = '$value' ";
			}
			$sql.=" where $index = '$key'";
			$pdo = DB::get();
			try{
			$pdo->query($sql);
			return true;
			}catch(Throwable $t){
				return false;
			}

		}else if(is_null($this->get_key())){
			$sql = "INSERT INTO `$table`";
			$count = 0;
			foreach ($vars as $k  => $v) {
				if ($k == 'table_name'||
				$k == 'types_array'||
				$k == 'index_name' ||
				$k == 'isLoaded'  ||
				$k == 'transform_in_array'||
				$k == self::$index_name
				)continue;
				if(isset($this->{$k})&&!is_null($this->{$k})){	
					if($count++ == 0)$sql.="( `$k`";
					else $sql.=", `$k` ";
				}
			}
			$sql.= ") VALUES ";
			$count = 0;
			foreach ($vars as $k  => $v) {
				if ($k == 'table_name'||
				$k == 'types_array'||
				$k == 'index_name' ||
				$k == 'isLoaded'  ||
				$k == 'transform_in_array' ||
				$k == self::$index_name
				)continue;
				if( isset($this->{$k}) && !is_null($this->{$k})){
				$value = $this->{$k};
				if(is_subclass_of($value, 'Model')){
					$vv = $value->get_key();
					if($count++ == 0)$sql.="( '$vv'";
					else $sql.=", '$vv' ";
				}else{
					if($count++ == 0)$sql.="( '$value'";
					else $sql.=", '$value' ";
				}}
			}
			$sql.=")";
			$pdo = DB::get();
			$nkey = self::next_key();
			try{
			$pdo->query($sql);
			$this->isLoaded = true;
			$this->{$index} = $nkey;
			return true;
			}catch(Throwable $t){
				return false;
			}
		}

		return false;
	}
	public static function next_key(){
		$pdo = DB::get();
		$table = self::get_table_name();
		$q = $pdo->query("SHOW TABLE STATUS LIKE '$table'");
		$next = $q->fetch(PDO::FETCH_ASSOC);
		//var_dump($q);
		return  $next['Auto_increment'];
	}
	public static function table_exist(){
		$pdo = DB::get();
		$tn =  self::get_table_name();
		$dbname = DB::getDBname();
		$stmt = $pdo->prepare("SELECT count(TABLE_NAME) as conteo FROM information_schema.tables WHERE table_schema = '$dbname' and TABLE_NAME like '$tn'");
		$stmt->execute();
		return $stmt->fetchAll()[0]["conteo"] != 0;
	}

	private static function search_type($atribute){
		$types_array = get_called_class()::types_array();
		if(!is_null($types_array))
		foreach ($types_array as $atributo => $tipo) {
			if($atribute == $atributo)return $tipo;
		}
		return 'VARCHAR ( 120 )  NULL';
	}

	public static function search_description($atribute){
		$descriptions = get_called_class()::descriptions_array();
		if(!is_null($descriptions))
		foreach ($descriptions as $atributo => $des) {
			if($atribute == $atributo)return $des;
		}
		return null;

	}
	public function get_attribute_type($att){
		preg_match("/([A-Za-z]+)/", get_called_class()::search_type($att), $matches);
		return strtolower($matches[0]);  
	}

	public static function get_table_name(){
		//self::create_table();
		 if(substr(get_called_class() , -strlen("Model")) == "Model"){
		//	self::$table_name = strtolower(substr(get_called_class() , 0,-strlen("Model")).'s');
			return strtolower(substr(get_called_class() , 0,-strlen("Model")).'s');
		}
		else {
			//self::$table_name = strtolower(get_called_class().'s'); 
			return strtolower(get_called_class().'s');
		}
	}

	public static function count($where = null ){
		if(!self::table_exist())self::create_table();
		$pdo = DB::get();
		$table = self::get_table_name();
		$index = self::$index_name;
		$sql = "select count($index) as cc from $table";
		if($where)
			foreach ($where as $key => $value) {
				if($key == 0)$sql.=" where $value[0] $value[1] '$value[2]'";
				else $sql.=" and $value[0] $value[1] '$value[2]'";
			}
		$stmt  = $pdo->prepare($sql);
		$stmt->execute();
		$res = $stmt->fetchAll(PDO::FETCH_ASSOC);
		return intval($res[0]['cc']);
	}

	public static function create_table(){
		if(self::table_exist())return false;
		$pdo = DB::get();
		$tn =  self::get_table_name();
		$index_name = self::$index_name;
		$sql = "CREATE table `$tn` ( $index_name INT( 11 ) AUTO_INCREMENT PRIMARY KEY";

     	$atributes = get_class_vars(get_called_class());

		foreach ($atributes as $att => $value) {
			if ($att == 'table_name'||
				$att == 'types_array'||
				$att == 'index_name' ||
				$att == 'transform_in_array' ||
				$att == 'isLoaded'  ||
				$att == self::$index_name
			)
					continue;

			try{
				$rp = new ReflectionProperty(get_called_class(), $att);
				$tipo =  $rp->getType()->getName();
				if(is_subclass_of($tipo, get_class())){
					$sql.=",$att  INT( 11 )";
				}else throw new Exception("Error Processing Request", 1);
			}catch (Throwable $t){
				$sql.=",$att ".self::search_type($att);
			}
		}
		$sql.=",`create_at` timestamp NOT NULL DEFAULT current_timestamp(),`modified_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp() );";
		$pdo->query($sql);
		get_called_class()::seeds();
     	return true;
	}

	public static function get_attribute_class($a){
		try{
		$rp = new ReflectionProperty(get_called_class(), $a);
		$type =  $rp->getType()->getName();
		}catch(Throwable $t){
			return "";
		}
		return $type;
	}

}