<?php 
!defined('TOKEN') && exit("Access denied!"); 

class welcome extends base{
	
	var $whitelist = "";
	
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$data['app'] = "welcome";
		$data['controller'] = "welcome";
		$data['method'] = "index";
		$this->load->view('welcome',$data);
	}
	
	public function show(){ 
	    $sql = "select * from mvc_userinfo";
		$res = $this->db->fetch_first($sql);
		echo $res['username'];
		echo "--------";
		echo $res['password'];
		redirect('welcome','test');
	}
	
	public function test(){
		echo "This is the method to jump!";
	}
	
	
	public function message(){
		
	}
}

?>