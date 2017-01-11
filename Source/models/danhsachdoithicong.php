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

class list_group_construction extends database {
    public $_NAMETABLE = 'danhsachdoithicong';

    public $_ID = 'id';
    public $_NAME_GROUP = 'tendoi';
    public $_ADDRESS = 'diachi';
    public $_NUM_PHONE = 'sodienthoai';
    public $_ID_GROUP = 'madoi';

    public function get_by_id_category($id_category) {
        $sql = "select id, tendoi, diachi, sodienthoai, madoi, giatien from danhsachdoithicong ds 
                            inner join  hangmucdoithicong hmd on hmd.madoithicong = ds.id 
                        where hmd.idhangmuc = '$id_category';";
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ($row = mysql_fetch_array($result)) {
            // $row[6] = number_2_string($row[6]); 
            $arr[] = $row;
        }
        return $arr;
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

    public function insert($name_group, $address, $num_phone, $id_group)
    {
        // kiểm tra giá trị đầu vào của $describe
        if ( empty($name_group) || empty($address) || empty($num_phone) || empty($id_group) ) {
            return false;
        }

        $sql = "insert into $this->_NAMETABLE($this->_ID, $this->_NAME_GROUP, $this->_ADDRESS, $this->_NUM_PHONE, $this->_ID_GROUP) values(null, '$name_group','$address', '$num_phone', '$id_group');";
        $this->setQuery($sql);
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

    public function update($id, $name_group='', $address='', $num_phone, $id_group='')
    {
        $set = "";
        if (!empty($name_group)) {
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_NAME_GROUP = '$name_group'";
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

        if (!empty($id_group)) {
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_ID_GROUP = '$id_group'";
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

// $model = new list_group_construction();
// $model->update('1','001','cách mạng tháng 8','','','','');
?>
