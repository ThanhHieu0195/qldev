<?php

require_once '../config/constants.php';
require_once '../models/helper.php';
require_once '../entities/task_result_category_entity.php';

class task_result_item_entity extends task_result_category_entity {
	public $item_id;
	public $item_name;
	
	public function task_result_item_entity()
	{
	}
	
	public function copy()
	{
		$item = new task_result_item_entity();
		
		$item->category_id = $this->category_id;
		$item->category_name = $this->category_name;
		$item->item_name = $this->item_name;
		
		return $item;
	}
	
	public function assign($array)
	{
		$this->item_id = $array['item_id'];
		$this->category_id = $array['category_id'];
		$this->category_name = $array['category_name'];
		$this->item_name = $array['item_name'];
	}
}