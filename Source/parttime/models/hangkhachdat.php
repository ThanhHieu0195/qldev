<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of approvecongviec
 *
 // 
 * @author HieuThanh
 */
include_once 'database.php';
include_once 'helper.php';
include_once '../config/constants.php';

class hangkhachdat extends database {
    public $_NAMETABLE    = 'hangkhachdat';

    public $_MADONHANG    = 'madonhang';
    public $_MASOTRANH    = "masotranh";
    public $_MACHITIET    = "machitiet";
    public $_SOLUONG      = "soluong";
    public $_TRANGTHAI    = "trangthai";
    public $_TOTAL_COLUMN = "5";
    public $_TRANGTHAI_REJECT = '3';
    public $_TRANGTHAI_CHOGIAO = '0';
    public $_TRANGTHAI_RECEIVED = '1';

    public function update($params, $conditions) {
        $where = "";
        if ( count($conditions) > 0 ) {
            $where =  "where ".mergeTostr($conditions, "and", "=");
        }

        $set = "";
        if ( count($params) > 0 ) {
            $set = "set ".mergeTostr($params, ", ", " = ");
        }

        $sql = "UPDATE $this->_NAMETABLE $set $where;";
        $this->setQuery($sql);
        $result = $this->query();
        return $result;
    }


    public function received ($madonhang, $masotranh, $machitiet) {
        $params = array('trangthai' => $this->_TRANGTHAI_RECEIVED);
        $condition = array('madonhang' => $madonhang, 'masotranh' => $masotranh, 'machitiet' => $machitiet);
        return $this->update($params, $condition);
    }
    public function reject ($madonhang, $masotranh, $machitiet) {
        $params = array('trangthai' => $this->_TRANGTHAI_REJECT);
        $condition = array('madonhang' => $madonhang, 'masotranh' => $masotranh, 'machitiet' => $machitiet);
        return $this->update($params, $condition);
    }

    public function soluongchogiao($madonhang, $masotranh) {
        $sql = "select count(*) from hangkhachdat where madonhang = '$madonhang' and masotranh = '$masotranh' and trangthai = '$this->_TRANGTHAI_CHOGIAO';";
        $sql = "select case when count(*)=SUM(case when trangthai = '$this->_TRANGTHAI_CHOGIAO' then 1 else 0 end) then 1 else 0 end  from hangkhachdat where madonhang='$madonhang' and masotranh='$masotranh'";
        $this->setQuery($sql);
        $result = $this->query();
        $row = mysql_fetch_row($result);
        return $row[0];
    }

    public function kiemtragiaodu($madonhang, $masotranh) {
        $sql = "select count(*) from hangkhachdat where madonhang = '$madonhang' and masotranh = '$masotranh' and trangthai = '$this->_TRANGTHAI_RECEIVED';";
        $sql = "select (case when count(*)=SUM(case when trangthai = '$this->_TRANGTHAI_RECEIVED' then 1 else 0 end) then 1 else 0 end) as giaodu  from hangkhachdat where madonhang='$madonhang' and masotranh='$masotranh' limit 0";
        $sql = "select case when count(*)=SUM(case when trangthai = $this->_TRANGTHAI_RECEIVED then 1 else 0 end) then 1 else 0 end as giaodu from hangkhachdat where madonhang='$madonhang' and masotranh='$masotranh'";
        //        error_log ("HHHHHHHH " . $sql, 3, '/var/log/phpdebug.log');
        $this->setQuery($sql);
        $result = $this->query();
        $row = mysql_fetch_array ( $result );
        $this->disconnect ();
        if (is_array ( $row )) {
            return $row ['giaodu'];
        }
        return 0;
    }

    public function capnhattrangthaichitietdonhang($madonhang, $masotranh) {
        //error_log ("HHHHHHHH " . $this->kiemtragiaodu($madonhang,$masotranh), 3, '/var/log/phpdebug.log');
        if ($this->kiemtragiaodu($madonhang,$masotranh)==1) {
            require_once "chitietdonhang.php";
            $chitietdonhang = new chitietdonhang();
            $r1=$chitietdonhang->capnhattrangthaisanphamlaprap($madonhang, $masotranh, 1);
        }

        //if ($this->soluongchogiao($madonhang,$masotranh) == 0 && $this->kiemtragiaodu($madonhang,$masotranh) == 0) {
        //    require_once "../chitietdonhang.php";
        //    $chitietdonhang = new chitietdonhang();
        //    $r2=$chitietdonhang->capnhattrangthaisanphamlaprap($madonhang, $masotranh, -1);
        //}
        return r1;
    } 

    public function is_exist( $params ) {
        $where = "";
        if ( count($params) > 0 ) {
            $where = "where ".mergeTostr( $params, "and", "=" );
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
        error_log ("Add new " . $sql .  "\n", 3, '/var/log/phpdebug.log');
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ( $row = mysql_fetch_row($result) ) {
            $arr [] = $row;
        }
      
        return $arr;
    }

    public function insert( $params )
    {
        $val = implode( "','", $params );

        $sql = "insert into $this->_NAMETABLE($this->_MADONHANG,$this->_MASOTRANH, $this->_MACHITIET, $this->_SOLUONG, $this->_TRANGTHAI) values('$val');";
        error_log ("Add new " . $sql .  "\n", 3, '/var/log/phpdebug.log');
        $this->setQuery( $sql );
        $result = $this->query();
        if ( $result ) {
            return true;
        }  
        return false;
    }

    public function delete($conditions)
    {
        $where = "";
        if ( count($conditions) > 0 ) {
            $where = "where ".mergeTostr($conditions, "and ", "=");
        } 
        $sql = "Delete from $this->_NAMETABLE $where;";
        $this->setQuery($sql);
        $result = $this->query();
        if ($result) {
            return true;
        } 
        return false;
    }
}
?>
