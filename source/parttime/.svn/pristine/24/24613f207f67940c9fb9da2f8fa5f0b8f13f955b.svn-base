<?php
require_once '../config/constants.php';
require_once '../models/helper.php';

// Entity class
class finance_reference_entity {
    // Properties
    public $reference_id;
    public $name;
    public $enable;
    public $used_type;
    
    // Constructor
    public function finance_reference_entity() {
        $this->enable = BIT_TRUE;
        $this->used_type = FINANCE_BOTH;
    }
    
    // Clone
    public function copy() {
        $item = new finance_reference_entity ();
        
        $item->reference_id = $this->reference_id;
        $item->name = $this->name;
        $item->enable = $this->enable;
        $item->used_type = $this->used_type;
        
        return $item;
    }
    
    // Assign
    public function assign($array) {
        $this->reference_id = $array ['reference_id'];
        $this->name = $array ['name'];
        $this->enable = $array ['enable'];
        $this->used_type = $array ['used_type'];
    }
}