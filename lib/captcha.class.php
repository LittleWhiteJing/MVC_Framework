<?php
/****************************************
 * ��֤�����ļ�
 ****************************************
 * captcha.class.php
 ****************************************
 */
class captcha{
	//��֤��λ��
	public $number;
	//��֤���ַ�
	public $code;
	//��֤����
	public $width;
	//��֤��߶�
	public $height;
	//��֤������
	public $type;
	//��֤��·��
	public $filepath;
	//��֤���ļ�
	public $fileurl;
	
	/*
	__construct��page�Ĺ��캯���������ڴ������ʱ���Զ�����.
	
	ʵ��������ʱ��Ҫ����һ������$config���£�
	@$config['number']     ������֤��λ�� [Ĭֵ��Ϊ��λ]
	@$config['witdth']     ��֤��ͼƬ��� [Ĭ��Ϊ80����]
	@$config['height']     ��֤��ͼƬ�߶� [Ĭ��Ϊ30����]
	@$config['type']       ��֤������     [Ĭ��Ϊ��һ��]
	@$config['filepath']   ��֤������ļ� [Ĭ��Ϊָ��λ��]
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
	��ʾ��֤��
	*/
	public function create_captcha(){
		//��ȡ�ַ���������SESSION
		$this->code = $this->create_string($this->number,$this->type);
		session_start();
		$_SESSION['captcha'] = $this->code;
		//��������
		$im = imagecreatetruecolor($this->width,$this->height);
		//ָ��������ɫ
		$color[] = imagecolorallocate($im,111,0,55);
		$color[] = imagecolorallocate($im,0,77,0);
		$color[] = imagecolorallocate($im,0,0,160);
		$color[] = imagecolorallocate($im,211,111,0);
		$color[] = imagecolorallocate($im,221,0,0);
		//ָ��������ɫ
		$bg = imagecolorallocate($im,200,200,200);
		//��䱳��
		imagefill($im,0,0,$bg);
		//���Ʊ߿�
		imagerectangle($im,0,0,$this->width-1,$this->height-1,$color[rand(0,4)]);
		
		//�����Ӹ��ŵ�
		for($i = 0;$i < 200;$i++){
			$radcolor = imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
			imagesetpixel($im,rand(0,$this->width),rand(0,$this->height),$radcolor);
		}
		//�����Ӹ�����
		for($i = 0;$i < 5;$i++){
			$radcolor = imagecolorallocate($im,rand(0,255),rand(0,255),rand(0,255));
			imageline($im,rand(0,$this->width),rand(0,$this->height),rand(0,$this->width),rand(0,$this->height),$radcolor);
		}	
		
		//�����ɵ��ַ�д��ͼ��
		for($i = 0;$i < $this->number;$i++){
			imagettftext($im,18,rand(-40,40),8+(18*$i),24,$color[rand(0,4)],"./public/captchas/cambriaz.ttf",$this->code[$i]);
		}
		
		do{
			$newfile = date('YmdHis').rand(1000,9999).".png";
		}while(file_exists($this->filepath . $newfile));
		
		$this->fileurl = $this->filepath . $newfile;
		
		imagepng($im,$this->fileurl);
		//����ͼ��
		imagedestroy($im);
	}
	
	/**
	* �������һ����֤�����ݵĺ���
	* @param $m ��֤��λ��
	* @param $type ��֤������ 0:������ 1:����+Сд��ĸ 2:����+��Сд��ĸ
	*/
	private function create_string($num,$type){
		//ָ���ַ���
		$str = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
		//�������������ַ���
		$tmp = array(9,35,strlen($str)-1);
		//��ȡ�ַ���
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
