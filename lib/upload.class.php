<?php
/*******************************
 *  �ļ��ϴ���
 *******************************
 *  upload.class.php
 *******************************
 */
class upload {
	//�ϴ��ļ���Ϣ
	public $upfile;
	//�ļ����·��
	public $filepath;
	//�ļ��������
	public $maxsize;
	//��װ�ϴ���Ϣ
	public $mesg = array('error'=>true,'info'=>'');
	//�����ϴ�����
	public $typelist = array('image/jpeg','image/png','image/jpg','image/gif','text/plain');
	
	/*
	__construct��page�Ĺ��캯���������ڴ������ʱ���Զ�����.
	
	ʵ��������ʱ��Ҫ����һ������$config����:
	@$config['upfile']    ���ڷ�װ�ϴ��ļ���Ϣ������$_FILE['filename']
	@$config['filepath']  �ϴ��󱣴���ļ�·��    
	@$config['maxsize']   �ļ��ϴ����ƴ�С 
	*/
	public function __construct($config){
		$this->upfile = $config['upfile'];
		$this->filepath = $config['filepath'];
		$this->maxsize = $config['maxsize'];
	}
	/*
	ִ���ļ��ϴ�����
	*/
	public function do_upload(){
		//����ļ��ϴ�������Ϣ
		if($this->upfile['error'] > 0){
	
			switch($this->upfile['error']){
				case 1:
					$this->mesg['info'] = "�ϴ��ļ������������ļ��涨ֵ!";
					break;
				case 2:
					$this->mesg['info'] = "�ϴ��ļ������˱�ѡ��涨ֵ!";
					break;
				case 3:
					$this->mesg['info'] = "�ϴ��ļ����ֳɹ�!";
					break;
				case 4:
					$this->mesg['info'] = "δѡ���ϴ��ļ�!";
					break;
				case 6:
					$this->mesg['info'] = "�Ҳ�����ʱ�ļ���!";
					break;
				case 7:
					$this->mesg['info'] = "�ļ�д��ʧ��!";
					break;
			
			return $this->mesg;
			
			}
	
		}
		//����ļ��ϴ���С�Ƿ񳬳�����
		if($this->upfile['size'] > $this->maxsize ){
			$this->mesg['info'] = '�ϴ��ļ���������!';
			return $this->mesg;
		}
		//����ļ��ϴ������Ƿ񳬳�����
		if(!in_array($this->upfile['type'],$this->typelist)){
			$this->mesg['info'] = '�ϴ����ͳ�������!';
			return $this->mesg;
		}
		//��ȡ�ļ�����Ϣ������
		$fileinfo = pathinfo($this->upfile["name"]);
		//�ļ�����ʱ������
		do{
			$newfile = date('YmdHis').rand(1000,9999).".".$fileinfo['extension'];
		}while(file_exists($this->filepath.$newfile));
		//�ж��Ƿ�Ϊһ���ϴ��ļ�
		if(is_uploaded_file($this->upfile['tmp_name'])){
			//�ƶ�����Ŀ¼�²�����Ƿ�ɹ�
			if(move_uploaded_file($this->upfile['tmp_name'],$this->filepath.$newfile)){
				$this->mesg['error'] = false;
				$this->mesg['info'] = $this->filepath.$newfile;
				return $this->mesg;
			}
		}else{
			$this->mesg['info'] = '����һ���ϴ��ļ�!';
			return $this->mesg;
		}
		
	}
}
/**
 * �ڿ�������ʹ�ø÷�ҳ���ʾ������:
 * �����ļ��ϴ���
 * $config['upfile'] = $_FILES['testfile'];
 * $config['filepath'] = "./public/images/";
 * $config['maxsize'] = 100000000;
 * ʵ�����ļ��ϴ���
 * $this->load->library('upload',$config);
 * ִ���ļ��ϴ�����
 * $res = $this->upload->do_upload();
 * //�����ϴ�������Ϣ
 * if($res['error']){
 *	    echo "�ļ��ϴ�ʧ��:".$res['info'];
 * }else{
 *		echo "�ļ��ϴ��ɹ�:".$res['info'];
 * }
 */

?>