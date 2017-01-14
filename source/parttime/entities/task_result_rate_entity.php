<?php

require_once '../config/constants.php';
require_once '../models/helper.php';
require_once '../entities/task_result_item_entity.php';

class task_result_rate_entity extends task_result_item_entity {
	public $uid;
    public $manv;
	public $rate;
	
	public function task_result_rate_entity()
	{
	    $this->uid = create_uid();
	}
	
	public function copy()
	{
		$item = new task_result_rate_entity();
		
		$item->category_id = $this->category_id;
		$item->category_name = $this->category_name;
		$item->item_id = $this->item_id;
		$item->item_name = $this->item_name;
		$item->manv = $this->manv;
		$item->rate = $this->rate;
		
		return $item;
	}
	
	public function assign($array)
	{
		$this->category_id = $array['category_id'];
		$this->category_name = $array['category_name'];
		$this->item_id = $array['item_id'];
		$this->item_name = $array['item_name'];
		$this->manv = $array['manv'];
		$this->rate = $array['rate'];
	}
}