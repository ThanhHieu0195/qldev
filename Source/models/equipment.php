<?php

require_once '../entities/equipment_entity.php';
require_once '../models/database.php';

class equipment extends database {
    
    // Validate item
    // Ket qua tra ve ('result' => X, 'message' => Y)
    public static function validate_item(equipment_entity $item)
    {
        $result = TRUE;
        $message = '';
    
        // Check 'equipment_id': chi cho phep cac ky tu 0-9, a-z, A-Z, _
        //if(!isset($masotranh) || empty($masotranh) || !ctype_alnum($masotranh) || strlen($masotranh) == 0)
        if(!isset($item->equipment_id) || empty($item->equipment_id) || !is_valid_uid($item->equipment_id))
        {
            $result = FALSE;
            $message .= 'Mã dụng cụ chỉ cho phép chứa các ký tự: ' . VALIDATE_UID . '.';
        }
    
        $output = array('result' => $result, 'message' => $message);
        return (object) $output;
    }
	
	public function insert(equipment_entity $item)
	{
		$sql = "INSERT INTO `equipment` (`equipment_id`, `name`, `status`, `stored_in`, `assign_to`, `assign_date`, `enable`)
	            VALUES('{$item->equipment_id}', '{$item->name}', '{$item->status}', '{$item->stored_in}', 
		               '{$item->assign_to}', '{$item->assign_date}', '{$item->enable}');";
		
		$this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
	}
    
    public function update(equipment_entity $item)
	{
		$sql = "UPDATE `equipment` 
                SET `equipment_id` = '{$item->equipment_id}' , `name` = '{$item->name}' , `status` = '{$item->status}' , 
                    `stored_in` = '{$item->stored_in}' , `assign_to` = '{$item->assign_to}' , `assign_date` = '{$item->assign_date}' , 
                    `enable` = '{$item->enable}'
                WHERE `equipment_id` = '{$item->equipment_id}' ;";
		
		$this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
	}
    
    public function detail($equipment_id)
	{
		$sql = "SELECT * FROM `equipment` WHERE `equipment_id` = '{$equipment_id}' ;";
		
		$this->setQuery($sql);
        $result = $this->query();
        $array = mysql_fetch_assoc($result);
        $this->disconnect();
        
        if(is_array($array))
        {
            $item = new equipment_entity();
            $item->assign($array);
            
            return $item;
        }
        return NULL;
	}
	
	public function re_assign($equipment_id, $stored_in, $assign_to)
	{
	    if ($stored_in != NULL && $assign_to != NULL) {
    		$sql = "UPDATE `equipment` SET
    	            `stored_in` = '{$stored_in}' , 
                    `assign_to` = '{$assign_to}' 
    	            WHERE `equipment_id` = '{$equipment_id}' ;";
	    } else {
	        if ($stored_in != NULL) {
	            $sql = "UPDATE `equipment` SET `stored_in` = '{$stored_in}' WHERE `equipment_id` = '{$equipment_id}' ;";
	        } else if ($assign_to != NULL) {
	            $sql = "UPDATE `equipment` SET `assign_to` = '{$assign_to}' WHERE `equipment_id` = '{$equipment_id}' ;";
	        }
	    }
		
		$this->setQuery($sql);
		$result = $this->query();
		$this->disconnect();
		
		return $result;
	}
}

/* End of file */