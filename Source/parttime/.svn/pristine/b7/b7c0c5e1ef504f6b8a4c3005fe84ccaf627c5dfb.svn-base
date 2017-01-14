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
include_once '../config/constants.php';
include_once 'database.php';
include_once 'helper.php';

class category_group_building extends database {
    public $_NAMETABLE = 'hangmucdoithicong';

    public $_ID_GROUP = "madoithicong";
    public $_ID_CATEGORY = "idhangmuc";
    public $_COST = "giatien";
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

    public function getAll($params = array(), $conditions = array(), $tablejoin = "") {
        $select = "select *";
        if ( count($params) > 0 && !empty($params) ) {
            $select = "select ".implode(" ,", $params);
        }
        $where = "";
        if ( count($conditions) > 0 && !empty($conditions) ) {
            $where = "where ".mergeTostr($conditions, "and", "=");
        }
        $sql = "$select from $this->_NAMETABLE $tablejoin $where;";
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ( $row = mysql_fetch_row($result) ) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function insert( $params )
    {
        $val = implode( "','", $params );

        $sql = "insert into $this->_NAMETABLE($this->_ID_GROUP,$this->_ID_CATEGORY, $this->_COST) values('$val');";
        $this->setQuery( $sql );
        $result = $this->query();
        if ( $result ) {
            return true;
        }  
        return false;
    }

    public function deleteid($idgroup, $idcata)
    {
        $sql = "Delete from $this->_NAMETABLE where $this->_ID_GROUP = '$idgroup' and $this->_ID_CATEGORY = '$idcata';";
        $this->setQuery($sql);
        $result = $this->query();
        if ($result) {
            return true;
        }
        return false;
    }
    
    public function delete($conditions)
    {
        $where = mergeTostr($conditions, "and", "=");
        $sql = "Delete from $this->_NAMETABLE where $where;";
        $this->setQuery($sql);
        $result = $this->query();
        if ($result) {
            return true;
        } 
        return false;
    }
}
?>
