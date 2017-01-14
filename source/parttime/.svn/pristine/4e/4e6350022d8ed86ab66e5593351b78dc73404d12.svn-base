<?php
require_once '../entities/default_users_stores_entity.php';
require_once '../models/database.php';
class default_users_stores extends database {
    public function insert(default_users_stores_entity $item) {
        $sql = "INSERT INTO `default_users_stores` (`account_id`, `store_id`)
                VALUES('{$item->account_id}', '{$item->store_id}') ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function delete_by_account($account_id) {
        $sql = "DELETE FROM `default_users_stores` WHERE `account_id` = '{$account_id}' ;";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function list_stores_by_account($account_id, $all_info = FALSE) {
        $sql = "SELECT m.store_id, s.tenkho
                FROM default_users_stores m INNER JOIN khohang s ON m.store_id = s.makho
                WHERE m.account_id = '{$account_id}' 
                ORDER BY s.tenkho ";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        // Initial value
        $list = array ('store_id' => array(), 'store_name' => array());
        
        if (is_array ( $result )) {
            foreach ( $result as $row ) {
                $list['store_id'][] = $row ['store_id'];
                if ($all_info) {
                    $list['store_name'][] = $row ['tenkho'];
                }
            }
        }
        
        return $list;
    }
}

/* End of file */