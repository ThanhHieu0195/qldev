<?php
/**
 * Created by Hieu.
 * User: Administrator
 * Date: 27/12/2016
 * Time: 8:46 CH
 */
include_once 'database.php';
include_once 'helper.php';
include_once '../config/constants.php';

class chitietphanbu extends database {
    public $_NAMETABLE = 'chitietphanbu';
    public $_COLUMN_NAME = array('madonhang', 'masotranh', 'machitiet', 'dai', 'rong', 'cao', 'danchi', 'khoan', 'mavan', 'soluong', 'trangthai');
    public static $SOANHANG     = 0;
    public static $DADUYET      = 1;
    public static $DANGSANXUAT  = 2;
    public static $HOANTAT      = 3;
    public static $DAGIAO       = 4;
    public static $HUY          =-1;

    public function update($param, $condition) {
        $where = "";
        if ( count($condition) > 0 ) {
            $where =  "where ".mergeTostr($condition, "and", "=");
        }

        $set = "";
        if ( count($param) > 0 ) {
            $set = "set ".mergeTostr($param, ", ", " = ");
        }
        $sql = "UPDATE $this->_NAMETABLE $set $where;";
        $this->setQuery($sql);
//        debug($sql);
        $result = $this->query();
        return $result;
    }

    public function is_exist( $condition ) {
        $where = "";
        if ( count($condition) > 0 ) {
            $where = "where ".mergeTostr( $condition, "and", "=" );
        }
        $sql = "select count(*) as num from $this->_NAMETABLE $where;";
        $this->setQuery($sql);
        $result = $this->query();
        $row = mysql_fetch_row($result);
        if ( $row[0] > 0 ) {
            return true;
        }
        return false;
    }

    public function getAll( $params=array(), $otable="", $conditions=array() ) {
        $select = "select *";
        if ( count($params) > 0 ) {
            $select = "select ".implode(", ", $params);
        }
        $from = "from $this->_NAMETABLE";
        $where = "";
        if ( count($conditions) > 0 ) {
            $where = "where ".mergeTostr($conditions, "and ", "=");
        }

        $sql = "$select $from $otable $where;";
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ( $row = mysql_fetch_row($result) ) {
            $arr [] = $row;
        }

        return $arr;
    }

    public function getRow($param=array(), $condition=array() ) {
        $select = "select *";
        if ( count($param) > 0 ) {
            $select = "select ".implode(", ", $param);
        }

        $from = "from $this->_NAMETABLE";
        $where = "";
        if ( count($condition) > 0 ) {
            $where = "where ".mergeTostr($condition, "and ", "=");
        }
        $sql = "$select $from $where;";
        $this->setQuery($sql);
        $result = $this->query();
        $row = mysql_fetch_row($result);
        return $row;
    }

    public function insert( $param )
    {
        $val = implode( "','", $param );
        $col = implode( ",",$this->_COLUMN_NAME );
        $table = $this->_NAMETABLE;

        $sql = "insert into $table($col) values('$val');";
        $this->setQuery( $sql );
        $result = $this->query();
        if ( $result ) {
            return true;
        }
        return false;
    }

    public function delete($condition)
    {
        $where = "";
        if ( count($condition) > 0 ) {
            $where = "where ".mergeTostr($condition, "and ", "=");
        }
        $sql = "Delete from $this->_NAMETABLE $where;";
        $this->setQuery($sql);
        $result = $this->query();
        if ($result) {
            return true;
        }
        return false;
    }
    function  setDoing($madonhang, $masotranh, $machitiet){
        $param = array('trangthai' => chitietphanbu::$DANGSANXUAT);
        $condition = array('madonhang' => $madonhang, 'masotranh' => $masotranh, 'machitiet' => $machitiet);
        return $this->update($param, $condition);
    }
//    ajax
    function delete_Ajax() {
        $condition  = array();
        if ( isset($GLOBALS['condition']) ) {
            $condition = $GLOBALS['condition'];
        }
        return $this->delete($condition);
    }

    function  checkAllStatus($madonhang, $trangthai) {
        $sql1 = 'select count(*) count from chitietphanbu where madonhang = "%1$s";';
        $sql2 = 'select count(*) count from chitietphanbu where madonhang = "%1$s" and trangthai=%2$s;';

        $sql1 = sprintf($sql1, $madonhang);
        $sql2 = sprintf($sql2, $madonhang, $trangthai);
        $this->setQuery($sql1);
        $res1 = $this->query();
        $count1 = mysql_fetch_assoc($res1);
//
        $this->setQuery($sql2);
        $res2 = $this->query();
        $count2 = mysql_fetch_assoc($res2);
        if ($count1['count'] == $count2['count']) {
            return true;
        } else {
            return false;
        }
    }

//    ajax
    function insert_Ajax()
    {
        $param  = array();
        if ( isset($GLOBALS['param']) ) {
            $param = $GLOBALS['param'];
        }
        return $this->insert($param);
    }

    function update_Ajax() {
        $param  = $condition = array();
        if ( isset($GLOBALS['param']) ) {
            $param = $GLOBALS['param'];
        }
        if ( isset($GLOBALS['condition']) ) {
            $condition = $GLOBALS['condition'];
        }
        return $this->update($param, $condition);
    }

    function deliver_Ajax() {
        $condition =  array();
        if ( isset($GLOBALS['condition']) ) {
            $condition = $GLOBALS['condition'];
        }
        $param = array('trangthai' => chitietphanbu::$DAGIAO);
        $res = $this->update($param, $condition);
        return $res;
    }
    function complete_Ajax() {
        $condition =  array();
        if ( isset($GLOBALS['condition']) ) {
            $condition = $GLOBALS['condition'];
        }
        $param = array('trangthai' => chitietphanbu::$HOANTAT);
        $res = $this->update($param, $condition);
        return $res;
    }
    function is_return_Ajax() {
        $madonhang = '';
        if ( isset($GLOBALS['madonhang']) ) {
            $madonhang = $GLOBALS['madonhang'];
        }
        $res = $this->is_exist( array('madonhang' => $madonhang) );
        if ( !$res ) return true;
        $res = $this->checkAllStatus($madonhang, chitietphanbu::$DADUYET) || $this->checkAllStatus($madonhang, chitietphanbu::$SOANHANG);
        return $res;
    }
    function return_Ajax() {
        $madonhang = '';
        if ( isset($GLOBALS['madonhang']) ) {
            $madonhang = $GLOBALS['madonhang'];
        }
        $arr_masotranh = '';
        if ( isset($GLOBALS['masotranh']) ) {
            $arr_masotranh = $GLOBALS['masotranh'];
        }
        $res = true;
        for ( $i=0; $i < count($arr_masotranh); $i++) {
            if ( $this->is_exist(array('madonhang' => $madonhang, 'masotranh' => $arr_masotranh[$i])) ) {
                $res = $res && $this->update( array('trangthai'=>chitietphanbu::$HUY), array('madonhang' => $madonhang, 'masotranh' => $arr_masotranh[$i]) );
            }
        }
        return $res;
    }
}

//$model = new chitietphanbu();
//ht_print( $model->checkAllStatus('th110011', 4) );

