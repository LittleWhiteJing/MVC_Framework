<?php
!defined('TOKEN') && exit("Access denied!");

class loader {
	
	var $baseobj;
	
	function __construct(&$baseobj){
		
		$this->baseobj = $baseobj;
	}
	
	function model($modelname){
		
		$pos = strrpos($modelname,"/");
		
		if($pos !== false){
			$classname = substr($modelname,$pos+1);
			$filepath = MODELS_DIR . $modelname . '.class.php';
		}else{
			$classname = $modelname;
			$filepath = MODELS_DIR . $modelname . '.class.php';
		}
		
		require ROOT_DIR . "core/mbase.class.php";
		
		include $filepath;
		
		$classobj = new $classname();

		$this->baseobj->set_var($classname,$classobj);
	}
	
	function view($viewname,$var = array()){
		
		$filepath = VIEWS_DIR . $viewname . '.php';
		
		if(!empty($var)){
			foreach($var as $key=>$value){ 
				$$key=$value; 
			}
		}			
		
		include $filepath;
	}
	
	function library($libname,$var = array()){
		
		$filepath = ROOT_DIR . 'lib/' . $libname . '.class.php';
		
		include $filepath;
		
		if(!empty($var))
			$classobj = new $libname($var);
		else
			$classobj = new $libname();
		
		$this->baseobj->set_var($libname,$classobj);
	}
	
	
}

?>