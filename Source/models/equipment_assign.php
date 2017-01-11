<?php

require_once '../entities/equipment_assign_entity.php';
require_once '../models/database.php';

class equipment_assign extends database {
	
	public function insert(equipment_assign_entity $item)
	{
		$sql = "INSERT INTO `equipment_assign` (`uid`, `equipment_id`, `stored_in_old`, `assign_to_old`, 
                            `stored_in_new`, `assign_to_new`, `assign_date`, `assign_by`, `status`)
	            VALUES('{$item->uid}', '{$item->equipment_id}', '{$item->stored_in_old}', '{$item->assign_to_old}', 
		               '{$item->stored_in_new}', '{$item->assign_to_new}', '{$item->assign_date}', 
                       '{$item->assign_by}', '{$item->status}'); ";
		//debug($sql);
		$this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
	}
    
    public function update(equipment_assign_entity $item)
	{
		$sql = "UPDATE `equipment_assign` 
                SET
                `uid` = '{$item->uid}' , 
                `equipment_id` = '{$item->equipment_id}' , 
                `stored_in_old` = '{$item->stored_in_old}' , 
                `assign_to_old` = '{$item->assign_to_old}' , 
                `stored_in_new` = '{$item->stored_in_new}' , 
                `assign_to_new` = '{$item->assign_to_new}' , 
                `assign_date` = '{$item->assign_date}' , 
                `assign_by` = '{$item->assign_by}' , 
                `status` = '{$item->status}'
                WHERE `uid` = '{$item->uid}' ;";
		
		$this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
	}
    
    public function detail($uid)
	{
		$sql = "SELECT * FROM `equipment_assign` WHERE `uid` = '{$uid}' ;";
		
		$this->setQuery($sql);
        $result = $this->query();
        $array = mysql_fetch_assoc($result);
        $this->disconnect();
        
        if(is_array($array))
        {
            $item = new equipment_assign_entity();
            $item->assign($array);
            
            return $item;
        }
        return NULL;
	}
}

/* End of file */