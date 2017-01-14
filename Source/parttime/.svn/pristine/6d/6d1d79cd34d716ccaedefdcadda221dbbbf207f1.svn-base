<?php

require_once '../entities/task_entity.php';
require_once '../models/database.php';
require_once '../models/task_detail.php';
require_once '../models/task_result.php';

class task extends database {
	
	public function insert(task_entity $item)
	{
		$sql = "INSERT INTO `task` (`task_id`, `title`, `content`, `has_detail`, `created_by`, 
	                        `assign_to`, `created_date`, `deadline`, `is_finished`, 
                            `finished_date`, `attachment`, `status`, `rank`, `comment`, `checked`, `template_id`)
	            VALUES('{$item->task_id}', '{$item->title}', '{$item->content}', '{$item->has_detail}', '{$item->created_by}', 
	                   '{$item->assign_to}', '{$item->created_date}', '{$item->deadline}', '{$item->is_finished}', 
	                   '{$item->finished_date}', '{$item->attachment}', '{$item->status}', '{$item->rank}', '{$item->comment}', '{$item->checked}', '{$item->template_id}');";
		
		$this->setQuery($sql);
        $result = $this->query();
        $this->disconnect();
    
        return $result;
	}
	
	public function update(task_entity $item)
	{
		$sql = "UPDATE `task` SET
	            `task_id` = '{$item->task_id}' , `title` = '{$item->title}' , `content` = '{$item->content}' , `has_detail` = '{$item->has_detail}' , 
	            `created_by` = '{$item->created_by}' , `assign_to` = '{$item->assign_to}' , `created_date` = '{$item->created_date}' , `deadline` = '{$item->deadline}' , 
	            `is_finished` = '{$item->is_finished}' , `finished_date` = '{$item->finished_date}' , `attachment` = '{$item->attachment}' , `status` = '{$item->status}' , 
	            `rank` = '{$item->rank}' , `comment` = '{$item->comment}' , `checked` = '{$item->checked}' , `template_id` = '{$item->template_id}'
	            WHERE `task_id` = '{$item->task_id}' ;";
		
		$this->setQuery($sql);
		$result = $this->query();
		$this->disconnect();
		
		return $result;
	}
	
	public function detail($task_id)
	{
		$sql = "SELECT * FROM `task` WHERE `task_id` = '{$task_id}' ;";
		
		$this->setQuery($sql);
        $result = $this->query();
        $array = mysql_fetch_assoc($result);
        $this->disconnect();
        
        if(is_array($array))
        {
            $item = new task_entity();
            $item->assign($array);
            
            return $item;
        }
        return NULL;
	}
	
	public function unfinished_list_by_template($template_id)
	{
	    $is_finished = BIT_FALSE;
	    $sql = "SELECT * FROM `task` WHERE is_finished = '{$is_finished}' AND `template_id` = '{$template_id}' ;";
	    //echo $sql;
	
	    $this->setQuery($sql);
	    $result = $this->loadAllRow();
	    $this->disconnect();
	
	    if(is_array($result))
	    {
	        $list = array();
	        foreach ($result as $row)
	        {
	            $item = new task_entity();
	            $item->assign($row);
	
	            $list[] = $item;
	        }
	        	
	        return $list;
	    }
	
	    return NULL;
	}
	
	public function refresh_status($task_id = NULL)
	{
	    // Update new
	    $is_finished = BIT_FALSE;
	    $status = TASK_STATUS_NEW;
	    $sql = "UPDATE `task` set `status` = {$status} WHERE is_finished = {$is_finished} AND DATEDIFF(deadline, CURDATE()) >= 0";
	    
	    if($task_id != NULL) {
	        $sql .= " AND task_id = '{$task_id}'";
	    }
	    
	    $this->setQuery($sql);
	    $this->query();
	    
	    // Update expired
	    $is_finished = BIT_FALSE;
	    $status = TASK_STATUS_EXPIRED;
	    $sql = "UPDATE `task` set `status` = {$status} WHERE is_finished = {$is_finished} AND DATEDIFF(deadline, CURDATE()) < 0";
	     
	    if($task_id != NULL) {
	        $sql .= " AND task_id = '{$task_id}'";
	    }
	     
	    $this->setQuery($sql);
	    $this->query();
	    
	    // Update finished
	    $is_finished = BIT_TRUE;
	    $status = TASK_STATUS_FINISHED;
	    $sql = "UPDATE `task` set `status` = {$status} WHERE is_finished = {$is_finished} AND DATEDIFF(deadline, finished_date) >= 0";
	     
	    if($task_id != NULL) {
	        $sql .= " AND task_id = '{$task_id}'";
	    }
	    
	    $this->setQuery($sql);
	    $this->query();
	    
	    // Update finished late
	    $is_finished = BIT_TRUE;
	    $status = TASK_STATUS_FINISHED_LATE;
	    $sql = "UPDATE `task` set `status` = {$status} WHERE is_finished = {$is_finished} AND DATEDIFF(deadline, finished_date) < 0";
	    
	    if($task_id != NULL) {
	        $sql .= " AND task_id = '{$task_id}'";
	    }
	    
	    $this->setQuery($sql);
	    $this->query();
	}
	
	public static function status_name($status) {
	    switch ($status) {
	    	case TASK_STATUS_NEW: return 'Mới';
	    	case TASK_STATUS_EXPIRED: return 'Quá hạn';
	    	case TASK_STATUS_FINISHED: return 'Hoàn thành đúng hạn';
	    	case TASK_STATUS_FINISHED_LATE: return 'Hoàn thành quá hạn';
	    }
	    
	    return 'Unknown';
	}
	
	public static function rank_name($rank) {
	    $t = 'Unknown';
	    switch ($rank) {
	        case TASK_RANK_WEAK: $t = 'Yếu'; break;
	        case TASK_RANK_AVERAGE: $t = 'Trung bình'; break;
	        case TASK_RANK_GOOD: $t = 'Khá'; break;
	        case TASK_RANK_VERY_GOOD: $t = 'Tốt'; break;
	        case TASK_RANK_EXCELLENT: $t = 'Rất tốt'; break;
	    }
	     
	    return $t;
	}
	
	public function completed_list($from, $to, $export=FALSE, &$field_list=NULL, &$column_name=NULL)
	{
	    // Get task list
	    $checked = BIT_TRUE;
	    $sql = "SELECT t.*, n1.hoten hoten1, n2.hoten hoten2 FROM task t INNER JOIN nhanvien n1 ON t.created_by = n1.manv
                       INNER JOIN nhanvien n2 ON t.assign_to = n2.manv
                WHERE (t.checked = {$checked}) AND (t.finished_date BETWEEN '{$from}' AND '{$to}')
                ORDER BY t.finished_date";
	    $this->setQuery($sql);
        $result = $this->loadAllRow();
        $this->disconnect();
        
        $output = NULL;
        // Create output array
        if(is_array($result)) {
            $model = new task_detail();
            $result_model = new task_result();
            
            if (!$export) { // No export
                $output = array();
                foreach ($result as $t) {
                    $row = array();
                    $row[] = $t['task_id'];
                    $row[] = $t['title'];
                    
                    /* Task's content */
                    $content = $t['content'];
                    if($t['has_detail'] == BIT_TRUE) {
                        $arr = $model->detail_list($t['task_id']);
                        $content .= "<br />";
                        foreach ($arr as $item) {
                            $format = "%d - %s<br />";
                            $content .= sprintf($format, $item->no, $item->content);
                        }
                    }
                    $row[] = $content;
                    
                    $row[] = $t['hoten1'];
                    $row[] = $t['hoten2'];
                    $row[] = $t['deadline'];
                    $row[] = $t['finished_date'];
                    $row[] = task::status_name($t['status']);
                    $row[] = task::rank_name($t['rank']);
                    
                    /* Task's result */
                    $tmp = $result_model->result_by_task($t['task_id'], $t['assign_to']);
                    $row[] = (is_array($tmp)) ? $tmp['result'] : 0;
                    
                    $output[] = $row;
                }
            } else { // Export to Excel
                $field_list = array('task_id', 'title', 'content', 'created_by', 'assign_to', 'deadline', 'finished_date', 'status', 'rank', 'result');
                $column_name = array('Id', 'Tiêu đề', 'Nội dung', 'Người tạo', 'Người thực hiện', 'Thời hạn', 'Ngày thực hiện', 'Trạng thái', 'Xếp hạng', 'Điểm');
                
                $output = array();
                foreach ($result as $t) {
                    $row = array();
                    $row['task_id'] = $t['task_id'];
                    $row['title'] = $t['title'];
                    
                    /* Task's content */
                    $content = $t['content'];
                    if($t['has_detail'] == BIT_TRUE) {
                        $model = new task_detail();
                        $arr = $model->detail_list($t['task_id']);
                        $content .= "\n";
                        foreach ($arr as $item) {
                            $format = "%d - %s\n";
                            $content .= sprintf($format, $item->no, $item->content);
                        }
                    }
                    $row['content'] = $content;
                    
                    $row['created_by'] =  $t['hoten1'];
                    $row['assign_to'] = $t['hoten2'];
                    $row['deadline'] = $t['deadline'];
                    $row['finished_date'] = $t['finished_date'];
                    $row['status'] = task::status_name($t['status']);
                    $row['rank'] = task::rank_name($t['rank']);
                    
                    /* Task's result */
                    $tmp = $result_model->result_by_task($t['task_id'], $t['assign_to']);
                    $row['result'] = (is_array($tmp)) ? $tmp['result'] : 0;
                
                    $output[] = $row;
                }
            }
        }
        
        // Return value
        return $output;
	}
}

/* End of file */