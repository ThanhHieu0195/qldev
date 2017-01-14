<?php
require_once '../entities/account_function_entity.php';
require_once '../models/database.php';

class account_function extends database {
    public function list_function_of_group($group_id, $all = FALSE) {
        $sql = "SELECT * FROM account_function WHERE group_id = '{$group_id}'";
        if (! $all) {
            $enable = BIT_TRUE;
            $sql .= " AND enable = '{$enable}'";
        }
        $sql .= " ORDER BY function_name ";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        // Initial value
        $list = array ();
        
        if (is_array ( $result )) {
            foreach ( $result as $row ) {
                $item = new account_function_entity ();
                $item->assign ( $row );
                
                $list [] = $item;
            }
        }
        
        return $list;
    }
}

/* End of file */