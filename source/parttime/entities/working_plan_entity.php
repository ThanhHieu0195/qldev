<?php

require_once '../config/constants.php';
require_once '../models/helper.php';

class working_plan_entity {
    public $plan_uid;
    public $branches;
    public $from_date;
    public $to_date;
    public $created_by;
    public $created_date;
    public $approved;
    
    public function working_plan_entity()
    {
        $this->plan_uid = create_uid();
        $this->created_date = current_timestamp();
        $this->approved = BIT_FALSE;
    }
    
    public function copy()
    {
        $item = new working_plan_entity();
        
        $item->branches = $this->branches;
        $item->from_date = $this->from_date;
        $item->to_date = $this->to_date;
        $item->created_by = $this->created_by;
        $item->created_date = $this->created_date;
        $item->approved = $this->approved;
        
        return $item;
    }
    
    public function assign($array)
    {
        $this->plan_uid = $array['plan_uid'];
        $this->branches = $array['branches'];
        $this->from_date = $array['from_date'];
        $this->to_date = $array['to_date'];
        $this->created_by = $array['created_by'];
        $this->created_date = $array['created_date'];
        $this->approved = $array['approved'];
    }
}