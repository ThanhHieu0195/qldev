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

class detail_material_category extends database {
    public $_NAMETABLE = 'chitietvattucongtrinh';
    public $_COLUMN_NAME = array('id', 'idcongtrinh','idhangmuc','idvattu','dongiavattu','soluongdutoan','soluongthucte','soluongphatsinh','soluongdamua','idnhacungcap','dongiamua','trangthai','ghichu');

    public $_idcongtrinh = 'idcongtrinh';
    public $_idhangmuc = 'idhangmuc';
    public $_idvattu = 'idvattu';
    public $_dongiavattu = 'dongiavattu';
    public $_soluongdutoan = 'soluongdutoan';
    public $_soluongthucte = 'soluongthucte';
    public $_soluongphatsinh = 'soluongphatsinh';
    public $_soluongdamua = 'soluongdamua';
    public $_idnhacungcap = 'idnhacungcap';
    public $_dongiamua = 'dongiamua';
    public $_trangthai = 'trangthai';
    public $_ghichu = 'ghichu';
    public $_id = 'id';

    public $_TOTAL_P = 10;
    // id_building, id_category, id_material, soluongdutoan, num, giadutoan, cost, id_product, status, note
    public function getDetail($conditions, $params) {
        $select = "*";
        if ( is_array($params) ) {
            $select = implode(", ", $params);
        }

        $where = mergeTostr($conditions, ' and ', ' = ');
        $sql = "select $select, (select giacao from vattuhangmucthicong where id=idvattu) as giacao from $this->_NAMETABLE where $where";
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ( $row = mysql_fetch_array($result) ) {
            $arr[] = $row;
        }
        return $arr;
    }

    public function takeLastId() {
        $sql = "select ifnull(max(id),0) as id from $this->_NAMETABLE;";
        $this->setQuery($sql);
        $result = $this->query();
        $row = mysql_fetch_array($result);
        if (is_array ( $row )) {
            return $row ['id'];
        }
        return 0;
    }

    public function insert( $param )
    {
        $val = implode( "','", $param );
        $col = implode( ",",$this->_COLUMN_NAME );
        $table = $this->_NAMETABLE;

        $sql = "insert into $table($col) values('$val');";
        //error_log ("Add new" . $sql, 3, '/var/log/phpdebug.log');
//        debug($sql);
        $this->setQuery( $sql );
        $result = $this->query();
        if ( $result ) {
            return true;
        }
        return false;
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
        error_log ("Add new" . $sql, 3, '/var/log/phpdebug.log');
        $this->setQuery($sql);
        $result = $this->query();
        return $result;
    }

    public function is_exists ($params)
    {   
        if ( count($params) >0 ) {
            $where = mergeTostr($params, 'and', '=', $this->_NAME_COLUMN);
            $sql = "SELECT * FROM $this->_NAMETABLE WHERE $where;";
            $this->setQuery($sql);
            $result = $this->query();
            $row = mysql_fetch_row($result);
            if ( !empty($row) ) {
                return true;
            }
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

    public  function laygiatri($condition = array(), $field = array() ) {
        $field = implode(",", $field);
        if ( empty($field) ) {
            $field = "*";
        }

        $where = '';
        if ( count($condition) > 0 ) {
            $where = mergeTostr($condition, 'and', '=');
        }
        if ( $this->tontai( $condition ) ) {
            $sql = "select $field from $this->_NAMETABLE where $where;";
            $this->setQuery($sql);
            $result = $this->query();
            $arr = array();
            while ( $row = mysql_fetch_assoc($result) ) {
                $arr[] = $row;
            }
            return $arr;
        }
        return array();
    }

    public function tontai($condition = array()) {
        $where = '';
        if ( count($condition) > 0 ) {
            $where = mergeTostr($condition, 'and', '=');
        }

        $sql = "select count(*) num from $this->_NAMETABLE where $where;";
        $this->setQuery($sql);
        $result = $this->query();
        $row = mysql_fetch_row($result);
        if ($row[0] > 0) {
            return $row[0];
        }
        return 0;
    }

    public $_NAME_COLUMN = array('id_building'=>'idcongtrinh', 
                                'id_category'=>'idhangmuc',  
                                'id_material'=>'idvattu', 
                                'id'=>'id', 
                                'soluongdutoan'=>'soluongdutoan', 
                                'num'=>'soluongthucte',
                                'giadutoan'=>'giadutoan',
                                'cost'=>'giathucte',
                                'id_product'=>'idnhacungcap',
                                'status'=>'trangthai',
                                'note'=>'ghichu');
    // id_building, id_category, id_material, id, soluongdutoan, num, giadutoan, cost, id_product, status, note

}
// $model = new detail_material_category();
// echo $model->takeLastId();
?>
