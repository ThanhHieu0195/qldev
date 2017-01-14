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

class work_category extends database {
    public $_NAMETABLE = 'congviechangmucthicong';

    public $_ID = 'id';
    public $_ID_CATEGORY = 'idhangmuc';
    public $_DESCRIBE = 'motacongviec';
    public $_TARGET_COMPLETE = 'tieuchihoanthanh';

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

    public function insert($id_category, $describe, $target_complete)
    {
        // kiểm tra giá trị đầu vào của $describe
        if (empty($id_category) || empty($describe) || empty($target_complete)) {
            return false;
        }

        $sql = "insert into $this->_NAMETABLE($this->_ID, $this->_ID_CATEGORY, $this->_DESCRIBE, $this->_TARGET_COMPLETE) values(null, '$id_category','$describe', '$target_complete');";
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
        print_r($sql);
        $result = $this->query();
        if ($result) {
            return true;
        } 
        return false;
    }

    public function update($id, $id_category='', $describe='', $target_complete='')
    {
        $set = "";
        if (!empty($id_category)) {
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_ID_CATEGORY = '$id_category'";
        }

        if (!empty($describe)) {
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_DESCRIBE = '$describe'";
        }

         if (!empty($target_complete)) {
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_TARGET_COMPLETE = '$target_complete'";
        }

        $sql = "update $this->_NAMETABLE set $set where $this->_ID = '$id';";
        $this->setQuery($sql);
        $result = $this->query();
        if ($result) {
            return true;
        } 
        return false;
    }
}

// $model = new work_category_building();
// $model->update('1','1', 'demo1', 'hoàng thành 90%');
?>
