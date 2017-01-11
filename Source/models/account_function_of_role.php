<?php
require_once '../entities/account_function_of_role_entity.php';
require_once '../models/database.php';

class account_function_of_role extends database {
    public function insert(account_function_of_role_entity $item) {
        $sql = "INSERT INTO `account_function_of_role` (`role_id`, `function_id`)
                VALUES('{$item->role_id}', '{$item->function_id}') ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function delete_by_role($role_id) {
        $sql = "DELETE FROM `account_function_of_role` WHERE `role_id` = '{$role_id}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function list_role_of_role($role_id, $all = FALSE) {
        $sql = "SELECT r.* 
                FROM account_function_of_role r INNER JOIN account_function f ON r.function_id = f.function_id
                WHERE r.role_id = '{$role_id}' ";
        if (! $all) {
            $enable = BIT_TRUE;
            $sql .= " AND f.enable = '{$enable}'";
        }
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        // Initial value
        $list = array ();
        
        if (is_array ( $result )) {
            foreach ( $result as $row ) {
                $item = new account_function_of_role_entity ();
                $item->assign ( $row );
                
                $list [] = $item;
            }
        }
        
        return $list;
    }
}

/* End of file */