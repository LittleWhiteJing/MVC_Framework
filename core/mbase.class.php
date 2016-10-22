<?php 
!defined('TOKEN') && exit("Access denied!");

require_once ROOT_DIR . 'lib/db.class.php';

require_once APP_DIR . 'configures/config.php';

class mbase {
	
	var $db;
	
	function __construct(){

		$this->init_db();
	}
	
	function init_db(){

		$this->db = new db(DB_HOST, DB_USER, DB_PW, DB_NAME, DB_CHARSET, DB_CONNECT);
	} 
}

?>