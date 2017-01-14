<?php

require_once '../entities/orders_question_option_entity.php';
require_once '../models/database.php';

class orders_question_option extends database {
	
	public function insert(orders_question_option_entity $item)
	{
		$sql = "INSERT INTO `orders_question_option` (`uid`, `question_id`, `no`, `content`)
                VALUES('{$item->uid}', '{$item->question_id}', '{$item->no}', '{$item->content}');";
		
		$this->setQuery($sql);
		$result = $this->query();
		$this->disconnect();
		
		return $result;
	}
	
	public function update(orders_question_option_entity $item)
	{
		$sql = "UPDATE `orders_question_option` 
                SET `uid` = '{$item->uid}' , `question_id` = '{$item->question_id}' , `no` = '{$item->no}' , 
				    `content` = '{$item->content}'
                WHERE `uid` = '{$item->uid}' ;";
		
		$this->setQuery($sql);
		$result = $this->query();
		$this->disconnect();
		
		return $result;
	}
	
	public function delete_by_question($question_id)
	{
	    $sql = "DELETE FROM `orders_question_option` WHERE `question_id` = '{$question_id}' ;";
	
	    $this->setQuery($sql);
	    $result = $this->query();
	    $this->disconnect();
	
	    return $result;
	}
	
	public function option_list($question_id)
	{
		$sql = "SELECT * FROM orders_question_option WHERE `question_id` = '{$question_id}' ;";
		//echo $sql;
		
		$this->setQuery($sql);
		$result = $this->loadAllRow();
		$this->disconnect();
		
		if(is_array($result))
		{
			$list = array();
			foreach ($result as $row)
			{
				$item = new orders_question_option_entity();
				$item->assign($row);
				
				$list[] = $item;
			}
			
			return $list;
		}
		
		return NULL;
	}
	
}

/* End of file */