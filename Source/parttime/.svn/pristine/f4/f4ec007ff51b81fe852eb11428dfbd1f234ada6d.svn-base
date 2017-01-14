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

class tonkhosanxuat extends database {
    public $_NAMETABLE = 'tonkhosanxuat';

    public $_MAKHO = 'makho';
    public $_MACHITIET = "machitiet";
    public $_SOLUONG = "soluong";
    public $_TOTAL_COLUMN = "3";

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

    public function updateAdd($soluong, $machitiet, $makho) {
        $sql = "UPDATE $this->_NAMETABLE SET soluong=soluong+'$soluong' WHERE machitiet='$machitiet' AND makho='$makho'";
        $this->setQuery($sql);
        $result = $this->query();
        return $result;
    }

    public  function tranhtontai($machitiet, $makho) {
        $param = array('machitiet' => $machitiet, 'makho' => $makho);
        return $this->is_exist($param);
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
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ( $row = mysql_fetch_row($result) ) {
            $arr [] = $row;
        }
      
        return $arr;
    }
    public function so_luong_ton_kho($machitiet, $makho) {
        $sql = "select soluong from tonkhosanxuat where machitiet = '$machitiet' and makho ='$makho';";
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        $row = mysql_fetch_row($result);
        if ( count($row) >0 ) {
            return $row[0];
        }
        return null;
    }
    public function laykhohang ($machitiet, $soluong) {
        $sql = 'select tonkhosanxuat.makho, tenkho from tonkhosanxuat 
                            inner join khohang on khohang.makho = tonkhosanxuat.makho
                where tonkhosanxuat.machitiet = "%s" and tonkhosanxuat.soluong >= "%s";';
        $sql = sprintf($sql, $machitiet, $soluong);
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ( $row = mysql_fetch_row($result) ) {
            $arr [] = $row;
        }
      
        return $arr;
    }

    public function giaohang($makho, $machitiet, $soluong) {
        $sql = "UPDATE tonkhosanxuat SET soluong = soluong-$soluong WHERE makho = '$makho' AND machitiet = '$machitiet';";
        $this->setQuery($sql);
        $result = $this->query();
        return $result;
    }

    public function trahang($makho, $machitiet, $soluong) {
        $sql = "UPDATE tonkhosanxuat SET soluong = soluong+$soluong WHERE makho = '$makho' AND machitiet = '$machitiet';";
        $this->setQuery($sql);
        $result = $this->query();
        return $result;
    }

    public function insert( $params )
    {
        $val = implode( "','", $params );

        $sql = "insert into $this->_NAMETABLE($this->_MAKHO, $this->_MACHITIET, $this->_SOLUONG) values('$val');";
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
