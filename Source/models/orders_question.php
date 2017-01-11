<?php

require_once '../entities/orders_question_entity.php';
require_once '../models/database.php';

class orders_question extends database {
	
	public function insert(orders_question_entity $item)
	{
		$sql = "INSERT INTO `orders_question` (`question_id`, `content`, `enable`)
	            VALUES('{$item->question_id}', '{$item->content}', '{$item->enable}');";
		
		$this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
	}
	
	public function delete($question_id)
	{
	    $sql = "DELETE FROM `orders_question` WHERE `question_id` = '{$question_id}' ;";
	
	    $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
	}
	
	public function update(orders_question_entity $item)
	{
		$sql = "UPDATE `orders_question` SET
	            `question_id` = '{$item->question_id}' , 	            
	            `content` = '{$item->content}' , 
	            `enable` = '{$item->enable}'
	            WHERE `question_id` = '{$item->question_id}' ;";
		
		$this->setQuery($sql);
		$result = $this->query();
		$this->disconnect();
		
		return $result;
	}
	
	public function detail($question_id)
	{
		$sql = "SELECT * FROM `orders_question` WHERE `question_id` = '{$question_id}' ;";
		
		$this->setQuery($sql);
        $result = $this->query();
        $array = mysql_fetch_assoc($result);
        $this->disconnect();
        
        if(is_array($array))
        {
            $item = new orders_question_entity();
            $item->assign($array);
            
            return $item;
        }
        return NULL;
	}
	
	public function get_all($all = FALSE)
	{
		$enable = BIT_TRUE;
		$sql = "SELECT * FROM `orders_question` %s ORDER BY `question_id`; ";
		$sql = sprintf($sql, ($all) ? "" : "WHERE `enable` = '{$enable}'");
	
		$this->setQuery($sql);
		$result = $this->loadAllRow();
		$this->disconnect();
		
		if(is_array($result))
		{
			$list = array();
			foreach ($result as $row)
			{
				$item = new orders_question_entity();
				$item->assign($row);
				
				$list[] = $item;
			}
			
			return $list;
		}
		
		return NULL;
	}
}

/* End of file */