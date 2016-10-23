<?php
/* 模型示例文件 */
!defined('TOKEN') && exit("Access denied!");

class mwelcome extends mbase{
	
	function __construct(){
		parent::__construct();
	}
	
	function getuserinfo(){
		$sql = "select * from mvc_userinfo";
		$res = $this->db->fetch_all($sql);
		return $res;
	}
	
}

?>