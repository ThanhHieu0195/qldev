<?php
require_once '../entities/employee_group_entity.php';
require_once '../models/database.php';
class employee_group extends database {
    public function insert(employee_group_entity $item) {
        $sql = "INSERT INTO `employee_group` (`group_id`, `group_name`, `enable`)
                VALUES('{$item->group_id}', '{$item->group_name}', '{$item->enable}') ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function detail($group_id) {
        $sql = "SELECT * FROM `employee_group` WHERE `group_id` = '{$group_id}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $array = mysql_fetch_assoc ( $result );
        $this->disconnect ();
        
        if (is_array ( $array )) {
            $item = new employee_group_entity ();
            $item->assign ( $array );
            
            return $item;
        }
        return NULL;
    }
    public function update(employee_group_entity $item) {
        $sql = "UPDATE `employee_group` 
                SET 
                    `group_name` = '{$item->group_name}' , 
                    `enable` = '{$item->enable}' 
                WHERE `group_id` = '{$item->group_id}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function list_group($all = FALSE) {
        $sql = "SELECT * FROM `employee_group` ";
        if (! $all) {
            $enable = BIT_TRUE;
            $sql .= " WHERE `enable` = '{$enable}'";
        }
        $sql .= " ORDER BY `group_name` ";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        // Initial value
        $list = array ();
        
        if (is_array ( $result )) {
            foreach ( $result as $row ) {
                $item = new employee_group_entity ();
                $item->assign ( $row );
                
                $list [] = $item;
            }
        }
        
        return $list;
    }
}

/* End of file */