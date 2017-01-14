<?php
require_once '../entities/default_users_entity.php';
require_once '../models/database.php';
class default_users extends database {
    public function insert(default_users_entity $item) {
        $sql = "INSERT INTO `default_users` (`account_id`, `password`, `enable`)
                VALUES('{$item->account_id}', '{$item->password}', '{$item->enable}') ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function detail($account_id) {
        $sql = "SELECT * FROM `default_users` WHERE `account_id` = '{$account_id}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $array = mysql_fetch_assoc ( $result );
        $this->disconnect ();
        
        if (is_array ( $array )) {
            $item = new default_users_entity ();
            $item->assign ( $array );
            
            return $item;
        }
        return NULL;
    }
    public function update(default_users_entity $item) {
        $sql = "UPDATE `default_users` 
                SET 
                    `password` = '{$item->password}' , 
                    `enable` = '{$item->enable}' 
                WHERE `account_id` = '{$item->account_id}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function list_users($all = FALSE) {
        $sql = "SELECT * FROM `default_users` ";
        if (! $all) {
            $enable = BIT_TRUE;
            $sql .= " WHERE `enable` = '{$enable}'";
        }
        $sql .= " ORDER BY `account_id` ";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        // Initial value
        $list = array ();
        
        if (is_array ( $result )) {
            foreach ( $result as $row ) {
                $item = new default_users_entity ();
                $item->assign ( $row );
                
                $list [] = $item;
            }
        }
        
        return $list;
    }
}

/* End of file */