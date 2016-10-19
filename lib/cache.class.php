<?php
/* 缓存类 */
class cache {
    //数据库缓存
    var $db;
    //文件缓存
    var $cachefile;
    //获取数据库对象
    function cache(& $db) {
        $this->db = $db;
    }
    //获取缓存文件
    function getfile($cachename) {
        $this->cachefile = ROOT_DIR . '/data/cache/' . $cachename . '.php';
    }
    //传入缓存名字和时间，返回缓存是否可用
    function isvalid($cachename, $cachetime) {
        //缓存时间为0，永久生效
        if (0 == $cachetime)
            return true;
        //获取缓存是否可用
        $this->getfile($cachename);
        //缓存不可读或缓存过期
        if (!is_readable($this->cachefile) || $cachetime < 0) {
            return false;
        }
        //清除被缓存状态的文件信息，以获取文件中的最新信息
        clearstatcache();
        //返回缓存是否可用
        return (time() - filemtime($this->cachefile)) < $cachetime;
    }

    //读取缓存
    function read($cachename, $cachetime=0) {
        //设置缓存的路径
        $this->getfile($cachename);
        //判断缓存是否可用
        if ($this->isvalid($cachename, $cachetime)) {
            return @include $this->cachefile;
        }
        return false;
    }

    //写入缓存
    function write($cachename, $arraydata) {
        //设置缓存路径
        $this->getfile($cachename);
        //判断缓存数据是否为数组
        if (!is_array($arraydata))
            return false;
        //拼接写入文件的字符串
        $strdata = "<?php\nreturn " . var_export($arraydata, true) . ";\n?>";
        //将数据写入文件
        $bytes = writetofile($this->cachefile, $strdata);
        //返回文件大小
        return $bytes;
    }
    //清除缓存
    function remove($cachename) {
        //设置缓存路径
        $this->getfile($cachename);
        //缓存存在则清除缓存
        if (file_exists($this->cachefile)) {
            unlink($this->cachefile);
        }
    }

    //加载缓存
    function load($cachename, $id='id', $orderby='') {
        //读取缓存数据
        $arraydata = $this->read($cachename);
        //如果读取结果为空则从数据库中获取
        if (!$arraydata) {
            $sql = 'SELECT * FROM ' . DB_TABLEPRE . $cachename;
            $orderby && $sql.=" ORDER BY $orderby ASC";
            $query = $this->db->query($sql);
            //拼接缓存数据
            while ($item = $this->db->fetch_array($query)) {
                if (isset($item['k'])) {
                    $arraydata[$item['k']] = $item['v'];
                } else {
                    $arraydata[$item[$id]] = $item;
                }
            }
            //将缓存写入
            $this->write($cachename, $arraydata);
        }
        //返回查询结果
        return $arraydata;
    }

}

?>