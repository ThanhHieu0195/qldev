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

class material_category extends database {
    public $_NAMETABLE = 'vattuhangmucthicong';

    public $_ID = 'id';
    public $_ID_CATEGORY = 'idhangmuc';
    public $_NAME_MATERIAL = 'tenvattu';
    public $_SPEC = 'thongso';
    public $_PRICE_LOW = 'giathap';
    public $_PRICE_HIGH = 'giacao';
    public $_UNIT = 'donvitinh';
    public static $_LIST_UNIT = array(1=>'m2', 2=>'kg', 3=>'cai');

    static public function change_unit($k, $f=true) {
        $arr = material_category::$_LIST_UNIT;
        $result = "";
        if ($f) {
            if (isset($arr[$k])) {
                $result = $arr[$k];
            }
        } else {
            foreach ($variable as $key => $value) {
                if($k == $value) {
                    $result = $key;
                }
            }
        }
        return $result;
    }

    public function get_by_id_category($id_category) {
        $sql = "select * from $this->_NAMETABLE where $this->_ID_CATEGORY = '$id_category'";
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ($row = mysql_fetch_array($result)) {
            $row[5] = material_category::change_unit($row[5]);
            $arr[] = $row;
        }
        return $arr;
    }

    public function get_by_id($id)
    {
        $sql = "select * from $this->_NAMETABLE where $this->_ID = '$id';";
        $this->setQuery($sql);
        $result = $this->query();
        $row = mysql_fetch_array($result);
        return $row;
    }

    public function insert($id_category, $name_material, $spec, $price_low, $price_high, $unit)
    {
        // kiểm tra giá trị đầu vào của $describe
        if (empty($id_category) || empty($name_material) || empty($price_low) || empty($price_high) || empty($unit) || empty($spec)) {
            return false;
        }

        $sql = "insert into $this->_NAMETABLE($this->_ID, $this->_ID_CATEGORY, $this->_NAME_MATERIAL, $this->_SPEC, $this->_PRICE_LOW, $this->_PRICE_HIGH, $this->_UNIT) values(null, '$id_category','$name_material', '$spec', '$price_low', '$price_high', '$unit');";
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

    public function update($id, $id_category='', $name_material='', $spec='', $price_low='', $price_high='', $unit = '')
    {
        $set = "";
        if (!empty($id_category)) {
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_ID_CATEGORY = '$id_category'";
        }

        if (!empty($name_material)) {
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_NAME_MATERIAL = '$name_material'";
        }

        if (!empty($spec)) {
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_SPEC = '$spec'";
        }

        if (!empty($price_low)) {
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_PRICE_LOW = '$price_low'";
        }

        if (!empty($price_high)) {
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_PRICE_HIGH = '$price_high'";
        }

         if (!empty($unit)) {
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_UNIT = '$unit'";
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

// $model = new material_category();
// $model->update('1', '', 'demo1','1000', '2000', '1');
?>
