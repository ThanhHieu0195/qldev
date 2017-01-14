<?php

require_once '../config/constants.php';
require_once '../models/helper.php';

class account_function_group_entity {
    public $group_id;
    public $group_name;
    public $note;
    public $no;
    
    public function account_function_group_entity()
    {
    }
    
    public function copy()
    {
        $item = new account_function_group_entity();
        
        $item->group_id = $this->group_id;
        $item->group_name = $this->group_name;
        $item->note = $this->note;
        $item->no = $this->no;
        
        return $item;
    }
    
    public function assign($array)
    {
        $this->group_id = $array['group_id'];
        $this->group_name = $array['group_name'];
        $this->note = $array['note'];
        $this->no = $array['no'];
    }
}