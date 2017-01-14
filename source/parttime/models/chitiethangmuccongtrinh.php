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

class detail_category_building extends database {
    public $_NAMETABLE = 'chitiethangmuccongtrinh';
    public $_COLUMN_NAME = array('idcongtrinh','idhangmuc','ngaydukienbatdau','ngaydukienketthuc','ngaybatdau','ngayketthuc','dongiahangmuc','khoiluongdutoan','khoiluongthucte','khoiluongphatsinh','iddoithicong','dongiathicong','tiendachi','trangthai','ghichu');
    public $_idcongtrinh = 'idcongtrinh';
    public $_idhangmuc = 'idhangmuc';
    public $_ngaydukienbatdau = 'ngaydukienbatdau';
    public $_ngaydukienketthuc = 'ngaydukienketthuc';
    public $_ngaybatdau = 'ngaybatdau';
    public $_ngayketthuc = 'ngayketthuc';
    public $_dongiahangmuc = 'dongiahangmuc';
    public $_khoiluongdutoan = 'khoiluongdutoan';
    public $_khoiluongthucte = 'khoiluongthucte';
    public $_khoiluongphatsinh = 'khoiluongphatsinh';
    public $_iddoithicong = 'iddoithicong';
    public $_dongiathicong = 'dongiathicong';
    public $_tiendachi = 'tiendachi';
    public $_trangthai = 'trangthai';
    public $_ghichu = 'ghichu';


    public function getdetailupdate($id) {
        $sql = "select hm.tenhangmuc, hm.dongiathdutoan, hm.songaythicong, tthm.mota, nhm.mota as nhom, t.*  
        from $this->_NAMETABLE t 
        inner join hangmucthicong hm on hm.id = t.$this->_idhangmuc 
        inner join trangthaihangmuc tthm on tthm.id = t.trangthai
        inner join nhomhangmuc nhm on nhm.id = hm.nhomhangmuc

        where $this->_idcongtrinh = '$id' order by hm.nhomhangmuc, t.ngaybatdau asc;";
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ($row = mysql_fetch_assoc($result)) {
            $arr[] = $row;
        }
        return $arr;
    }


    public function insert( $param )
    {
        $val = implode( "','", $param );
        $col = implode( ",",$this->_COLUMN_NAME );
        $table = $this->_NAMETABLE;

        $sql = "insert into $table($col) values('$val');";
        //error_log ("Add new" . $sql, 3, '/var/log/phpdebug.log');
        $this->setQuery( $sql );
        $result = $this->query();
        if ( $result ) {
            return true;
        }
        return false;
    }

    public function updatedongia($idcongtrinh, $idhangmuc) {
        $sql = "update chitiethangmuccongtrinh set dongiahangmuc=(select dongiathdutoan from hangmucthicong where id={$idhangmuc}) where idcongtrinh={$idcongtrinh} and idhangmuc={$idhangmuc}";
        $this->setQuery( $sql );
        $result = $this->query();
        if ( $result ) {
            return true;
        }
        return false;
    }

    public function get_detail_by_id($id, $id_category) {
        $sql = "select * from $this->_NAMETABLE where $this->_idcongtrinh = '$id' AND $this->_idhangmuc = '$id_category';";
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ($row = mysql_fetch_assoc($result)) {
            # code...
            $arr[] = $row;
        }
        return $arr;
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

    // id, id_category
    // date_start, date_expect_finish, date_finish, id_group, construction_unit,expect_money, actual_cost, money_spent, status, assess, work_load
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
}

// $model = new detail_category_building();
// print_r($model->get_detail_by_id('1','1'));
?>
