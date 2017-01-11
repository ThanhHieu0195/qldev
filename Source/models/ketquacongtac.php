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

class result_work extends database {
    public $_NAMETABLE = 'ketquacongtac';

    public $_ID = 'id';
    public $_ID_WORK = "macongviec";
    public $_ID_EMPLOYEE = "manv";
    public $_DATE_COMPLETE = "ngaynopbai";
    public $_COST = "giatien";
    public $_ATTACHMENT = "attachment";
    public $_NOTE = "ghichu";
    public $_STATUS = "trangthai";
    public $_COMMENT = "Nhanxet";
    public $_TOTAL_COLUMN = "9";
    public $_NAME_COLUMN = array();

    public function __construct() {
         $this->_NAME_COLUMN = array( 'id'=>$this->_ID, 'id_work'=>$this->_ID_WORK, 'id_employee'=>$this->_ID_EMPLOYEE, 
                                         'date_complete'=>$this->_DATE_COMPLETE, 'cost'=>$this->_COST, 'attachment'=>$this->_ATTACHMENT,'note'=>$this->_NOTE, 'status'=>$this->_STATUS,'comment'=>$this->_COMMENT );
    }

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
    // $this->_ID,$this->_ID_WORK, $this->_ID_EMPLOYEE, $this->_DATE_COMPLETE, $this->_COST, $this->_ATTACHMENT,$this->_NOTE, $this->_STATUS, $this->_COMMENT 
    public function insert( $params )
    {
        $val = implode( "','", $params );

        $sql = "insert into $this->_NAMETABLE($this->_ID,$this->_ID_WORK, $this->_ID_EMPLOYEE, $this->_DATE_COMPLETE, $this->_COST, $this->_ATTACHMENT,$this->_NOTE, $this->_STATUS, $this->_COMMENT ) values('$val');";
        $this->setQuery( $sql );
        $result = $this->query();
        if ( $result ) {
            return true;
        }  
        return false;
    }
}
?>
