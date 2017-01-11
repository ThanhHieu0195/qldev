<?php
require_once '../entities/guest_favourite_entity.php';
require_once '../models/database.php';
class guest_favourite extends database {
    public function insert(guest_favourite_entity $item) {
        $sql = "INSERT INTO `guest_favourite` 
            	   (`guest_id`, `employee_id`, `uid`)
            	VALUES
            	   ('{$item->guest_id}', '{$item->employee_id}', '{$item->uid}');";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function remove($employee_id, $guest_id) {
        $sql = "DELETE FROM `guest_favourite` WHERE `guest_id` = '{$guest_id}' AND `employee_id` = '{$employee_id}'";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function list_by_guest($guest_id) {
        $sql = "SELECT * FROM `guest_favourite` WHERE `guest_id` = '{$guest_id}'";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        // Initial value
        $list = array ();
        
        if (is_array ( $result )) {
            foreach ( $result as $row ) {
                $item = new guest_favourite_entity ();
                $item->assign ( $row );
                
                $list [] = $item;
            }
        }
        
        return $list;
    }
    public function check_favourite($employee_id, $guest_id) {
        $sql = "SELECT `uid` FROM `guest_favourite` WHERE `guest_id` = '{$guest_id}' AND `employee_id` = '{$employee_id}'";
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        return ((is_array ( $result ) && count ( $result ) > 0));
    }
}

/* End of file */