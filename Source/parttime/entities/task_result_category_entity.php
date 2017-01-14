<?php

require_once '../config/constants.php';
require_once '../models/helper.php';

class task_result_category_entity {
	public $category_id;
	public $category_name;
	
	public function task_result_category_entity()
	{
	}
	
	public function copy()
	{
		$item = new task_result_category_entity();
		
		$item->category_name = $this->category_name;
		
		return $item;
	}
	
	public function assign($array)
	{
		$this->category_id = $array['category_id'];
		$this->category_name= $array['category_name'];
	}
}