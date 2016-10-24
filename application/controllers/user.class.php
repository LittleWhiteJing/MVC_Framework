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
		$arr = getcurrcm();
		$config['filepath'] = SITE_URL . IN_FILE . "?c=".$arr['controller']."&m=".$arr['method'];
		$config['year'] = 2017;
		$config['month'] = 1;
		$this->load->library('calendar',$config);
		$data['cal'] = $this->calendar->generate(); 
		$this->load->view('show',$data);
	}
	
	public function add(){
		$arr['username'] = $_POST['username'];
		$arr['password'] = $_POST['password'];
		$res = $this->muser->adduserinfo($arr);
		$data['msg'] = $res ? '添加成功!' : '添加失败!';
		$this->load->view('message',$data);
	}
	
	public function upload(){
		$config['upfile'] = $_FILES['testfile'];
		$config['filepath'] = "./public/images/";
		$config['maxsize'] = 100000000;
		$this->load->library('upload',$config);
		$res = $this->upload->do_upload();
		if($res['error']){
			echo "文件上传失败:".$res['info'];
		}else{
			$config['oldpath'] = $res['info'];
			$config['newpath'] = "./public/images/new_file.png";
			$this->load->library('picture',$config);
			$res = $this->picture->create();
			if($res['error']){
				echo "文件缩放失败!".$res['info'];
			}else{
				echo "文件缩放成功!";
			}
		}
	}
	
	public function showcode(){
		$config['number'] = 4;
		$config['width'] = 80;
		$config['height'] = 30;
		$config['type'] = 1;
		$this->load->library('captcha',$config);
		$data['url'] = $this->captcha->fetch_captcha();
		$this->load->view('showcode',$data);
	}
	
	public function checkcode(){
		$code = $_POST['checkcode'];
		session_start();
		if($code == $_SESSION['captcha']){
			echo "success!!";
		}else{
			echo "failed!!";
		}
	}
	
	public function message(){
		
	}
}

?>