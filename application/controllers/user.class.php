<?php 
!defined('TOKEN') && exit("Access denied!"); 

class user extends base{
	
	var $whitelist = "";
	
	public function __construct(){
		parent::__construct();
		$this->load->model('muser');
	}
	
	public function index(){	
		$info = $this->muser->getuserinfo();
		$data['userinfo'] = $info;
		$this->load->view('user',$data);
	}
	
	public function show(){
		$this->load->view('show');
	}
	
	public function add(){
		$arr['username'] = $_POST['username'];
		$arr['password'] = $_POST['password'];
		$res = $this->muser->adduserinfo($arr);
		$data['msg'] = $res ? '添加成功!' : '添加失败!';
		$this->load->view('message',$data);
	}
}

?>