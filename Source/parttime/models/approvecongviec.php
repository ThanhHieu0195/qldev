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

class approve_work extends database {
    public $_NAMETABLE = 'approvecongviec';

    public $_ID = 'id';
    public $_ID_WORK = "idcongviec";
    public $_ID_EMPLOYEE = "manv";
    public $_STATUS = "trangthai";
    public $_DATE_COMPLETE = "ngaynopbai";
    public $_TOTAL_P = 5;
    public $_NAME_COLUMN = array();

    public function __construct() {
         $this->_NAME_COLUMN = array( 'id'=>$this->_ID, 'id_work'=>$this->_ID_WORK, 'id_employee'=>$this->_ID_EMPLOYEE, 
                                         'status'=>$this->_STATUS, 'date_complete'=>$this->_DATE_COMPLETE);
    }

    public function approve($params) {
        $where = "";
        if ( count($params) > 0 ) {
            $where =  "where ".mergeTostr($params, "and", "=");
        }
        $params_exists = $params;
        $params_exists['trangthai'] = STATUS_DEFAULT;
        if ( $this->is_exist( $params_exists ) ) {
            $sql = "UPDATE $this->_NAMETABLE SET $this->_STATUS = '".STATUS_APPROVE."' $where;";
            $this->setQuery($sql);
            $result = $this->query();
        } else {
            $result = false;
        }
        return $result;
    }

    public function reject($params) {
        $where = "";
        if ( count($params) > 0 ) {
            $where =  "where ".mergeTostr($params, "and", "=");
        }
        $params_exists = $params;
        $params_exists['trangthai'] = STATUS_DEFAULT;
        if ( $this->is_exist( $params_exists ) ) {
            $sql = "UPDATE $this->_NAMETABLE SET $this->_STATUS = '".STATUS_REJECT."' $where;";
            $this->setQuery($sql);
            $result = $this->query();
        }else {
            $result = false;
        }
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

    public function getDateInsertResultList($id) {
        $sql = "select '' id, a.idcongviec macongviec, a.manv, a.ngaynopbai, cv.giatien, '' attachment, '' ghichu, ".STATUS_APPROVE." trangthai, '' nhanxet from approvecongviec a inner join congvieccongtac cv on a.idcongviec = cv.id where a.id = $id";
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        $row = mysql_fetch_assoc($result);
        return $row;

    }

    public function insert( $params )
    {
        $val = implode( "','", $params );

        $sql = "insert into $this->_NAMETABLE($this->_ID, $this->_ID_WORK, $this->_ID_EMPLOYEE, $this->_STATUS, $this->_DATE_COMPLETE) values('$val');";
        $this->setQuery( $sql );
        $result = $this->query();
        if ( $result ) {
            return true;
        }  
        return false;
    }
}
// $model =  new approve_work();
// print_r( $model->getDateInsertResultList(3) );
?>
