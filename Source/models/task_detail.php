<?php

require_once '../entities/task_detail_entity.php';
require_once '../models/database.php';

class task_detail extends database {
	
	public function insert(task_detail_entity $item)
	{
		$sql = "INSERT INTO `task_detail` (`uid`, `task_id`, `no`, `content`, `checked`)
                VALUES('{$item->uid}', '{$item->task_id}', '{$item->no}', '{$item->content}', '{$item->checked}');";
		
		$this->setQuery($sql);
		$result = $this->query();
		$this->disconnect();
		
		return $result;
	}
	
	public function update(task_detail_entity $item, $all = FALSE)
	{
		if($all)
		{
			$sql = "UPDATE `task_detail` 
	                SET `uid` = '{$item->uid}' , `task_id` = '{$item->task_id}' , `no` = '{$item->no}' , 
					    `content` = '{$item->content}' , `checked` = '{$item->checked}'
	                WHERE `uid` = '{$item->uid}' ;";
		}
		else
		{
			$sql = "UPDATE `task_detail`
					SET `checked` = '{$item->checked}'
					WHERE `uid` = '{$item->uid}' ;";
		}
		
		$this->setQuery($sql);
		$result = $this->query();
		$this->disconnect();
		
		return $result;
	}
    
    public function delete_by_task($task_id)
	{
	    $sql = "DELETE FROM `task_detail` WHERE `task_id` = '{$task_id}' ;";
	
	    $this->setQuery($sql);
	    $result = $this->query();
	    $this->disconnect();
	
	    return $result;
	}
	
	public function detail_list($task_id)
	{
		$sql = "SELECT * FROM task_detail WHERE `task_id` = '{$task_id}' ;";
		
		$this->setQuery($sql);
		$result = $this->loadAllRow();
		$this->disconnect();
		
		if(is_array($result))
		{
			$list = array();
			foreach ($result as $row)
			{
				$item = new task_detail_entity();
				$item->assign($row);
				
				$list[] = $item;
			}
			
			return $list;
		}
		
		return NULL;
	}
	
}

/* End of file */