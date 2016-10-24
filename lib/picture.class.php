<?php
class picture{
	
	//原图片路径
	private $resFile = '';
	//新图片路径
	private $newFile = '';
	//新图片宽度
	private $newWidth = '';
	//新图片高度
	private $newHeight = '';
	//错误提示信息
	public $mesg = array('error'=>true,'info'=>'');
	/*
	__construct是page的构造函数，用来在创建类的时候自动运行.

	实例化该类时需要传递一个数组$config如下： 
	@$config['oldpath']  原图片所在文件路径 
	@$config['newpath']  新图片写入文件路径
	@$config['width']    新图片设置的宽度
	@$config['height']   新图片设置的高度
	*/
	public function __construct($config){
		$this->resFile = $config['oldpath'];
		$this->newFile = $config['newpath'];
		$this->newWidth = isset($config['width']) ? $config['width'] : 48;
		$this->newHeight = isset($config['height']) ? $config['height'] : 48;
	}
	
	/* 
	创建缩略图
	*/
	public function create(){
		
		//获取原图像信息
		$info = $this->getImageInfo();
		if(!$info){
			$this->mesg['info'] = "原图像信息获取失败!";
			return $this->mesg;
		}
		
		//生成缩略数据
		$new_info = $this->tmbEffects($info['width'], $info['height'],  $this->newWidth, $this->newHeight);
		
		//创建图像
		if($info['mime'] == 'image/jpeg'){
			$img = imagecreatefromjpeg($this->resFile);
		}elseif ($info['mime'] == 'image/png'){
			$img = imagecreatefrompng($this->resFile);
		}elseif ($info['mime'] == 'image/gif'){
			$img = imagecreatefromgif($this->resFile);
		}else{
			$this->mesg['info'] = "新图像类型创建失败!";
			return $this->mesg;
		}
		
		//创建图像
		if ($img &&  false != ($tmp = imagecreatetruecolor($this->newWidth, $this->newHeight))){
			//拷贝图像并调整大小
			if (!imagecopyresampled($tmp, $img, 0, 0, $new_info[0], $new_info[1], $this->newWidth, $this->newHeight, $new_info[2], $new_info[3])) {
				$this->mesg['info'] = "图像拷贝失败!";
				return $this->mesg;
			}
			//输出图象到文件
			$result = imagejpeg($tmp, $this->newFile, 80);
			//销毁图象
			imagedestroy($img);
			imagedestroy($tmp);
		}
		
		$this->mesg['error'] = $result ? false : true;
		$this->mesg['info'] = $this->newFile;
		return $this->mesg;
	}
	
	/* 
	显示并输出图片到浏览器中
	*/
	public function show(){
		$file = $this->newFile;
		header('Content-type: image/jpeg');
		header('Content-length: ' . filesize($file));
		readfile($file);
	}
	
	/*
	获取源图像信息，返回封装后的数组
	*/
	private function getImageInfo() {
		//获取图像尺寸信息
		$imageInfo = getimagesize($this->resFile);
		//成功获取尺寸信息
		if (false !== $imageInfo) {
			//获取图像类型
			$imageType = strtolower(substr(image_type_to_extension($imageInfo[2]),1));
			//获取图像大小
			$imageSize = filesize($this->resFile);
			//封装图像信息
			$info = array(
				'width' => $imageInfo[0], 
				'height' => $imageInfo[1],
				'type' => $imageType,
				'size' => $imageSize,
				'mime' => $imageInfo['mime']
			);
			return $info;
		} else {
			return false;
		}
	}
	/*
	处理缩放数据，返回缩放后图像数据
	*/
	private function tmbEffects($resWidth, $resHeight, $tmbWidth, $tmbHeight, $crop = true) {
		//初始化
		$x = $y = 0;
		$size_w = $size_h = 0;
		//计算缩放比例
		$scale1  = $resWidth / $resHeight;
		$scale2  = $tmbWidth / $tmbHeight;
		
		if ($scale1 < $scale2){
			$size_w = $resWidth;
			$size_h = round($size_w * ($tmbHeight / $tmbWidth));
			$y = ceil(($resHeight - $size_h)/2);
		}else{
			$size_h = $resHeight;
			$size_w = round($size_h * ($tmbWidth / $tmbHeight));
			$x = ceil(($resWidth - $size_w)/2);
		}
		//返回缩放后的定点坐标和宽度和高度
		return array($x, $y, $size_w, $size_h);
	}
	
}
?>