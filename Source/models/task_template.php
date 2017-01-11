<?php

require_once '../entities/task_template_entity.php';
require_once '../models/database.php';
require_once '../models/task_template_detail.php';

class task_template extends database {
	
	public function insert(task_template_entity $item)
	{
		$sql = "INSERT INTO `task_template` (`template_id`, `title`, `content`, `has_detail`)
	            VALUES('{$item->template_id}', '{$item->title}', '{$item->content}', '{$item->has_detail}');";
		
		$this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
	}
	
	public function delete($template_id)
	{
	    $sql = "DELETE FROM `task_template` WHERE `template_id` = '{$template_id}' ;";
	
	    $this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
	}
	
	public function update(task_template_entity $item)
	{
		$sql = "UPDATE `task_template` SET
	            `template_id` = '{$item->template_id}' , `title` = '{$item->title}' , `content` = '{$item->content}' , `has_detail` = '{$item->has_detail}'
	            WHERE `template_id` = '{$item->template_id}' ;";
		
		$this->setQuery($sql);
		$result = $this->query();
		$this->disconnect();
		
		return $result;
	}
	
	public function detail($template_id)
	{
		$sql = "SELECT * FROM `task_template` WHERE `template_id` = '{$template_id}' ;";
		
		$this->setQuery($sql);
        $result = $this->query();
        $array = mysql_fetch_assoc($result);
        $this->disconnect();
        
        if(is_array($array))
        {
            $item = new task_template_entity();
            $item->assign($array);
            
            return $item;
        }
        return NULL;
	}
	
	public function get_all()
	{
		$sql = "SELECT * FROM `task_template` ;";
	
		$this->setQuery($sql);
		$result = $this->loadAllRow();
		$this->disconnect();
		
		if(is_array($result))
		{
			$list = array();
			foreach ($result as $row)
			{
				$item = new task_template_entity();
				$item->assign($row);
				
				$list[] = $item;
			}
			
			return $list;
		}
		
		return NULL;
	}
	
	// Tim kiem theo tham so truyen vao
	function get_top($term, $limit)
	{
	    // Ket qua default (khong tim thay)
	    $output = array( 'title' => '',
	                     'content' => '',
	                     'has_detail' => 0,
	                     'detail' => ''
	    );
	
	    // Danh sach cac cot tim kiem trong bang 'task_template'
	    $columns = array( 'title', 'content');
	
	    // Tao cau lenh SQL dung de tim kiem
	    $where = "";
	    if ( isset($term) && $term != "" )
	    {
	        $where = "WHERE (";
	        for ( $i=0, $len = count($columns); $i<$len ; $i++ )
	        {
	            $where .= $columns[$i] . " LIKE '%" . $term . "%' OR ";
	        }
	        $where = substr_replace( $where, "", -3 );
	        $where .= ')';
	    }
	
	    $order = "ORDER BY title ASC";
	
	    $limit = "LIMIT " . $limit;
	
	    $sql = "
	    SELECT template_id, title, content, has_detail
	    FROM task_template
	    $where
	    $order
	    $limit
	    ";
	
	    // Lay du lieu tu database
	    $this->setQuery($sql);
	    $array = $this->loadAllRow();
	    $this->disconnect();
	
	    if(is_array($array))
	    {
	        //debug($array);
	        $model = new task_template_detail();
    	    $output = array();
    	    
    	    foreach($array as $row)
    	    {
    	        if($row['has_detail'] == BIT_TRUE) {
    	            $detail = '';
    	            $arr = $model->detail_list($row['template_id']);
    	            foreach ($arr as $item)
    	            {
    	                $format = "%s\n";
    	                $detail .= sprintf($format, $item->content);
    	            }
    	        }
    	        else {
    	            $detail = '';
    	        }
    	        
        	    array_push($output, array( 'title' => $row['title'],
        	                               'content' => $row['content'],
        	                               'has_detail' => $row['has_detail'],
        	                               'detail' => $detail));
    	    }
	    }
	
	    return json_encode($output);
	}
}

/* End of file */