<?php

require_once '../config/constants.php';
require_once '../models/helper.php';

class working_leave_days_entity {
	public $uid;
    public $worker;
    public $old_date;
    public $new_date;
    public $note;
    public $created_by;
    public $approved;
	
	public function working_leave_days_entity()
	{
		$this->uid = create_uid();
        $this->old_date = NULL;
		$this->note = "";
		$this->approved = BIT_FALSE;
	}
	
	public function copy()
	{
		$item = new working_leave_days_entity();
		
		$item->worker = $this->worker;
		$item->old_date = $this->old_date;
		$item->new_date = $this->new_date;
		$item->note = $this->note;
		$item->created_by = $this->created_by;
		$item->approved = $this->approved;
		
		return $item;
	}
	
	public function assign($array)
	{
		$this->uid = $array['uid'];
		$this->worker = $array['worker'];
		if (!empty($array['old_date'])) {
		    $this->old_date = $array['old_date'];
		}
		$this->new_date = $array['new_date'];
		$this->note = $array['note'];
        $this->created_by = $array['created_by'];
		$this->approved = $array['approved'];
	}
}