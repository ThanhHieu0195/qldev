<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of trahang
 *
 // 
 * @author HieuThanh
 */
include_once 'database.php';
include_once 'helper.php';
include_once '../config/constants.php';

class collaborative_work extends database {
    public $_NAMETABLE = 'congvieccongtac';

    public $_ID = 'id';
    public $_DESCRIBE = 'mota';
    public $_DATE_COMPLETE = 'ngayhoanthanh';
    public $_COST = 'giatien';
    public $_ATTACHMENT = 'attachment';
    public $_STATUS = 'trangthai';
    public $_TOTAL_P = 6;
    public $_NAME_COLUMN = array();
    public $_LIST_STATUS = array("Mở", "Đã nhận");
    public function __construct() {
         $this->_NAME_COLUMN = array( 'id'=>$this->_ID, 'description'=>$this->_DESCRIBE, 'date_complete'=>$this->_DATE_COMPLETE, 
                                         'cost'=>$this->_COST, 'attachment'=>$this->_ATTACHMENT, 'status'=>$this->_STATUS);
    }

    public function approve($params) {
        $where = "";
        if ( count($params) > 0 ) {
            $where =  "where ".mergeTostr($params, "and", "=");
        }
        $sql = "UPDATE $this->_NAMETABLE SET $this->_STATUS = '".STATUS_APPROVE."' $where;";
        $this->setQuery($sql);
        $result = $this->query();
        return $result;
    }

    public function getAll( $params=array(), $conditions=array() ) {
        $select = "select *";
        if ( count($params) > 0 ) {
            $select = "select ".implode(", ", $params);
        }
        $from = "from $this->_NAMETABLE";
        $where = "";
        if ( count($conditions) > 0 ) {
            $where = "where ".mergeTostr($conditions, "and ", "=");
        } 

        $sql = "$select $from $where;";
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

        $sql = "insert into $this->_NAMETABLE($this->_ID, $this->_DESCRIBE, $this->_DATE_COMPLETE, $this->_COST, $this->_ATTACHMENT, $this->_STATUS) values('$val');";
        $this->setQuery( $sql );
        $result = $this->query();
        if ( $result ) {
            return true;
        }  
        return false;
    }
}
?>
