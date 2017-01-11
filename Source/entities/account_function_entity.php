<?php

require_once '../config/constants.php';
require_once '../models/helper.php';

class account_function_entity {
    public $function_id;
    public $group_id;
    public $function_name;
    public $note;
    public $enable;
    
    public function account_function_entity()
    {
    }
    
    public function copy()
    {
        $item = new account_function_entity();
        
        $item->function_id = $this->function_id;
        $item->group_id = $this->group_id;
        $item->function_name = $this->function_name;
        $item->note = $this->note;
        $item->enable = $this->enable;
        
        return $item;
    }
    
    public function assign($array)
    {
        $this->function_id = $array['function_id'];
        $this->group_id = $array['group_id'];
        $this->function_name = $array['function_name'];
        $this->note = $array['note'];
        $this->enable = $array['enable'];
    }
}