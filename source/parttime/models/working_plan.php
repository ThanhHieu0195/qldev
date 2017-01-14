<?php
require_once '../entities/working_plan_entity.php';
require_once '../models/database.php';
class working_plan extends database {
    public function insert(working_plan_entity $item) {
        if (! is_array ( $item->branches )) {
            $branches = $item->branches;
        } else {
            $branches = implode ( ARRAY_DELIMITER, $item->branches );
        }
        
        $sql = "INSERT INTO `working_plan` (`plan_uid`, `branches`, `from_date`, `to_date`, 
                                            `created_by`, `created_date`, `approved`)
                VALUES('{$item->plan_uid}', '{$branches}', '{$item->from_date}', '{$item->to_date}', 
                       '{$item->created_by}', '{$item->created_date}', '{$item->approved}');";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function update(working_plan_entity $item) {
        if (! is_array ( $item->branches )) {
            $branches = $item->branches;
        } else {
            $branches = implode ( ARRAY_DELIMITER, $item->branches );
        }
        
        $sql = "UPDATE `working_plan` 
                SET `plan_uid` = '{$item->plan_uid}' , `branches` = '{$branches}' , `from_date` = '{$item->from_date}' , `to_date` = '{$item->to_date}' , 
                    `created_by` = '{$item->created_by}', `created_date` = '{$item->created_date}' , `approved` = '{$item->approved}'
                WHERE `plan_uid` = '{$item->plan_uid}' ; ";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function delete($plan_uid) {
        $sql = "DELETE FROM `working_plan` WHERE `plan_uid` = '{$plan_uid}'; ";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
    public function detail($plan_uid) {
        $sql = "SELECT * FROM `working_plan` WHERE `plan_uid` = '{$plan_uid}'; ";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $array = mysql_fetch_assoc ( $result );
        $this->disconnect ();
        
        if (is_array ( $array )) {
            $item = new working_plan_entity ();
            $item->assign ( $array );
            
            $item->branches = explode ( ARRAY_DELIMITER, $item->branches );
            if (! is_array ( $item->branches )) {
                return NULL;
            }
            
            return $item;
        }
        return NULL;
    }
    public function delete_empty_plans() {
        $sql = "DELETE FROM working_plan WHERE plan_uid NOT IN (SELECT DISTINCT plan_uid FROM working_calendar) ; ";
        
        $this->setQuery ( $sql );
        $result = $this->query ();
        $this->disconnect ();
        
        return $result;
    }
}

/* End of file */