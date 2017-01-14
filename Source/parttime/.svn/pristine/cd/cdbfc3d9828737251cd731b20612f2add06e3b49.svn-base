<?php
require_once '../entities/account_function_group_entity.php';
require_once '../models/database.php';

class account_function_group extends database {
    public function list_group() {
        $sql = "SELECT * FROM `account_function_group` ORDER BY `no`";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        // Initial value
        $list = array ();
        
        if (is_array ( $result )) {
            foreach ( $result as $row ) {
                $item = new account_function_group_entity ();
                $item->assign ( $row );
                
                $list [] = $item;
            }
        }
        
        return $list;
    }
}

/* End of file */