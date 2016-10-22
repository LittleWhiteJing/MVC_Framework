<?php
/* 数据库连接类 */
class db {
    //连接标识
    var $mlink;
    //初始化工作
    function __construct($dbhost, $dbuser, $dbpw, $dbname = '',$dbcharset='utf8', $pconnect=0) {
        //连接数据库
        if($pconnect) {
            if(!$this->mlink = @mysql_pconnect($dbhost, $dbuser, $dbpw)) {
                $this->halt('Can not connect to MySQL');
            }
        } else {
            if(!$this->mlink = @mysql_connect($dbhost, $dbuser, $dbpw)) {
                $this->halt('Can not connect to MySQL');
            }
        }
        //设置字符编码
        if($this->version()>'4.1') {
            if('utf-8'==strtolower($dbcharset)) {
                $dbcharset='utf8';
            }
            if($dbcharset) {
                mysql_query("SET character_set_connection=$dbcharset, character_set_results=$dbcharset, character_set_client=binary", $this->mlink);
            }
            if($this->version() > '5.0.1') {
                mysql_query("SET sql_mode=''", $this->mlink);
            }
        }
        //选择数据库
        if($dbname) {
            mysql_select_db($dbname, $this->mlink);
        }
    }
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
	/* 切换数据库 */
    function select_db($dbname) {
        return mysql_select_db($dbname, $this->mlink);
    }

    /* 获取一行结果数组(关联数组或索引数组) */
    function fetch_array($query, $result_type = MYSQL_ASSOC) {
        return (is_resource($query))? mysql_fetch_array($query, $result_type) :false;
    }

    /* 获取第一条结果数据 */
    function result_first($sql) {
        $query = $this->query($sql);
        return $this->result($query, 0);
    }

    /* 获取第一条结果数组 */
    function fetch_first($sql) {
        $query = $this->query($sql);
        return $this->fetch_array($query);
    }

    /* 更新数据记录 */
    function update_field($table,$field,$value,$where) {
        return $this->query("UPDATE ".DB_TABLEPRE."$table SET $field='$value' WHERE $where");
    }

    /* 获取数据总数目 */
    function fetch_total($table,$where='1') {
        return $this->result_first("SELECT COUNT(*) num FROM ".DB_TABLEPRE."$table WHERE $where");
    }

    /* 执行一条sql语句，有两种执行模式 */
    function query($sql, $type = '') {
        global $debug ,$querynum;
        //获取查询函数
        $func = $type == 'UNBUFFERED' && @function_exists('mysql_unbuffered_query') ? 'mysql_unbuffered_query' : 'mysql_query';
        if(!($query = $func($sql, $this->mlink)) && $type != 'SILENT') {
            //返回错误信息
            $this->halt(mysql_error(),$debug);
        }
        $querynum++;
        //返回结果集
        return $query;
    }
	
    /* 获取受影响的行数 */
    function affected_rows() {
        return mysql_affected_rows($this->mlink);
    }

    /* 获取上个错误信息 */
    function error() {
        return (($this->mlink) ? mysql_error($this->mlink) : mysql_error());
    }

    /* 获取上个错误编码 */
    function errno() {
        return intval(($this->mlink) ? mysql_errno($this->mlink) : mysql_errno());
    }

    /* 获取第n条单条结果数据 */
    function result($query, $row) {
        $query = @mysql_result($query, $row);
        return $query;
    }

    /* 获取结果条数 */
    function num_rows($query) {
        $query = mysql_num_rows($query);
        return $query;
    }

    /* 获取字段条数 */
    function num_fields($query) {
        return mysql_num_fields($query);
    }

    /* 释放结果集 */
    function free_result($query) {
        return mysql_free_result($query);
    }

    /* 获取插入id */
    function insert_id() {
        return ($id = mysql_insert_id($this->mlink)) >= 0 ? $id : $this->result($this->query('SELECT last_insert_id()'), 0);
    }

    /* 获取结果数组 */
    function fetch_row($query) {
        $query = mysql_fetch_row($query);
        return $query;
    }

    /* 获取结果字段 */
    function fetch_fields($query) {
        return mysql_fetch_field($query);
    }
    /* 获取结果存入数组 */
    function fetch_all($sql, $id = '') {
        $arr = array();
        $query = $this->query($sql);
        while($data = $this->fetch_array($query)) {
            $id ? $arr[$data[$id]] = $data : $arr[] = $data;
        }
        return $arr;
    }

    /* 获取数据库版本信息 */
    function version() {
        return mysql_get_server_info($this->mlink);
    }
    /* 关闭数据库连接 */
    function close() {
        return mysql_close($this->mlink);
    }

    /* 输出数据库操作的错误信息 */
    function halt($msg, $debug=true) {
        if($debug) {
            echo "<html>\n";
            echo "<head>\n";
            echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">\n";
            echo "<title>$msg</title>\n";
            echo "<br><font size=\"6\" color=\"red\"><b>$msg</b></font>";
            exit();
        }
    }
}

?>