<?php
require_once '../entities/account_role_of_employee_entity.php';
require_once '../models/database.php';

class account_role_of_employee extends database {
    public function insert(account_role_of_employee_entity $item) {
        $sql = "INSERT INTO `account_role_of_employee` (`employee_id`, `role_id`)
                VALUES('{$item->employee_id}', '{$item->role_id}') ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function delete_by_account($account) {
        $sql = "DELETE FROM `account_role_of_employee` WHERE `employee_id` = '{$account}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function list_role_of_account($account, $all = FALSE) {
        $sql = "SELECT r.* FROM `account_role_of_employee` r INNER JOIN account_role_group a ON r.role_id = a.role_id 
                WHERE r.`employee_id` = '{$account}' ";
        if (! $all) {
            $enable = BIT_TRUE;
            $sql .= " AND a.enable = '{$enable}'";
        }
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        // Initial value
        $list = array ();
        
        if (is_array ( $result )) {
            foreach ( $result as $row ) {
                $item = new account_role_of_employee_entity ();
                $item->assign ( $row );
                
                $list [] = $item;
            }
        }
        
        return $list;
    }
}

/* End of file */