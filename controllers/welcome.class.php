<?php 
!defined('TOKEN') && exit("Access denied!"); 

class welcome extends base{
	
	var $whitelist = "";
	
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		echo "This is Welcome Controller index Method!!";
	}
	
	public function show(){ 
	    $sql = "select * from mvc_userinfo";
		$res = $this->db->fetch_first($sql);
		echo $res['username'];
		echo "--------";
		echo $res['password'];
	}
	
	public function message(){
		
	}
}

?>