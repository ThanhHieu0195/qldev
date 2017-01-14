<?php
require_once '../entities/guest_responsibility_entity.php';
require_once '../models/database.php';
class guest_responsibility extends database {
    public function insert(guest_responsibility_entity $item) {
        $sql = "INSERT INTO `guest_responsibility` 
            	   (`guest_id`, `employee_id`, `uid`)
            	VALUES
            	   ('{$item->guest_id}', '{$item->employee_id}', '{$item->uid}');";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function re_assign($guest_id, $employee_id) {
        $sql = "UPDATE `guest_responsibility`
                SET `employee_id` = '{$employee_id}'
                WHERE `guest_id` = '{$guest_id}'";
    
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
    
        return $result;
    }
    public function list_by_guest($guest_id) {
        $sql = "SELECT * FROM `guest_responsibility` WHERE `guest_id` = '{$guest_id}'";
        
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        // Initial value
        $list = array ();
        
        if (is_array ( $result )) {
            foreach ( $result as $row ) {
                $item = new guest_responsibility_entity ();
                $item->assign ( $row );
                
                $list [] = $item;
            }
        }
        
        return $list;
    }
    public function check_responsibility($employee_id, $guest_id) {
        if (verify_access_right ( $employee_id, F_GUEST_DEVELOPMENT_LIST_ALL )) {
            return TRUE;
        }
        
        $sql = "SELECT `uid` FROM `guest_responsibility` WHERE `guest_id` = '{$guest_id}' AND `employee_id` = '{$employee_id}'";
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        return ((is_array ( $result ) && count ( $result ) > 0));
    }

    public function check_res_exists($guest_id) {
               
        $sql = "SELECT `uid` FROM `guest_responsibility` WHERE `guest_id` = '{$guest_id}'";
        $this->setQuery ( $sql );
        $result = $this->loadAllRow ();
        $this->disconnect ();
        
        return ((is_array ( $result ) && count ( $result ) > 0));
    }   

    public function check_res_account($guest_id) {

        $sql = "SELECT `employee_id` FROM `guest_responsibility` WHERE `guest_id` = '{$guest_id}' limit 1";
        $this->setQuery ( $sql );
        $result = $this->query ();
        $row = mysql_fetch_array ( $result );
        $this->disconnect ();

        if (is_array ( $row )) {
            return $row ['employee_id'];
        }

        return "";
    } 

    public function re_assign_all($old_employee_id, $new_employee_id) {
        $sql = "UPDATE `guest_responsibility`
                SET `employee_id` = '{$new_employee_id}'
                WHERE `employee_id` = '{$old_employee_id}'";

        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();

        return $result;
    }

}

/* End of file */
