<?php

require_once '../config/constants.php';
require_once '../models/helper.php';

class working_calendar_entity {
    public $uid;
    public $worker;
    public $working_date;
    public $branch;
    public $on_leave;
    public $note;
    public $created_by;
    public $approved;
    public $plan_uid;
    
    public function working_calendar_entity()
    {
        $this->uid = create_uid();
        $this->on_leave = BIT_FALSE;
        $this->note = "";
        $this->approved = BIT_FALSE;
    }
    
    public function copy()
    {
        $item = new working_calendar_entity();
        
        $item->worker = $this->worker;
        $item->working_date = $this->working_date;
        $item->branch = $this->branch;
        $item->on_leave = $this->on_leave;
        $item->note = $this->note;
        $item->created_by = $this->created_by;
        $item->approved = $this->approved;
        $item->plan_uid = $this->plan_uid;
        
        return $item;
    }
    
    public function assign($array)
    {
        $this->uid = $array['uid'];
        $this->worker = $array['worker'];
        $this->working_date = $array['working_date'];
        $this->branch = $array['branch'];
        $this->on_leave = $array['on_leave'];
        $this->note = $array['note'];
        $this->created_by = $array['created_by'];
        $this->approved = $array['approved'];
        $this->plan_uid = $array['plan_uid'];
    }
}