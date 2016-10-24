<?php
/*********************************
 * 日历类文件
 *********************************
 * 使用示例代码:
 *********************************
 */
class calendar{
	//定义年份
	public $year = '';
	//定义月份
	public $month = '';
	//定义当前月天数
	public $days = '';
	//定义第一天星期
	public $weekday = '';
	//定义上一月
	public $premon = '';
	//定义下一月
	public $nexmon = '';
	//定义上一年
	public $preyear = '';
	//定义下一年
	public $nexyear = '';
	//定义文件名
	public $filepath = '';
	
    /*
	__construct是calendar的构造函数，用来在创建类的时候自动运行.
  
	实例化该类时需要传递一个数组$config如下:
	@$config['filepath']  显示日历的控制器名
	@$config['year']      显示哪一年[可选参数,默认为当前年]
	@$config['month']     显示哪一月[可选参数,默认为当前月]
	
	*/
	public function __construct($config){
		$this->filepath = $config['filepath'];
		$this->year = isset($config['year']) ? $config['year'] : date('Y');
		$this->month = isset($config['month']) ? $config['month'] : date('m');	
	}
	
	/* 
	处理链接信息并调用模板 
	*/
	public function generate(){
		//获取参数
		if(isset($_GET['n']))
			$this->year = $_GET['n'];
		if(isset($_GET['y']))
			$this->month = $_GET['y'];
		//获取当前月天数
		$this->days = date("t",mktime(0,0,0,$this->month,1,$this->year));
		//获取第一天星期几
		$this->weekday = date("w",mktime(0,0,0,$this->month,1,$this->year));
		//跨年操作
		if($this->month == 1){
			$this->premon = 12;
			$this->preyear = $this->year - 1;
			$this->nexyear = $this->year;
			$this->nexmon = $this->month + 1;
		}else if($this->month == 12){
			$this->nexmon = 1;
			$this->nexyear = $this->year + 1;
			$this->premon = $this->month - 1;
			$this->preyear = $this->year - 1;
		}else{
			$this->preyear = $this->nexyear = $this->year;
			$this->premon = $this->month - 1;
			$this->nexmon = $this->month + 1;
		}
		//输出模板
		return $this->template();
	}
	
	/*
	拼接并输出模板
	*/
	public function template(){
		$tpl = "<center>";
		$tpl .= "<h4>{$this->year}年 {$this->month}月</h4>";
		$tpl .= "<table width = '600' border='1'>";
		$tpl .= "<tr>";
		$tpl .= "<th style='color:red'>星期日</th><th>星期一</th><th>星期二</th><th>星期三</th><th>星期四</th><th>星期五</th><th style='color:green'>星期六</th>";
		$tpl .= "</tr>";
		$dd = 1;
		//输出一个月信息
		while($dd <= $this->days){
			$tpl .= "<tr>";
			//输出一周信息
			for($i = 0;$i < 7;$i++){
				//判断输出时机
				if($dd <= $this->days && ($this->weekday <= $i || $dd != 1)){
					$tpl .= "<td>{$dd}</td>";
					$dd++;
				}else{
					$tpl .= "<td>&nbsp;</td>";
				}
			}
			$tpl .= "</tr>";
		}
		$tpl .= "</table>";
		//输出超链接
		$tpl .= "<h4><a href='{$this->filepath}&n={$this->preyear}&y={$this->premon}'>上一月</a>&nbsp;&nbsp;&nbsp;";
		$tpl .= "<a href='{$this->filepath}&n={$this->nexyear}&y={$this->nexmon}'>下一月</a></h4>";
		$tpl .= "</center>";
		return $tpl;
	}
}
/**
 * 在控制器中使用该日历类的示例代码:
 * $arr = getcurrcm();
 * 配置日历选项
 * $config['filepath'] = SITE_URL . IN_FILE . "?c=".$arr['controller']."&m=".$arr['method'];
 * $config['year'] = 2017;
 * $config['month'] = 1;
 * 实例化日历类
 * $this->load->library('calendar',$config);
 * 生成数据显示
 * $data['cal'] = $this->calendar->generate(); 
 * $this->load->view('show',$data);
 */


?>