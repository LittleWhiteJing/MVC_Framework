<?php
//���������֤
!defined('TOKEN') && exit("Access denied!"); 
//�������ݿ���
require ROOT_DIR . '/lib/db.class.php';
//���뻺����
require ROOT_DIR . '/lib/cache.class.php';
//���뺯����
require ROOT_DIR . '/lib/functions.php';
//���������
require ROOT_DIR . '/core/base.class.php';

class core{
	
	//Ĭ�Ͽ�����
	public $controller = 'welcome';
	//Ĭ�Ϸ���
	public $method = 'index';
	
	
	//���췽���Զ�����
    function __construct() {
    	//��ʼ������
        $this->init_request();
        //���ؿ�����
        $this->load_control();
    }

    //����url����ת���ַ����飬����XSS���ˣ�����Ĭ�Ͽ�����
    function init_request() {
        
        //���������ļ�
        require APP_DIR . 'configures/config.php';
		//����ԭ��HTTPͷ
        header('Content-type: text/html; charset=' . WEB_CHARSET);
  
		/**
		 *�˴��������ö��û�������ַ����й���
         *
		 */

		
		//��ͨģʽ
		$querystring = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
		$posarr = explode('&', $querystring);
		if (!empty($posarr)) {
			$tmp1 = strrpos($posarr[0],'=');
			$tmp2 = strrpos($posarr[1],'=');	
			/**
			*�˴���������һ��url�ַ�ӳ�����
			*
			*/
			//���������
			if($tmp1 !== false)
				$this->controller = substr($posarr[0],$tmp1+1);
	
			//���񷽷�
			if($tmp2 !== false)
				$this->method = substr($posarr[1],$tmp2+1);
			
		}
		
    }

    //���ÿ�����·��
    function load_control() {
    	//����Ĭ�ϵĿ������ļ�·��
        $controlfile = APP_DIR . 'controllers/' . $this->controller . '.class.php';
        
		/**
		 *���ж��ֿ�����ʱ�˴��������ÿ�����·����·��
         *
		 */
        
		//�жϿ������Ƿ���ڣ�������������ļ�
        if (false === include($controlfile)) {
            echo "Controller not found!";
        }
    }
    //ʵ����������
    function run() {
        //����������
        $controlname = $this->controller;
        //ʵ����������
        $control = new $controlname();
        //���÷�����
        $method = $this->method;
        //�жϿ����������Ƿ����
        if (method_exists($control, $method)) {
   
            /**
			 *�˴����Զ�ajax������������
			 *
			 */
			 
            //�������Ƿ�ɷ���
            if($control->whitelist){
            	$whitelist = explode(',', $control->whitelist);
            	$flag = in_array($method, $whitelist);
            }
            //�������ͷ����з���Ȩ��
            if ((isset($flag) && $flag) || empty($control->whitelist)) {
                //���øÿ������ķ���
                $control->$method();
            } else {	
                $control->message('����Ȩ�޷��ʵ�ǰҳ��', 'user/login');
            }
        } else {
            //����δ���ҵ�
            echo "Method not found!";
        }
    }

}
?>