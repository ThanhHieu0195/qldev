<?php

require_once '../config/constants.php';
require_once '../models/helper.php';

class items_swapping_entity {
	public $swap_uid;
    public $created_date;
    public $created_by;
    public $from_store;
    public $to_store;
    public $total_amount;
    public $status;
	
	public function items_swapping_entity()
	{
		$this->created_date = current_timestamp();
		$this->total_amount = 0;
		$this->status = SWAPPING_DRAFT;
	}
	
	public function copy()
	{
		$item = new items_swapping_entity();
		
		$item->swap_uid = $this->swap_uid;
		$item->created_date = $this->created_date;
		$item->created_by = $this->created_by;
		$item->from_store = $this->from_store;
		$item->to_store = $this->to_store;
		$item->total_amount = $this->total_amount;
		$item->status = $this->status;
		
		return $item;
	}
	
	public function assign($array)
	{
		$this->swap_uid = $array['swap_uid'];
		$this->created_date = $array['created_date'];
		$this->created_by = $array['created_by'];
		$this->from_store = $array['from_store'];
		$this->to_store = $array['to_store'];
		$this->total_amount = $array['total_amount'];
		$this->status = $array['status'];
	}
}