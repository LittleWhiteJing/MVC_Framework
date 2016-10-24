<?php
/*******************************
 *  文件上传类
 *******************************
 *  upload.class.php
 *******************************
 */
class upload {
	//上传文件信息
	public $upfile;
	//文件存放路径
	public $filepath;
	//文件最大限制
	public $maxsize;
	//封装上传信息
	public $mesg = array('error'=>true,'info'=>'');
	//允许上传类型
	public $typelist = array('image/jpeg','image/png','image/jpg','image/gif','text/plain');
	
	/*
	__construct是page的构造函数，用来在创建类的时候自动运行.
	
	实例化该类时需要传递一个数组$config如下:
	@$config['upfile']    用于封装上传文件信息的数组$_FILE['filename']
	@$config['filepath']  上传后保存的文件路径    
	@$config['maxsize']   文件上传限制大小 
	*/
	public function __construct($config){
		$this->upfile = $config['upfile'];
		$this->filepath = $config['filepath'];
		$this->maxsize = $config['maxsize'];
	}
	/*
	执行文件上传操作
	*/
	public function do_upload(){
		//检查文件上传错误信息
		if($this->upfile['error'] > 0){
	
			switch($this->upfile['error']){
				case 1:
					$this->mesg['info'] = "上传文件超出了配置文件规定值!";
					break;
				case 2:
					$this->mesg['info'] = "上传文件超出了表单选项规定值!";
					break;
				case 3:
					$this->mesg['info'] = "上传文件部分成功!";
					break;
				case 4:
					$this->mesg['info'] = "未选择上传文件!";
					break;
				case 6:
					$this->mesg['info'] = "找不到临时文件夹!";
					break;
				case 7:
					$this->mesg['info'] = "文件写入失败!";
					break;
			
			return $this->mesg;
			
			}
	
		}
		//检查文件上传大小是否超出限制
		if($this->upfile['size'] > $this->maxsize ){
			$this->mesg['info'] = '上传文件超出限制!';
			return $this->mesg;
		}
		//检查文件上传类型是否超出限制
		if(!in_array($this->upfile['type'],$this->typelist)){
			$this->mesg['info'] = '上传类型超出限制!';
			return $this->mesg;
		}
		//获取文件名信息的数组
		$fileinfo = pathinfo($this->upfile["name"]);
		//文件存在时重命名
		do{
			$newfile = date('YmdHis').rand(1000,9999).".".$fileinfo['extension'];
		}while(file_exists($this->filepath.$newfile));
		//判断是否为一个上传文件
		if(is_uploaded_file($this->upfile['tmp_name'])){
			//移动到新目录下并检测是否成功
			if(move_uploaded_file($this->upfile['tmp_name'],$this->filepath.$newfile)){
				$this->mesg['error'] = false;
				$this->mesg['info'] = $this->filepath.$newfile;
				return $this->mesg;
			}
		}else{
			$this->mesg['info'] = '不是一个上传文件!';
			return $this->mesg;
		}
		
	}
}
/**
 * 在控制器中使用该分页类的示例代码:
 * 配置文件上传类
 * $config['upfile'] = $_FILES['testfile'];
 * $config['filepath'] = "./public/images/";
 * $config['maxsize'] = 100000000;
 * 实例化文件上传类
 * $this->load->library('upload',$config);
 * 执行文件上传操作
 * $res = $this->upload->do_upload();
 * //返回上传操作信息
 * if($res['error']){
 *	    echo "文件上传失败:".$res['info'];
 * }else{
 *		echo "文件上传成功:".$res['info'];
 * }
 */

?>