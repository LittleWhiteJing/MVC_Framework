<?php
/* ���ݿ������� */
class db {
    //���ӱ�ʶ
    var $mlink;
    //��ʼ������
    function __construct($dbhost, $dbuser, $dbpw, $dbname = '',$dbcharset='utf8', $pconnect=0) {
        //�������ݿ�
        if($pconnect) {
            if(!$this->mlink = @mysql_pconnect($dbhost, $dbuser, $dbpw)) {
                $this->halt('Can not connect to MySQL');
            }
        } else {
            if(!$this->mlink = @mysql_connect($dbhost, $dbuser, $dbpw)) {
                $this->halt('Can not connect to MySQL');
            }
        }
        //�����ַ�����
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
        //ѡ�����ݿ�
        if($dbname) {
            mysql_select_db($dbname, $this->mlink);
        }
    }
	
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    
	/* �л����ݿ� */
    function select_db($dbname) {
        return mysql_select_db($dbname, $this->mlink);
    }

    /* ��ȡһ�н������(�����������������) */
    function fetch_array($query, $result_type = MYSQL_ASSOC) {
        return (is_resource($query))? mysql_fetch_array($query, $result_type) :false;
    }

    /* ��ȡ��һ��������� */
    function result_first($sql) {
        $query = $this->query($sql);
        return $this->result($query, 0);
    }

    /* ��ȡ��һ��������� */
    function fetch_first($sql) {
        $query = $this->query($sql);
        return $this->fetch_array($query);
    }

    /* �������ݼ�¼ */
    function update_field($table,$field,$value,$where) {
        return $this->query("UPDATE ".DB_TABLEPRE."$table SET $field='$value' WHERE $where");
    }

    /* ��ȡ��������Ŀ */
    function fetch_total($table,$where='1') {
        return $this->result_first("SELECT COUNT(*) num FROM ".DB_TABLEPRE."$table WHERE $where");
    }

    /* ִ��һ��sql��䣬������ִ��ģʽ */
    function query($sql, $type = '') {
        global $debug ,$querynum;
        //��ȡ��ѯ����
        $func = $type == 'UNBUFFERED' && @function_exists('mysql_unbuffered_query') ? 'mysql_unbuffered_query' : 'mysql_query';
        if(!($query = $func($sql, $this->mlink)) && $type != 'SILENT') {
            //���ش�����Ϣ
            $this->halt(mysql_error(),$debug);
        }
        $querynum++;
        //���ؽ����
        return $query;
    }
	
    /* ��ȡ��Ӱ������� */
    function affected_rows() {
        return mysql_affected_rows($this->mlink);
    }

    /* ��ȡ�ϸ�������Ϣ */
    function error() {
        return (($this->mlink) ? mysql_error($this->mlink) : mysql_error());
    }

    /* ��ȡ�ϸ�������� */
    function errno() {
        return intval(($this->mlink) ? mysql_errno($this->mlink) : mysql_errno());
    }

    /* ��ȡ��n������������� */
    function result($query, $row) {
        $query = @mysql_result($query, $row);
        return $query;
    }

    /* ��ȡ������� */
    function num_rows($query) {
        $query = mysql_num_rows($query);
        return $query;
    }

    /* ��ȡ�ֶ����� */
    function num_fields($query) {
        return mysql_num_fields($query);
    }

    /* �ͷŽ���� */
    function free_result($query) {
        return mysql_free_result($query);
    }

    /* ��ȡ����id */
    function insert_id() {
        return ($id = mysql_insert_id($this->mlink)) >= 0 ? $id : $this->result($this->query('SELECT last_insert_id()'), 0);
    }

    /* ��ȡ������� */
    function fetch_row($query) {
        $query = mysql_fetch_row($query);
        return $query;
    }

    /* ��ȡ����ֶ� */
    function fetch_fields($query) {
        return mysql_fetch_field($query);
    }
    /* ��ȡ����������� */
    function fetch_all($sql, $id = '') {
        $arr = array();
        $query = $this->query($sql);
        while($data = $this->fetch_array($query)) {
            $id ? $arr[$data[$id]] = $data : $arr[] = $data;
        }
        return $arr;
    }

    /* ��ȡ���ݿ�汾��Ϣ */
    function version() {
        return mysql_get_server_info($this->mlink);
    }
    /* �ر����ݿ����� */
    function close() {
        return mysql_close($this->mlink);
    }

    /* ������ݿ�����Ĵ�����Ϣ */
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