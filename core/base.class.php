<?php 
class base {
	
	var $db;
	
	var $cache;
	
	function __construct(){
		$this->init_db();
		$this->init_cache();
	}
	
	function init_db(){
		$this->db = new db(DB_HOST, DB_USER, DB_PW, DB_NAME, DB_CHARSET, DB_CONNECT);
	}
	
	function init_cache(){
		$this->cache = new cache($this->db);
		$sysinfo = $this->cache->load('sysinfo');
		$userinfo = $this->cache->load('userinfo');
	}
	
}

?>