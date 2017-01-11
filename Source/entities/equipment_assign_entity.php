<?php

require_once '../config/constants.php';
require_once '../models/helper.php';

class equipment_assign_entity {
    public $uid;
	public $equipment_id;
	public $stored_in_old;
	public $assign_to_old;
	public $stored_in_new;
	public $assign_to_new;
	public $assign_date;
	public $assign_by;
    public $status;
	
	public function equipment_assign_entity()
	{
		$this->uid = create_uid();
		$this->assign_date = current_timestamp();
	    $this->status = EQUIPMENT_NEW;
	}
	
	public function copy()
	{
		$item = new equipment_assign_entity();
		
		$item->equipment_id = $this->equipment_id;
		$item->stored_in_old = $this->stored_in_old;
		$item->assign_to_old = $this->assign_to_old;
		$item->stored_in_new = $this->stored_in_new;
        $item->assign_to_new = $this->assign_to_new;
		$item->assign_date = $this->assign_date;
		$item->assign_by = $this->assign_by;
        $item->status = $this->status;
		
		return $item;
	}
	
	public function assign($array)
	{
        $this->uid = $array['uid'];
		$this->equipment_id = $array['equipment_id'];
		$this->stored_in_old = $array['stored_in_old'];
		$this->assign_to_old = $array['assign_to_old'];
		$this->stored_in_new = $array['stored_in_new'];
		$this->assign_to_new = $array['assign_to_new'];
        $this->assign_date = $array['assign_date'];
        $this->assign_by = $array['assign_by'];
        $this->status = $array['status'];
	}
}