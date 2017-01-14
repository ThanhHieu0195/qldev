<?php
require_once '../entities/employee_group_members_entity.php';
require_once '../models/database.php';
class employee_group_members extends database {
    public function insert(employee_group_members_entity $item) {
        $sql = "INSERT INTO `employee_group_members` (`group_id`, `employee_id`)
                VALUES('{$item->group_id}', '{$item->employee_id}') ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function delete_by_group($group_id) {
        $sql = "DELETE FROM `employee_group_members` WHERE `group_id` = '{$group_id}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function list_members_of_group($group_id, $all_info = FALSE) {
        $sql = "SELECT m.*, e.hoten
                FROM employee_group_members m INNER JOIN nhanvien e ON m.employee_id = e.manv
                WHERE m.group_id = '{$group_id}' 
                ORDER BY e.hoten ";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        // Initial value
        $list = array ('employee_id' => array(), 'employee_name' => array());
        
        if (is_array ( $result )) {
            foreach ( $result as $row ) {
                $list['employee_id'][] = $row ['employee_id'];
                if ($all_info) {
                    $list['employee_name'][] = $row ['hoten'];
                }
            }
        }
        
        return $list;
    }
}

/* End of file */