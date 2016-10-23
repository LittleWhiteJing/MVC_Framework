<?php 
!defined('TOKEN') && exit("Access denied!"); 

class user extends base{
	
	var $whitelist = "";
	
	public function __construct(){
		parent::__construct();
		$this->load->model('muser');
	}
	
	public function index(){
		
		$arr = getcurrcm();
		$config['each_disNums'] = 3; 
		$config['nums'] = $this->muser->fetchnumrows(); 
		$config['current_page'] = isset($_GET['p']) ? $_GET['p'] : 1;
		$config['sub_pages'] = 5; 
		$config['subPage_link'] = SITE_URL . IN_FILE ."?c=".$arr['controller']."&m=".$arr['method']."&p="; 
		$config['subPage_type'] = 1; 
		
		$this->load->library('page',$config);
		$data['link'] = $this->page->show();
		
		$offset = ($this->page->current_page - 1)*$this->page->each_disNums;
		$nums = $this->page->pageNums;
		
		$info = $this->muser->getsomeinfo($offset,$nums);
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
	
	public function message(){
		
	}
}

?>