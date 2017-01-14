<?php
require_once '../config/constants.php';
require_once '../models/helper.php';

// Entity class
class finance_product_entity {
    // Properties
    public $product_id;
    public $name;
    public $enable;
    public $used_type;
    
    // Constructor
    public function finance_product_entity() {
        $this->enable = BIT_TRUE;
        $this->used_type = FINANCE_BOTH;
    }
    
    // Clone
    public function copy() {
        $item = new finance_product_entity ();
        
        $item->product_id = $this->product_id;
        $item->name = $this->name;
        $item->enable = $this->enable;
        $item->used_type = $this->used_type;
        
        return $item;
    }
    
    // Assign
    public function assign($array) {
        $this->product_id = $array ['product_id'];
        $this->name = $array ['name'];
        $this->enable = $array ['enable'];
        $this->used_type = $array ['used_type'];
    }
}