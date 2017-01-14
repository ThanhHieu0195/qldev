<?php

require_once '../config/constants.php';
require_once '../models/helper.php';

class account_function_of_role_entity {
    public $role_id;
    public $function_id;
    
    public function account_function_of_role_entity()
    {
    }
    
    public function copy()
    {
        $item = new account_function_of_role_entity();
        
        $item->role_id = $this->role_id;
        $item->function_id = $this->function_id;
        
        return $item;
    }
    
    public function assign($array)
    {
        $this->role_id = $array['role_id'];
        $this->function_id = $array['function_id'];
    }
}