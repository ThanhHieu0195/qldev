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

class list_provider extends database {
    public $_NAMETABLE = 'danhsachnhacungcap';

    public $_ID = 'id';
    public $_NAME = 'ten';
    public $_ADDRESS = 'diachi';
    public $_NUM_PHONE = 'dienthoai';
    public $_ID_CATEGORY = 'idhangmuc';
    public $_ID_PRODUCT = 'manhacc';

    public function get_by_id_category($id_category) {
        $sql = "select * from $this->_NAMETABLE where $this->_ID_CATEGORY = '$id_category'";
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ($row = mysql_fetch_array($result)) {
            $arr[] = $row;
        }
        return $arr;
    } 
    
    public function insert($name, $address, $num_phone, $id_category, $id_produce)
    {
        // kiểm tra giá trị đầu vào của $describe
        // if (empty($name) || empty($address) || empty($num_phone) || empty($id_category) || empty($id_produce)) {
        //     return false;
        // }

        $sql = "insert into $this->_NAMETABLE($this->_ID, $this->_NAME, $this->_ADDRESS, $this->_NUM_PHONE, $this->_ID_CATEGORY, $this->_ID_PRODUCT) values('', '$name','$address', '$num_phone', '$id_category', '$id_produce');";
        $this->setQuery($sql);
        // print_r($sql);
        $result = $this->query();
        if ($result) {
            return true;
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

    public function update($id, $name='', $address='', $num_phone, $id_category='', $id_produce='')
    {
        $set = "";
        if (!empty($name)) {
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_NAME = '$name'";
        }

        if (!empty($address)) {
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_ADDRESS = '$address'";
        }

        if (!empty($num_phone)) {
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_NUM_PHONE = '$num_phone'";
        }

        if (!empty($id_category)) {
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_ID_CATEGORY = '$id_category'";
        }

        if (!empty($id_produce)) {
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_ID_PRODUCT = '$id_produce'";
        }

        $sql = "update $this->_NAMETABLE set $set where $this->_ID = '$id';";
        // print_r($sql);
        $this->setQuery($sql);
        $result = $this->query();
        if ($result) {
            return true;
        } 
        return false;
    }
}

// $model = new list_provider();
// $model->update('1','Xi mang ha tien 1','3','4','5','6');
?>
