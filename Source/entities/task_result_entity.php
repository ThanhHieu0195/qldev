<?php

require_once '../config/constants.php';
require_once '../models/helper.php';
require_once '../entities/task_result_rate_entity.php';

class task_result_entity extends task_result_rate_entity {
	public $uid;
	public $task_id;
	public $result;
	
	public function task_result_entity()
	{
		$this->uid = create_uid();
		$this->result = TASK_RESULT_NA;
	}
	
	public function copy()
	{
		$item = new task_result_entity();
		
		//$item->uid = $this->uid;
		$item->task_id = $this->task_id;
		$item->result = $this->result;
		$item->item_id = $this->item_id;
		
		$item->category_id = $this->category_id;
		$item->category_name = $this->category_name;
		$item->item_name = $this->item_name;
		$item->rate = $this->rate;
		
		return $item;
	}
	
	public function assign($array)
	{
	    $this->uid = $array['uid'];
	    $this->task_id = $array['task_id'];
		$this->item_id = $array['item_id'];
		$this->item_name = $array['item_name'];
		$this->category_id = $array['category_id'];
		$this->category_name = $array['category_name'];
		$this->rate = $array['rate'];
		$this->result = $array['result'];
	}
}