<?php
/*+++++++++++++++++++++++++++++++++++++++
 *|  分页类文件
 *+++++++++++++++++++++++++++++++++++++++
 *|  Page.class.php
 *+++++++++++++++++++++++++++++++++++++++
 */
class page{ 

	//每页显示的条目数 
	public $each_disNums;
	//总条目数
	public $nums; 
	//当前被选中的页
	public $current_page; 
	//每次显示的页数 
	public $sub_pages;
	//总页数 
	public $pageNums;
	//用来构造分页的数组 
	public $page_array = array();
	//每个分页的链接 
	public $subPage_link;
	//显示分页的类型
	public $subPage_type;
	//分页连接显示
	public $showlink;
	/* 
	__construct是SubPages的构造函数，用来在创建类的时候自动运行.

	实例化该类时需要传递一个数组$config如下： 
	@$config['each_disNums']  每页显示的条目数 
	@$config['nums']          总条目数 
	@$config['current_page']  当前被选中的页 
	@$config['sub_pages']     每次显示的页数 
	@$config['subPage_link']  每个分页的链接 
	@$config['subPage_type']  显示分页的类型 
 
	当@subPage_type=1的时候为普通分页模式 
	example： 共4523条记录,每页显示10条,当前第1/453页 [首页] [上页] [下页] [尾页] 
	当@subPage_type=2的时候为经典分页样式 
	example： 当前第1/453页 [首页] [上页] 1 2 3 4 5 6 7 8 9 10 [下页] [尾页] 
	*/
	function __construct($config){ 
		$this->each_disNums=intval($config['each_disNums']); 
		$this->nums=intval($config['nums']); 
		if(!$config['current_page']) 
			$this->current_page=1; 
		else
			$this->current_page=intval($config['current_page']);  
		$this->sub_pages=intval($config['sub_pages']); 
		$this->pageNums=ceil($config['nums']/$config['each_disNums']); 
		$this->subPage_link=$config['subPage_link']; 
		$this->show_SubPages($config['subPage_type']); 
	} 
 
	/* 
	show_SubPages函数用在构造函数里面。而且用来判断显示什么样子的分页 
	*/
	function show_SubPages($subPage_type){ 
		if($subPage_type == 1) 
			$this->showlink = $this->subPageCss1(); 
		else 
			$this->showlink = $this->subPageCss2();  
	} 
 
	/* 
	用来给建立分页的数组初始化的函数。 
	*/
	function initArray(){ 
		for($i=0;$i<$this->sub_pages;$i++) 
			$this->page_array[$i]=$i; 
		return $this->page_array; 
	} 
	
	/* 
	construct_num_Page该函数使用来构造显示的条目 
	即使：[1][2][3][4][5][6][7][8][9][10] 
	*/
	function construct_num_Page(){ 
		if($this->pageNums < $this->sub_pages){ 
			$current_array=array(); 
			for($i=0;$i<$this->pageNums;$i++){ 
				$current_array[$i]=$i+1; 
			} 
		}else{ 
			$current_array=$this->initArray(); 
			if($this->current_page <= 3){ 
				for($i=0;$i<count($current_array);$i++){ 
					$current_array[$i]=$i+1; 
				} 
			}elseif ($this->current_page <= $this->pageNums && $this->current_page > $this->pageNums - $this->sub_pages + 1 ){ 
				for($i=0;$i<count($current_array);$i++){ 
					$current_array[$i]=($this->pageNums)-($this->sub_pages)+1+$i; 
				} 
			}else{ 
				for($i=0;$i<count($current_array);$i++){ 
					$current_array[$i]=$this->current_page-2+$i; 
				} 
			} 
		} 
		return $current_array; 
	} 
 
	/* 
	构造普通模式的分页 
	共4523条记录,每页显示10条,当前第1/453页 [首页] [上页] [下页] [尾页] 
	*/
	function subPageCss1(){ 
		
		$subPageCss1Str=""; 
		$subPageCss1Str.="共".$this->nums."条记录，"; 
		$subPageCss1Str.="每页显示".$this->each_disNums."条，"; 
		$subPageCss1Str.="当前第".$this->current_page."/".$this->pageNums."页 ";
		//处理首页显示		
		if($this->current_page > 1){ 
			$firstPageUrl=$this->subPage_link."1"; 
			$prewPageUrl=$this->subPage_link.($this->current_page-1); 
			$subPageCss1Str.="[<a href='$firstPageUrl'>首页</a>] "; 
			$subPageCss1Str.="[<a href='$prewPageUrl'>上一页</a>] "; 
		}else{ 
			$subPageCss1Str.="[首页] "; 
			$subPageCss1Str.="[上一页] "; 
		} 
		//处理尾页显示
		if($this->current_page < $this->pageNums){ 
			$lastPageUrl=$this->subPage_link.$this->pageNums; 
			$nextPageUrl=$this->subPage_link.($this->current_page+1); 
			$subPageCss1Str.=" [<a href='$nextPageUrl'>下一页</a>] "; 
			$subPageCss1Str.="[<a href='$lastPageUrl'>尾页</a>] "; 
		}else { 
			$subPageCss1Str.="[下一页] "; 
			$subPageCss1Str.="[尾页] "; 
		} 
 
		return $subPageCss1Str; 
	} 
 
	/* 
	构造经典模式的分页 
	当前第1/453页 [首页] [上页] 1 2 3 4 5 6 7 8 9 10 [下页] [尾页] 
	*/
 
	function subPageCss2(){ 
		
		$subPageCss2Str=""; 
		$subPageCss2Str.="当前第".$this->current_page."/".$this->pageNums."页 "; 
		//处理首页显示
		if($this->current_page > 1){ 
			$firstPageUrl=$this->subPage_link."1"; 
			$prewPageUrl=$this->subPage_link.($this->current_page-1); 
			$subPageCss2Str.="[<a href='$firstPageUrl'>首页</a>] "; 
			$subPageCss2Str.="[<a href='$prewPageUrl'>上一页</a>] "; 
		}else { 
			$subPageCss2Str.="[首页] "; 
			$subPageCss2Str.="[上一页] "; 
		} 
		//处理显示页列表
		$a=$this->construct_num_Page(); 
		for($i=0;$i<count($a);$i++){ 
			$s=$a[$i];
			//当前页特殊标记
			if($s == $this->current_page ){ 
				$subPageCss2Str.="[<span style='color:red;font-weight:bold;'>".$s."</span>]"; 
			}else{ 
				$url=$this->subPage_link.$s; 
				$subPageCss2Str.="[<a href='$url'>".$s."</a>]"; 
			} 
		} 
		//处理尾页显示
		if($this->current_page < $this->pageNums){ 
			$lastPageUrl=$this->subPage_link.$this->pageNums; 
			$nextPageUrl=$this->subPage_link.($this->current_page+1); 
			$subPageCss2Str.=" [<a href='$nextPageUrl'>下一页</a>] "; 
			$subPageCss2Str.="[<a href='$lastPageUrl'>尾页</a>] "; 
		}else { 
			$subPageCss2Str.="[下一页] "; 
			$subPageCss2Str.="[尾页] "; 
		}
		return $subPageCss2Str; 
	}
	public function show(){
		return $this->showlink;
	}
}
/**
 * 在控制器中使用该分页类的示例代码:
 * $arr = getcurrcm();
 * 配置分页选项 
 * $config['each_disNums'] = 3; 
 * $config['nums'] = $this->muser->fetchnumrows(); 
 * $config['current_page'] = isset($_GET['p']) ? $_GET['p'] : 1;
 * $config['sub_pages'] = 5; 
 * $config['subPage_link'] = SITE_URL . IN_FILE ."?c=".$arr['controller']."&m=".$arr['method']."&p="; 
 * $config['subPage_type'] = 1; 
 * 实例化分页类  		
 * $this->load->library('page',$config);
 * $data['link'] = $this->page->show();
 * 获取数据查询		
 * $offset = ($this->page->current_page - 1)*$this->page->each_disNums;
 * $nums = $this->page->pageNums;
 * 查询数据显示		
 * $info = $this->muser->getsomeinfo($offset,$nums);
 * $data['userinfo'] = $info;
 * $this->load->view('user',$data);	
 *
 */


?>