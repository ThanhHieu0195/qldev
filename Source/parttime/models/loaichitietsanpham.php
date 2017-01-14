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

class loaichitietsanpham extends database {
    public $_NAMETABLE = 'loaichitietsanpham';

    public $_MALOAI = 'maloai';
    public $_MOTA = "mota";
    public $_TOTAL_COLUMN = "2";

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

    public function insert( $params )
    {
        $val = implode( "','", $params );

        $sql = "insert into $this->_NAMETABLE($this->_MALOAI, $this->_MOTA) values('$val');";
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
