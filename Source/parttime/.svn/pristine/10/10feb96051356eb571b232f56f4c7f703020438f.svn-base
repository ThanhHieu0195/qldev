<?php

require_once '../entities/task_result_category_entity.php';
require_once '../models/database.php';

class task_result_category extends database {
	
	public function insert(task_result_category_entity $item)
	{
		$sql = "INSERT INTO `task_result_category` (`category_id`, `category_name`)
	            VALUES('{$item->category_id}', '{$item->category_name}');";
		
		$this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
	}
	
	public function update(task_result_category_entity $item)
	{
		$sql = "UPDATE `task_result_category` SET
	            `category_id` = '{$item->category_id}' , `category_name` = '{$item->category_name}'
	            WHERE `category_id` = '{$item->category_id}' ;";
		
		$this->setQuery($sql);
		$result = $this->query();
		$this->disconnect();
		
		return $result;
	}
	
	public function detail($category_id)
	{
		$sql = "SELECT * FROM `task_result_category` WHERE `category_id` = '{$category_id}' ;";
		
		$this->setQuery($sql);
        $result = $this->query();
        $array = mysql_fetch_assoc($result);
        $this->disconnect();
        
        if(is_array($array))
        {
            $item = new task_result_category_entity();
            $item->assign($array);
            
            return $item;
        }
        return NULL;
	}
	
	public function get_all()
	{
		$sql = "SELECT * FROM `task_result_category` ;";
	
		$this->setQuery($sql);
		$result = $this->loadAllRow();
		$this->disconnect();
		
		if(is_array($result))
		{
			$list = array();
			foreach ($result as $row)
			{
				$item = new task_result_category_entity();
				$item->assign($row);
				
				$list[] = $item;
			}
			
			return $list;
		}
		
		return NULL;
	}
}

/* End of file */