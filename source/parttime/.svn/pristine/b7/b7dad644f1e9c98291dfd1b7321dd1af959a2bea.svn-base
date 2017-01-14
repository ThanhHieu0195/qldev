<?php
/**
 * Created by PhpStorm.
 * User: Hieu
 * Date: 02/01/2017
 * Time: 8:13 SA
 */

include_once 'database.php';
include_once 'helper.php';
include_once '../config/constants.php';

class vansanxuat extends database {
    public $_NAMETABLE = 'vansanxuat';
    public $_COLUMN_NAME = array('madonhang', 'masotranh', 'machitiet', 'dientich', 'mavan');
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


//    ajax
    function insert_Ajax()
    {
        $condition = array();
        if ( isset($GLOBALS['condition']) ) {
            $condition = $GLOBALS['condition'];
        }
        $param = $condition;
        if (count($condition) == 3) {
            require_once  "../models/chitietphanbu.php";
            $chitietphanbu = new chitietphanbu();
            $row = $chitietphanbu->getRow(array(), $condition);
            $mavan = $row[8];
            $dientich = floatval($row[3])*floatval($row[4]);
            $param['dientich'] = $dientich;
            $param['mavan'] = $mavan;
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

}

//$model = new chitietphanbu();
//ht_print( $model->checkAllStatus('th110011', 4) );

