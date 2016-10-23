<?php
//进行入口验证
!defined('TOKEN') && exit("Access denied!"); 
//引入数据库类
require ROOT_DIR . '/lib/db.class.php';
//引入缓存类
require ROOT_DIR . '/lib/cache.class.php';
//引入函数库
require ROOT_DIR . '/lib/functions.php';
//引入基础类
require ROOT_DIR . '/core/base.class.php';

class core{
	
	//默认控制器
	public $controller = 'welcome';
	//默认方法
	public $method = 'index';
	
	
	//构造方法自动处理
    function __construct() {
    	//初始化请求
        $this->init_request();
        //加载控制器
        $this->load_control();
    }

    //处理url请求，转义字符数组，进行XSS过滤，设置默认控制器
    function init_request() {
        
        //导入配置文件
        require APP_DIR . 'configures/config.php';
		//发送原生HTTP头
        header('Content-type: text/html; charset=' . WEB_CHARSET);
  
		/**
		 *此处可以设置对用户输入的字符进行过滤
         *
		 */

		
		//普通模式
		$querystring = isset($_SERVER['QUERY_STRING']) ? $_SERVER['QUERY_STRING'] : '';
		$posarr = explode('&', $querystring);
		if (!empty($posarr)) {
			$tmp1 = strrpos($posarr[0],'=');
			$tmp2 = strrpos($posarr[1],'=');	
			/**
			*此处可以设置一个url字符映射机制
			*
			*/
			//捕获控制器
			if($tmp1 !== false)
				$this->controller = substr($posarr[0],$tmp1+1);
	
			//捕获方法
			if($tmp2 !== false)
				$this->method = substr($posarr[1],$tmp2+1);
			
		}
		
    }

    //设置控制器路径
    function load_control() {
    	//定义默认的控制器文件路径
        $controlfile = APP_DIR . 'controllers/' . $this->controller . '.class.php';
        
		/**
		 *当有多种控制器时此处可以设置控制器路径的路由
         *
		 */
        
		//判断控制器是否存在，并引入控制器文件
        if (false === include($controlfile)) {
            echo "Controller not found!";
        }
    }
    //实例化控制器
    function run() {
        //控制器名称
        $controlname = $this->controller;
        //实例化控制器
        $control = new $controlname();
        //设置方法名
        $method = $this->method;
        //判断控制器方法是否存在
        if (method_exists($control, $method)) {
   
            /**
			 *此处可以对ajax请求作出处理
			 *
			 */
			 
            //控制器是否可访问
            if($control->whitelist){
            	$whitelist = explode(',', $control->whitelist);
            	$flag = in_array($method, $whitelist);
            }
            //控制器和方法有访问权限
            if ((isset($flag) && $flag) || empty($control->whitelist)) {
                //调用该控制器的方法
                $control->$method();
            } else {	
                $control->message('您无权限访问当前页面', 'user/login');
            }
        } else {
            //方法未被找到
            echo "Method not found!";
        }
    }

}
?>