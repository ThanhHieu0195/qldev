<?php
require_once '../entities/account_role_group_entity.php';
require_once '../models/database.php';
class account_role_group extends database {
    public function insert(account_role_group_entity $item) {
        $sql = "INSERT INTO `account_role_group` (`role_id`, `role_name`, `enable`)
                VALUES('{$item->role_id}', '{$item->role_name}', '{$item->enable}') ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function detail($role_id) {
        $sql = "SELECT * FROM `account_role_group` WHERE `role_id` = '{$role_id}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $array = mysql_fetch_assoc ( $result );
        $this->disconnect ();
        
        if (is_array ( $array )) {
            $item = new account_role_group_entity ();
            $item->assign ( $array );
            
            return $item;
        }
        return NULL;
    }
    public function update(account_role_group_entity $item) {
        $sql = "UPDATE `account_role_group` 
                SET 
                    `role_name` = '{$item->role_name}' , 
                    `enable` = '{$item->enable}' 
                WHERE `role_id` = '{$item->role_id}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function list_role($all = FALSE) {
        $sql = "SELECT * FROM `account_role_group` ";
        if (! $all) {
            $enable = BIT_TRUE;
            $sql .= " WHERE `enable` = '{$enable}'";
        }
        $sql .= " ORDER BY `role_name` ";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        // Initial value
        $list = array ();
        
        if (is_array ( $result )) {
            foreach ( $result as $row ) {
                $item = new account_role_group_entity ();
                $item->assign ( $row );
                
                $list [] = $item;
            }
        }
        
        return $list;
    }
    public function enable($role_id, $enable) {
        if ($role_id == ROLE_ADMIN) {
            return TRUE;
        }
        
        $sql = "UPDATE `account_role_group` SET `enable` = '{$enable}' WHERE `role_id` = '{$role_id}' ;";
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
}

/* End of file */