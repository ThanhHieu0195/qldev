<?php

require_once '../entities/orders_question_result_entity.php';
require_once '../models/database.php';

class orders_question_result extends database {
	
	public function insert(orders_question_result_entity $item)
	{
		$sql = "INSERT INTO `orders_question_result` (`order_id`, `question_id`, `option`, `note`)
                VALUES('{$item->order_id}', '{$item->question_id}', '{$item->option}', '{$item->note}');";
		
		$this->setQuery($sql);
		$result = $this->query();
		$this->disconnect();
		
		return $result;
	}

	public function result($order_id, $question_id)
	{
		$sql = "SELECT * FROM orders_question_result WHERE `order_id` = '{$order_id}' AND `question_id` = '{$question_id}' ;";
		//echo $sql;

		$this->setQuery($sql);
        $result = $this->query();
        $array = mysql_fetch_assoc($result);
        $this->disconnect();
        
        if(is_array($array))
        {
            $item = new orders_question_result_entity();
            $item->assign($array);
            
            return $item;
        }

        return new orders_question_result_entity();
	}
	
	public function results_list($question_id)
	{
		$sql = "SELECT * FROM orders_question_result WHERE `question_id` = '{$question_id}' ;";
		//echo $sql;
		
		$this->setQuery($sql);
		$result = $this->loadAllRow();
		$this->disconnect();
		
		if(is_array($result))
		{
			$list = array();
			foreach ($result as $row)
			{
				$item = new orders_question_result_entity();
				$item->assign($row);
				
				$list[] = $item;
			}
			
			return $list;
		}
		
		return NULL;
	}

        public function dashboard_cskh($nam=NULL, $thang=NULL)
        {
                $condition = " 1 ";
                if (isset($nam)) {
                    $condition = $condition . "and (YEAR(donhang.ngaydat) = '{$nam}') ";
                } 
                if (isset($thang)) {
                    $condition = $condition . "and (MONTH(donhang.ngaydat) = '{$thang}') ";
                }
                
                $sql = "select orders_question.content as question, orders_question_option.content as answer, 
                        count(`option`) as sum, MONTH(donhang.ngaydat) as thang, YEAR(donhang.ngaydat) as nam 
                        from orders_question_result LEFT JOIN donhang ON donhang.madon = orders_question_result.order_id 
                        LEFT JOIN orders_question ON orders_question.question_id = orders_question_result.question_id 
                        LEFT JOIN orders_question_option ON orders_question_option.uid = orders_question_result.option  
                        where $condition 
                        group by question, answer, thang, nam ORDER BY donhang.ngaydat;";

                $this->setQuery($sql);
                $result = $this->loadAllRow();
                $this->disconnect();
                if(is_array($result))
                {
                    $i=1;
                    foreach ( $result as $row ) {
                        $items [] = array (
                                'no' => ++ $i,
                                'question' => $row ['question'],
                                'answer' => $row ['answer'],
                                'total' => $row ['sum'],
                                'month' => $row ['thang'],
                                'year' => $row ['nam'],
                        );
                    }
                    
                   return $items;
                }
                return NULL;
        }
	
}

/* End of file */
