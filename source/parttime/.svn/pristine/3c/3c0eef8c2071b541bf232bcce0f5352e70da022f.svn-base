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

class category_building extends database {
    public $_NAMETABLE = 'hangmucthicong';

    public $_ID = 'id';
    public $_NAME_CATEGORY = 'tenhangmuc';
    public $_GROUP_CATEGORY = 'nhomhangmuc';
    public $_DESCRIBE = 'mota';
    public $_CONSTRUCTION_DATE = "songaythicong";
    public $_EXPECT_COST = "dongiathdutoan";

    public function get_all_group_category() {
        $sql = "select DISTINCT $this->_GROUP_CATEGORY from $this->_NAMETABLE";
         $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ($row = mysql_fetch_row($result)) {
            $arr[] = $row[0];
        }  
        return $arr;
    }

    public function get_all_category() {
        $sql = "select DISTINCT $this->_ID, $this->_NAME_CATEGORY  from $this->_NAMETABLE";
         $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ($row = mysql_fetch_row($result)) {
            $arr[] = $row;
        }  
        return $arr;
    }

    public function get_category_by_group($group_category) {
        if ( empty($group_category) ) {
            return $this->get_all_category();
        }
        
        $sql = "select DISTINCT $this->_ID, $this->_NAME_CATEGORY from $this->_NAMETABLE where $this->_GROUP_CATEGORY like '$group_category';";
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ($row = mysql_fetch_row($result)) {
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

    public function get_all()
    {
        $sql = "select * from $this->_NAMETABLE;";
        $this->setQuery($sql);
        // print_r($sql);
        $result = $this->query();
        $arr = array();
        while ($row = mysql_fetch_array($result)) {
            $arr[] = $row;
        }  
        return $arr;
    }

    public function insert($name_category, $group_category, $describe, $construction_date, $expect_cost)
    {
        $sql = "insert into $this->_NAMETABLE($this->_ID, $this->_NAME_CATEGORY, $this->_GROUP_CATEGORY, $this->_DESCRIBE, $this->_CONSTRUCTION_DATE, $this->_EXPECT_COST) values('', '$name_category', '$group_category', '$describe', '$construction_date', '$expect_cost');";
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
    // name_category, describe, construction_date, expect_cost
    public function update($params)
    {
        $set = "";
        if (!empty($params['name_category'])) {
            $val =$params['name_category'];
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_NAME_CATEGORY = '$val'";
        }

        if (!empty($params['describe'])) {
            $val = $params['describe'];
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_DESCRIBE = '$val'";
        }

        if (!empty($params['construction_date'])) {
            $val = $params['construction_date'];
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_CONSTRUCTION_DATE = '$val'";
        }

        if (!empty($params['expect_cost'])) {
            $val = $params['expect_cost'];
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_EXPECT_COST = '$val'";
        }

        if (!empty($params['group_category'])) {
            $val = $params['group_category'];
            if (!empty($set)) {
                $set .= ", ";
            }
            $set .= "$this->_GROUP_CATEGORY = '$val'";
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
        $this->setQuery($sql);
        $result = $this->query();
        if ($result) {
            return true;
        } 
        return false;
    }
}

// $model = new category_building();
// $model->delete('1');
?>
