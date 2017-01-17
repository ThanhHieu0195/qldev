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

class yeucauthaydoihangmuc extends database {
    public $_NAMETABLE = 'yeucauthaydoihangmuc';
    public $_COLUMN_NAME = array('id', 'idcongtrinh', 'idhangmuc', 'ngayyeucau', 'khoiluongbandau', 'khoiluongthaydoi', 'nhanvienyeucau', 'nhanvienduyet', 'trangthai', 'ghichu');

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

    function xacnhan($id) {
        $row = $this->laygiatri( array('id' => $id) );
        if ( empty($row) ) return 0;

        $row = $row[0];
        $res = $this->update( array('trangthai' => STATUS_APPROVE, 'nhanvienduyet' => current_account()), array('id' => $id) );
        if ($res) {
            require_once "chitiethangmuccongtrinh.php";
            $chitiethangmuccongtrinh = new detail_category_building();
            $condition = array('idcongtrinh'=>$row['idcongtrinh'], 'idhangmuc'=>$row['idhangmuc']);
            if ( $chitiethangmuccongtrinh->tontai( $condition )) {
//update
                $data = $chitiethangmuccongtrinh->laygiatri($condition);
                $khoiluongphatsinh = floatval($data['0']['khoiluongphatsinh']) + floatval($row['khoiluongthaydoi']);
                $ghichu = 'Phát sinh';
                $param = array('khoiluongphatsinh' => $khoiluongphatsinh, 'ghichu' => $ghichu);
                $res = $chitiethangmuccongtrinh->update($param, $condition);
            } else {
//insert
                print_r($row);
                $khoiluongphatsinh = $row['khoiluongthaydoi'];
                $ghichu = 'Phát sinh';
                require_once "hangmucthicong.php";
                $hangmucthicong = new category_building();
                $arr = $hangmucthicong->get_by_id($row['idhangmuc']);
                $dongiahangmuc = $arr['dongiathdutoan'];
                $param = array($row['idcongtrinh'], $row['idhangmuc'], '','','','',$dongiahangmuc,'','',$khoiluongphatsinh,'','','','',$ghichu);
                $res = $chitiethangmuccongtrinh->insert($param);
            }
            return $res;

        }
    }

    function huy($id) {
        $res = $this->update( array('trangthai' => 2, 'nhanvienduyet' => current_account()), array('id' => $id) );
        return $res;
    }
}