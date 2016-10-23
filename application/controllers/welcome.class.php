<?php
/* MVC框架示例控制器文件 */ 
!defined('TOKEN') && exit("Access denied!"); 

class welcome extends base{
	
	var $whitelist = "";
	
	public function __construct(){
		parent::__construct();
	}
	
	public function index(){
		$data['app'] = "application";
		$data['controller'] = "welcome";
		$data['method'] = "index";
		$this->load->view('welcome',$data);
	}
	
	public function show(){ 
		$this->load->model('mwelcome');
		$data['info'] = $this->mwelcome->getuserinfo();
		$this->load->view('welcome',$data);
	}
		
	public function message(){
		
	}
}

?>