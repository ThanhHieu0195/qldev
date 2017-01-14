<?php

require_once '../entities/task_template_detail_entity.php';
require_once '../models/database.php';

class task_template_detail extends database {
	
	public function insert(task_template_detail_entity $item)
	{
		$sql = "INSERT INTO `task_template_detail` (`uid`, `template_id`, `no`, `content`)
                VALUES('{$item->uid}', '{$item->template_id}', '{$item->no}', '{$item->content}');";
		
		$this->setQuery($sql);
		$result = $this->query();
		$this->disconnect();
		
		return $result;
	}
	
	public function update(task_template_detail_entity $item)
	{
		$sql = "UPDATE `task_template_detail` 
                SET `uid` = '{$item->uid}' , `template_id` = '{$item->template_id}' , `no` = '{$item->no}' , 
				    `content` = '{$item->content}'
                WHERE `uid` = '{$item->uid}' ;";
		
		$this->setQuery($sql);
		$result = $this->query();
		$this->disconnect();
		
		return $result;
	}
	
	public function delete_by_template($template_id)
	{
	    $sql = "DELETE FROM `task_template_detail` WHERE `template_id` = '{$template_id}' ;";
	
	    $this->setQuery($sql);
	    $result = $this->query();
	    $this->disconnect();
	
	    return $result;
	}
	
	public function detail_list($template_id)
	{
		$sql = "SELECT * FROM task_template_detail WHERE `template_id` = '{$template_id}' ;";
		//echo $sql;
		
		$this->setQuery($sql);
		$result = $this->loadAllRow();
		$this->disconnect();
		
		if(is_array($result))
		{
			$list = array();
			foreach ($result as $row)
			{
				$item = new task_template_detail_entity();
				$item->assign($row);
				
				$list[] = $item;
			}
			
			return $list;
		}
		
		return NULL;
	}
	
}

/* End of file */