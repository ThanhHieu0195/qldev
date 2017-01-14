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

class list_building extends database {
    public $_NAMETABLE = 'danhsachcongtrinh';

    public $_ID = 'id';
    public $_NAME_BUILDING = 'tencongtrinh';
    public $_ADDRESS = 'diachi';
    public $_ID_GUEST = 'makhach';
    public $_STATUS = 'trangthai';
    public $_DATE_START = 'ngaykhoicong';
    public $_DATE_EXPECT_FISNISH = 'ngaydukienhoanthanh';
    public $_MONEY_ESTiMATE = ' giatridutoan';
    public $_MONEY_REAL = 'giatrithucte';
    public $_MONEY_OVERESTIMATE = 'giatriphatsinh';
    public $_MONEY_COLLECT = 'tiendathu';
    public $_MONEY_SPENT = 'tiendachi';
    public $_SALER = 'manvsale';
    public $_DESIGNER = 'manvthietke';
    public $_MONITOR = 'manvgiamsat';

    /*----------  2016-12-03 by HieuThanh  ----------*/
    function getdetailupdate($id) {
        $sql = "select id, tencongtrinh, t.diachi, k.makhach, k.hoten, k.dienthoai1, k.dienthoai2, k.dienthoai3, giatridutoan, giatrithucte, giatriphatsinh, ngaykhoicong, ngaydukienhoanthanh, trangthai 
        from $this->_NAMETABLE t 
            inner join khach k on k.makhach = t.makhach  
        where $this->_ID = '$id'";

        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        $row = mysql_fetch_object($result);
        return $row;
    }

    function approvecongtrinh($id) {
        $sql = "update danhsachcongtrinh set trangthai=trangthai+1 where id=${id}";
        $this->setQuery($sql);
        $result = $this->query();
        if ($result) {
            return 1;
        } else {
            return 0;
        }
    }

    function statistic() {
        $sql = "select * from $this->_NAMETABLE";

        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        $row = mysql_fetch_object($result);
        return $row;
    }
    function update_expect_money($id) {
        $sql = "SELECT (SUM_MONEY_FIRT.SUM+SUM_MATERIAL.SUM) TOTAL_EXPECT_MONEY 
        FROM (SELECT SUM(dudoanchiphibandau) AS SUM FROM chitiethangmuccongtrinh WHERE idcongtrinh = $id) as SUM_MONEY_FIRT, (SELECT IF(SUM(giadutoan) is null, 0, SUM(giadutoan)) AS SUM FROM chitietvattucongtrinh 
        WHERE idcongtrinh = $id) as SUM_MATERIAL";
        $this->setQuery($sql);
        $result = $this->query();
        $row = mysql_fetch_object($result);
        $total_expect_money = $row->TOTAL_EXPECT_MONEY;
        // print_r($sql);
        if( $this->update(array("id" => $id,"money_estimate"=>$total_expect_money)) ) {
            return $total_expect_money;
        }
        return -1;
    }

    function update_real_money($id) {
        $sql = "SELECT (SUM_MONEY_FIRT.SUM+SUM_MATERIAL.SUM) TOTAL_EXPECT_MONEY
        FROM (SELECT SUM(chiphithucte) AS SUM FROM chitiethangmuccongtrinh WHERE idcongtrinh = $id) as SUM_MONEY_FIRT, (SELECT IF(SUM(giathucte) is null, 0, SUM(giathucte)) AS SUM FROM chitietvattucongtrinh
        WHERE idcongtrinh = $id) as SUM_MATERIAL";
        $this->setQuery($sql);
        $result = $this->query();
        $row = mysql_fetch_object($result);
        $total_expect_money = $row->TOTAL_EXPECT_MONEY;
        // print_r($sql);
        if( $this->update(array("id" => $id,"money_real"=>$total_expect_money)) ) {
            return $total_expect_money;
        }
        return -1;
    }

    function update_over_money($id) {
        $sql = "SELECT (SUM_MONEY_FIRT.SUM+SUM_MATERIAL.SUM) TOTAL_EXPECT_MONEY
        FROM (SELECT SUM(chiphiphatsinh) AS SUM FROM chitiethangmuccongtrinh WHERE idcongtrinh = $id) as SUM_MONEY_FIRT, (SELECT IF(SUM(giaphatsinh) is null, 0, SUM(giaphatsinh)) AS SUM FROM chitietvattucongtrinh
        WHERE idcongtrinh = $id) as SUM_MATERIAL";
        $this->setQuery($sql);
        $result = $this->query();
        $row = mysql_fetch_object($result);
        $total_expect_money = $row->TOTAL_EXPECT_MONEY;
        // print_r($sql);
        if( $this->update(array("id" => $id,"money_overestimate"=>$total_expect_money)) ) {
            return $total_expect_money;
        }
        return -1;
    }

    public function insert($name_building, $address, $id_guest, $status, $date_start, $date_expect_end, $money_estimate,$money_in, $money_out, $thietke, $giamsat, $sale)
    {
        $sql = "insert into $this->_NAMETABLE($this->_ID, $this->_NAME_BUILDING, $this->_ADDRESS, $this->_ID_GUEST, $this->_STATUS, $this->_DATE_START, $this->_DATE_EXPECT_FISNISH, $this->_MONEY_ESTiMATE,$this->_MONEY_COLLECT, $this->_MONEY_SPENT, $this->_DESIGNER, $this->_MONITOR, $this->_SALER) 

        values('', '$name_building', '$address','$id_guest', '$status', '$date_start', '$date_expect_end', '$money_estimate','$money_in', '$money_out', '$thietke', '$giamsat', '$sale');";
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
    //$id, name_building, address, id_guest, status, date_start, date_expect_end, money_estimate, money_in, money_out
    public function update($params)
    {
        $set = "";
        if (!empty($params['name_building'])) {
            $val = $params['name_building'];
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_NAME_BUILDING = '$val'";
        }

        if (!empty($params['address'])) {
            $val = $params['address'];
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_ADDRESS = '$val'";
        }

        if (!empty($params['id_guest'])) {
            $val = $params['id_guest'];
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_ID_GUEST = '$val'";
        }

        if (!empty($params['status'])) {
            $val = $params['status'];
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_STATUS = '$val'";
        }

        if (!empty($params['date_start'])) {
            $val = $params['date_start'];
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_DATE_START = '$val'";
        }

        if (!empty($params['date_expect_end'])) {
            $val = $params['date_expect_end'];
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_DATE_EXPECT_FISNISH = '$val'";
        }

        if (!empty($params['money_estimate'])) {
            $val = $params['money_estimate'];
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_MONEY_ESTiMATE = '$val'";
        }

        if (!empty($params['money_real'])) {
            $val = $params['money_real'];
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_MONEY_REAL = '$val'";
        }

        if (!empty($params['money_overestimate'])) {
            $val = $params['money_overestimate'];
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_MONEY_OVERESTIMATE = '$val'";
        }

          if (!empty($params['money_in'])) {
            $val = $params['money_in'];
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_MONEY_COLLECT = '$val'";
        }

        if (!empty($params['money_out'])) {
            $val = $params['money_out'];
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_MONEY_SPENT = '$money_out'";
        }

        $where = "";
         if (!empty($params['id'])) {
            $val = $params['id'];
            if (!empty($where)) {
                $where .= ", ";
            }
            $where .= "$this->_ID = '$val'";
        }
        $sql = "update $this->_NAMETABLE set $set where $where;";
        // print_r($sql);
        $this->setQuery($sql);
        $result = $this->query();
        if ($result) {
            return true;
        } 
        return false;
    }
}

// $model = new list_building();
// print_r($model->getdetail(4));
// $model->update('1','TC001','2','3','4','2016-01-01','2016-10-10','7','8');
?>
