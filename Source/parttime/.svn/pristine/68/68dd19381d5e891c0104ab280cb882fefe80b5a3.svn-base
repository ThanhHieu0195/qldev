<?php

require_once '../entities/task_result_rate_entity.php';
require_once '../models/database.php';

class task_result_rate extends database {
	
	public function insert(task_result_rate_entity $item)
	{
		$sql = "INSERT INTO `task_result_rate` (`uid`, `item_id`, `manv`, `rate`)
	            VALUES('{$item->uid}', '{$item->item_id}', '{$item->manv}', '{$item->rate}');";
		
		$this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
	}
	
	public function update(task_result_rate_entity $item, $all = FALSE)
	{
		if($all)
		{
			$sql = "UPDATE `task_result_rate` SET
		            `uid` = '{$item->uid}' , `item_id` = '{$item->item_id}', 
		            `manv` = '{$item->manv}' , `rate` = '{$item->rate}'
		            WHERE `item_id` = '{$item->item_id}' ;";
		}
		else
		{
			$sql = "UPDATE `task_result_rate` SET `rate` = '{$item->rate}'
			WHERE `item_id` = '{$item->item_id}' AND `manv` = '{$item->manv}';";
		}
		
		$this->setQuery($sql);
		$result = $this->query();
		$this->disconnect();
		
		return $result;
	}
	
	public function detail_list($category_id, $manv)
	{
		$sql = "SELECT r.*, i.item_name
                FROM task_result_rate r INNER JOIN task_result_item i on r.item_id = i.item_id
                where r.manv = '{$manv}' AND i.category_id = '{$category_id}'";
		
		$this->setQuery($sql);
		$result = $this->loadAllRow();
		$this->disconnect();
		
		if(is_array($result))
		{
			$list = array();
			foreach ($result as $row)
			{
				$item = new task_result_rate_entity();
				$item->assign($row);
				
				$list[] = $item;
			}
			
			return $list;
		}
		
		return NULL;
	}
}

/* End of file */