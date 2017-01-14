<?php

require_once '../entities/task_result_item_entity.php';
require_once '../models/database.php';

class task_result_item extends database {
	
	public function insert(task_result_item_entity $item)
	{
		$sql = "INSERT INTO `task_result_item` (`item_id`, `category_id`, `item_name`)
	            VALUES('{$item->item_id}', '{$item->category_id}', '{$item->item_name}');";
		
		$this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
	}
	
	public function update(task_result_item_entity $item)
	{
		$sql = "UPDATE `task_result_item` SET
		            `item_id` = '{$item->item_id}' , `category_id` = '{$item->category_id}', 
		            `item_name` = '{$item->item_name}'
		            WHERE `item_id` = '{$item->item_id}' ;";
		
		$this->setQuery($sql);
		$result = $this->query();
		$this->disconnect();
		
		return $result;
	}
	
	public function detail_list($category_id)
	{
		$sql = "select i.*, c.category_name
                from task_result_item i Inner join task_result_category c on i.category_id = c.category_id
                where i.category_id = '{$category_id}'";
		
		$this->setQuery($sql);
		$result = $this->loadAllRow();
		$this->disconnect();
		
		if(is_array($result))
		{
			$list = array();
			foreach ($result as $row)
			{
				$item = new task_result_item_entity();
				$item->assign($row);
				
				$list[] = $item;
			}
			
			return $list;
		}
		
		return NULL;
	}
}

/* End of file */