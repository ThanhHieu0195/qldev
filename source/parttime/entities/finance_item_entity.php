<?php
require_once '../config/constants.php';
require_once '../models/helper.php';

// Entity class
class finance_item_entity {
    // Properties
    public $item_id;
    public $category_id;
    public $name;
    public $enable;
    
    // Constructor
    public function finance_item_entity() {
        $this->item_id = create_uid ( FALSE );
        $this->enable = BIT_TRUE;
    }
    
    // Clone
    public function copy() {
        $item = new finance_item_entity ();
        
        $item->item_id = $this->item_id;
        $item->category_id = $this->category_id;
        $item->name = $this->name;
        $item->enable = $this->enable;
        
        return $item;
    }
    
    // Assign
    public function assign($array) {
        $this->item_id = $array ['item_id'];
        $this->category_id = $array ['category_id'];
        $this->name = $array ['name'];
        $this->enable = $array ['enable'];
    }
}