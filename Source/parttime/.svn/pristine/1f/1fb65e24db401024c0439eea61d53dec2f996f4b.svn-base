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

class danchi extends database {
    public $_NAMETABLE = 'danchi';
    public $_COLUMN_NAME = array('madanchi', 'mota');

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

    public function getAllOption( $params=array(), $otable="", $conditions=array() ) {
        $select = "select *";
        $html = '';
        $format_option  = '<option value="%1$s"> %2$s </option>';

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
        $html .= sprintf($format_option, '', '[Choose value]');
        while ( $row = mysql_fetch_row($result) ) {
            $html .= sprintf($format_option, $row[0], $row[1]);
        }
        return $html;
    }

    public function insert( $params )
    {
        $val = implode( "','", $params );
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