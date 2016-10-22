<?php
/* ������ */
class cache {
    //���ݿ⻺��
    var $db;
    //�ļ�����
    var $cachefile;
    //��ȡ���ݿ����
    function cache(& $db) {
        $this->db = $db;
    }
    //��ȡ�����ļ�
    function getfile($cachename) {
        $this->cachefile = APP_DIR . '/datas/cache/' . $cachename . '.php';
    }
    //���뻺�����ֺ�ʱ�䣬���ػ����Ƿ����
    function isvalid($cachename, $cachetime) {
        //����ʱ��Ϊ0��������Ч
        if (0 == $cachetime)
            return true;
        //��ȡ�����Ƿ����
        $this->getfile($cachename);
        //���治�ɶ��򻺴����
        if (!is_readable($this->cachefile) || $cachetime < 0) {
            return false;
        }
        //���������״̬���ļ���Ϣ���Ի�ȡ�ļ��е�������Ϣ
        clearstatcache();
        //���ػ����Ƿ����
        return (time() - filemtime($this->cachefile)) < $cachetime;
    }

    //��ȡ����
    function read($cachename, $cachetime=0) {
        //���û����·��
        $this->getfile($cachename);
        //�жϻ����Ƿ����
        if ($this->isvalid($cachename, $cachetime)) {
            return @include $this->cachefile;
        }
        return false;
    }

    //д�뻺��
    function write($cachename, $arraydata) {
        //���û���·��
        $this->getfile($cachename);
        //�жϻ��������Ƿ�Ϊ����
        if (!is_array($arraydata))
            return false;
        //ƴ��д���ļ����ַ���
        $strdata = "<?php\nreturn " . var_export($arraydata, true) . ";\n?>";
        //������д���ļ�
        $bytes = writetofile($this->cachefile, $strdata);
        //�����ļ���С
        return $bytes;
    }
    //�������
    function remove($cachename) {
        //���û���·��
        $this->getfile($cachename);
        //����������������
        if (file_exists($this->cachefile)) {
            unlink($this->cachefile);
        }
    }

    //���ػ���
    function load($cachename, $id='id', $orderby='') {
        //��ȡ��������
        $arraydata = $this->read($cachename);
        //�����ȡ���Ϊ��������ݿ��л�ȡ
        if (!$arraydata) {
            $sql = 'SELECT * FROM ' . DB_TABLEPRE . $cachename;
            $orderby && $sql.=" ORDER BY $orderby ASC";
            $query = $this->db->query($sql);
            //ƴ�ӻ�������
            while ($item = $this->db->fetch_array($query)) {
                if (isset($item['k'])) {
                    $arraydata[$item['k']] = $item['v'];
                } else {
                    $arraydata[$item[$id]] = $item;
                }
            }
            //������д��
            $this->write($cachename, $arraydata);
        }
        //���ز�ѯ���
        return $arraydata;
    }

}

?>