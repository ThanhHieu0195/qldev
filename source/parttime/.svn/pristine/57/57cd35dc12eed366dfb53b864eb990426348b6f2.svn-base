<?php

require_once '../config/constants.php';
require_once '../models/helper.php';

class equipment_entity {
	public $equipment_id;
	public $name;
	public $status;
	public $stored_in;
	public $assign_to;
	public $assign_date;
	public $enable;
	
	public function equipment_entity()
	{
		//$this->equipment_id = create_uid();
		//$this->assign_date = current_timestamp();
	    $this->enable = BIT_TRUE;
	}
	
	public function copy()
	{
		$item = new equipment_entity();
		
		//$item->task_id = $this->task_id;
		$item->name = $this->name;
		$item->status = $this->status;
		$item->stored_in = $this->stored_in;
		$item->assign_to = $this->assign_to;
		$item->assign_date = $this->assign_date;
		$item->enable = $this->enable;
		
		return $item;
	}
	
	public function assign($array)
	{
		$this->equipment_id = $array['equipment_id'];
		$this->name = $array['name'];
		$this->status = $array['status'];
		$this->stored_in = $array['stored_in'];
		$this->assign_to = $array['assign_to'];
        $this->assign_date = $array['assign_date'];
        $this->enable = $array['enable'];
	}
}