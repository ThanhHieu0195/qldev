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

class group_category_building extends database {
    public $_NAMETABLE = 'nhomhangmuc';

    public $_ID = 'id';
    public $_DESCRIBE = 'mota';
    
    public function insert($describe)
    {
        // kiểm tra giá trị đầu vào của $describe
        if (empty($describe)) {
            return false;
        }

        $sql = "insert into $this->_NAMETABLE($this->_ID, $this->_DESCRIBE) values(null, '$describe');";
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

    public function update($id, $describe)
    {
        $sql = "update $this->_NAMETABLE set $this->_DESCRIBE = '$describe' where $this->_ID = '$id';";
        $this->setQuery($sql);
        $result = $this->query();
        if ($result) {
            return true;
        } 
        return false;
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
}



// $model = new group_category_building();
// $model->insert('xi măng');
?>
