<?php
/****************************************
 * 验证码类文件
 ****************************************
 * captcha.class.php
 ****************************************
 */
class captcha{
	//验证码位数
	public $number;
	//验证码字符
	public $code;
	//验证码宽度
	public $width;
	//验证码高度
	public $height;
	//验证码类型
	public $type;
	//验证码路径
	public $filepath;
	//验证码文件
	public $fileurl;
	
	/*
	__construct是page的构造函数，用来在创建类的时候自动运行.
	
	实例化该类时需要传递一个数组$config如下：
	@$config['number']     生成验证码位数 [默值认为四位]
	@$config['witdth']     验证码图片宽度 [默认为80像素]
	@$config['height']     验证码图片高度 [默认为30像素]
	@$config['type']       验证码种类     [默认为第一种]
	@$config['filepath']   验证码输出文件 [默认为指定位置]
	*/
	public function __construct($config){
		$this->number = isset($config['number']) ? $config['number'] : 4;
		$this->width = isset($config['width']) ? $config['width'] : 80;
		$this->height = isset($config['height']) ? $config['height'] : 30;
		$this->type = isset($config['type']) ? $config['type'] : 0;
		$this->filepath = isset($config['filepath']) ? $config['filepath'] : './public/captchas/';
		$this->create_captcha();
	}
	/*
	显示验证码
	*/
	public function create_captcha(){
		//获取字符串并放入SESSION
		$this->code = $this->create_string($this->number,$this->type);
		session_start();
		$_SESSION['captcha'] = $this->code;
		//创建画布
		$im = imagecreatetruecolor($this->width,$this->height);
		//指定字体颜色
		$color[] = imagecolorallocate($im,111,0,55);
		$color[] = imagecolorallocate($im,0,77,0);
		$color[] = imagecolorallocate($im,0,0,160);
		$color[] = imagecolorallocate($im,211,111,0);
		$color[] = imagecolorallocate($im,221,0,0);
		//指定背景颜色
		$bg = imagecolorallocate($im,200,200,200);
		//填充背景
		imagefill($im,0,0,$bg);
		//绘制边框
		imagerectangle($im,0,0,$this->width-1,$this->height-1,$color[rand(0,4)]);
		
		//随机添加干扰点
		for($i = 0;$i < 200;$i++){
			$radcolor = imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
			imagesetpixel($im,rand(0,$this->width),rand(0,$this->height),$radcolor);
		}
		//随机添加干扰线
		for($i = 0;$i < 5;$i++){
			$radcolor = imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
			imageline($im,rand(0,$this->width),rand(0,$this->height),rand(0,$this->width),rand(0,$this->height),$radcolor);
		}	
		
		//将生成的字符写入图像
		for($i = 0;$i < $this->number;$i++){
			imagettftext($im,18,rand(-40,40),8+(18*$i),24,$color[rand(0,4)],"./public/captchas/cambriaz.ttf",$this->code[$i]);
		}
		
		do{
			$newfile = date('YmdHis').rand(1000,9999).".png";
		}while(file_exists($this->filepath . $newfile));
		
		$this->fileurl = $this->filepath . $newfile;
		
		imagepng($im,$this->fileurl);
		//销毁图像
		imagedestroy($im);
	}
	
	/**
	* 随机生成一个验证码内容的函数
	* @param $m 验证码位数
	* @param $type 验证码类型 0:纯数字 1:数字+小写字母 2:数字+大小写字母
	*/
	private function create_string($num,$type){
		//指定字符串
		$str = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		//定制三种类型字符串
		$tmp = array(9,35,strlen($str)-1);
		//获取字符串
		$char = "";
		for($i = 0;$i < $num;$i++){
			$char .= $str[rand(0,$tmp[$type])]; 
		}
		return $char; 
	}
	
	public function fetch_captcha(){
		return $this->fileurl;
	}
	
	
}
