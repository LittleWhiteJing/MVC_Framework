<?php
!defined('TOKEN') && exit("Access denied!");

class mwelcome extends mbase{
	
	function __construct(){
		parent::__construct();
	}
	
	function test(){
		$sql = "select * from mvc_userinfo";
		$res = $this->db->fetch_first($sql);
		echo $res['username'];
		echo "--------";
		echo $res['password'];
	}
	
}

?>