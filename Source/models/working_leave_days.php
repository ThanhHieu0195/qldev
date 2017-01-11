<?php
require_once '../entities/working_leave_days_entity.php';
require_once '../models/database.php';
class working_leave_days extends database {
    public function insert(working_leave_days_entity $item) {
        if ($item->old_date != NULL) {
            $sql = "INSERT INTO `working_leave_days` (`uid`, `worker`, `old_date`, 
                                                      `new_date`, `note`, `created_by`, `approved`)
                    VALUES('{$item->uid}', '{$item->worker}', '{$item->old_date}', 
                           '{$item->new_date}', '{$item->note}', '{$item->created_by}', '{$item->approved}'); ";
        } else {
            $sql = "INSERT INTO `working_leave_days` (`uid`, `worker`, `old_date`, 
                                                      `new_date`, `note`, `created_by`, `approved`)
                    VALUES('{$item->uid}', '{$item->worker}', NULL, 
                           '{$item->new_date}', '{$item->note}', '{$item->created_by}', '{$item->approved}'); ";
        }
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function update(working_leave_days_entity $item) {
        $sql = "UPDATE `working_leave_days` 
                 SET `uid` = '{$item->uid}' , `worker` = '{$item->worker}' , ";
        if ($item->old_date != NULL) {
            $sql .= "    `old_date` = '{$item->old_date}' , ";
        }
        $sql .= "     `new_date` = '{$item->new_date}' , `note` = '{$item->note}' , `created_by` = '{$item->created_by}' , `approved` = '{$item->approved}'
                 WHERE `uid` = '{$item->uid}'; ";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function delete($uid) {
        $sql = "DELETE FROM `working_leave_days` WHERE `uid` = '{$uid}'; ";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function detail($uid) {
        $sql = "SELECT * FROM `working_leave_days` WHERE `uid` = '{$uid}'; ";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $array = mysql_fetch_assoc ( $result );
        $this->disconnect ();
        
        if (is_array ( $array )) {
            $item = new working_leave_days_entity ();
            $item->assign ( $array );
            
            return $item;
        }
        return NULL;
    }
    public function contains($worker, $new_date, $old_date = NULL) {
        $approved = BIT_FALSE;
        $sql = "SELECT * FROM `working_leave_days` WHERE `approved` = {$approved} AND `worker` = '{$worker}' AND `new_date` = '{$new_date}' ";
        if ($old_date != NULL) {
            $sql .= " AND `old_date` = '{$old_date}'";
        }
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $array = mysql_fetch_assoc ( $result );
        $this->disconnect ();
        
        return is_array ( $array );
    }
    // Dem so luong cac item ngay nghi chua duoc approve
    // Ket qua: 'add' => X, 'change' => Y
    public function unapprove_count() {
        $output = array (
                'add' => -1,
                'change' => -1 
        );
        
        // add
        $approved = BIT_FALSE;
        $sql = "SELECT COUNT(`uid`) AS num FROM `working_leave_days` WHERE (approved = '{$approved}') AND (old_date IS NULL) ;";
        // debug($sql);
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        if (is_array ( $array )) {
            $output ['add'] = $array ['num'];
        }
        
        // change
        $approved = BIT_FALSE;
        $sql = "SELECT COUNT(`uid`) AS num FROM `working_leave_days` WHERE (approved = '{$approved}') AND (old_date IS NOT NULL) ;";
        // debug($sql);
        $this->setQuery ( $sql );
        $array = mysql_fetch_assoc ( $this->query () );
        if (is_array ( $array )) {
            $output ['change'] = $array ['num'];
        }
        
        return ( object ) $output;
    }
}

/* End of file */