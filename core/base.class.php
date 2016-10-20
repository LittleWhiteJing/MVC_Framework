<?php 
!defined('TOKEN') && exit("Access denied!");

require ROOT_DIR . "/core/loader.class.php";

class base {
	
	var $db;
	
	var $cache;
	
	var $load;
	
	function __construct(){
		$this->init_db();
		$this->init_cache();
		$this->init_loader();
	}
	
	function init_db(){
		$this->db = new db(DB_HOST, DB_USER, DB_PW, DB_NAME, DB_CHARSET, DB_CONNECT);
	}
	
	function init_cache(){
		$this->cache = new cache($this->db);
		$sysinfo = $this->cache->load('sysinfo');
		$userinfo = $this->cache->load('userinfo');
	}
	
	function init_loader(){
		$this->load = new loader($this);
	}
	
	function set_var($classname,$classobj){
		$this->$classname = $classobj;
	}
	
}

?>