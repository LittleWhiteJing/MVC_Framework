<?php 
!defined('TOKEN') && exit("Access denied!"); 

class muser extends mbase{
	
	public function __construct(){
		parent::__construct();
	}
	
	public function getuserinfo(){
		$sql = "select * from mvc_userinfo";
		$res = $this->db->fetch_all($sql);
		return $res;
	}
	
	public function adduserinfo($info){
		$sql = "insert into mvc_userinfo(username,password) values('".$info['username']."','".$info['password']."')";
		$this->db->query($sql);
		if($this->db->affected_rows())
			return true;
		else
			return false;
	}
}

?>