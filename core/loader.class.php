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
	
	function view($viewname,$var = ''){
		
		$filepath = VIEWS_DIR . $viewname . '.php';
		
		foreach($var as $key=>$value){ 
			$$key=$value; 
		} 
		
		include $filepath;
	}
	
	
}

?>