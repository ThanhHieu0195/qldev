<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 16/01/2017
 * Time: 4:36 CH
 */
include_once 'database.php';
include_once 'helper.php';
include_once 'account_helper.php';

class yeucauthaydoivattu extends database {
    public $_NAMETABLE = 'yeucauthaydoivattu';
    public $_COLUMN_NAME = array('id', 'idcongtrinh', 'idhangmuc', 'idvattu','ngayyeucau', 'khoiluongbandau', 'khoiluongthaydoi', 'nhanvienyeucau', 'nhanvienduyet', 'trangthai', 'ghichu');
    public function insert($params = array() )
    {
        $col = implode(",", $this->_COLUMN_NAME);
        $params = implode("','", $params);
        $sql = "insert into $this->_NAMETABLE($col) 
        values('$params');";
        $this->setQuery($sql);
        $result = $this->query();
        if ($result) {
            return mysql_insert_id();
        }
        return false;
    }

    public function delete($id)
    {
        $sql = "Delete from $this->_NAMETABLE where $this->_ID = '$id';";
        $this->setQuery($sql);
        $result = $this->query();
        if ($result) {
            return true;
        }
        return false;
    }

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

    function xacnhan($id) {
        $row = $this->laygiatri( array('id' => $id) );
        if ( empty($row) ) return 0;

        $row = $row[0];
        $res = $this->update( array('trangthai' => STATUS_APPROVE, 'nhanvienduyet' => current_account()), array('id' => $id) );
        if ($res) {
            require_once "chitietvattucongtrinh.php";
            $chitietvattucongtrinh = new detail_material_category();
            $condition = array('idcongtrinh'=>$row['idcongtrinh'], 'idhangmuc'=>$row['idhangmuc']);
            $khoiluongphatsinh = $row['khoiluongthaydoi'];
            $ghichu = 'Phát sinh';

            require_once "vattuhangmucthicong.php";
            $vattuhangmucthicong = new material_category();
            $arr = $vattuhangmucthicong->get_by_id($row['idhangmuc']);
            $dongiavattu = $arr['giathap'];
            $param = array('', $row['idcongtrinh'],$row['idhangmuc'], $row['idvattu'], $dongiavattu, '', '', $khoiluongphatsinh,
                '','','','',$ghichu);
            $res = $chitietvattucongtrinh->insert($param);
            return $res;
        }
    }

    function huy($id) {
        $res = $this->update( array('trangthai' => STATUS_APPROVE, 'nhanvienduyet' => current_account()), array('id' => $id) );
        return $res;
    }
}