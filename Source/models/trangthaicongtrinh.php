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

class status_building extends database {
    public $_NAMETABLE = 'trangthaicongtrinh';

    public $_ID = 'id';
    public $_DESCRIBE = 'mota';

    public function getall() {
        $sql = "select * from $this->_NAMETABLE;";
        $this->setQuery($sql);
        $result = $this->query();
        $arr = array();
        while ( $row = mysql_fetch_array($result) ) {
            $arr[] = $row;
        } 
        return $arr;
    }

    public function getupper($upper) {
        $upper = $upper + 1;
        $sql = "select mota from $this->_NAMETABLE where id={$upper} limit 1;";
        error_log ("Add new " . $sql, 3, '/var/log/phpdebug.log');
        $this->setQuery($sql);
        $result = $this->query();
        $row = mysql_fetch_array ( $result );
        $this->disconnect ();

        if (is_array ( $row )) {
            return $row ['mota'];
        }
        return "";
    }

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
}
// $model = new status_building();
// $model->insert('TC-03');
?>
