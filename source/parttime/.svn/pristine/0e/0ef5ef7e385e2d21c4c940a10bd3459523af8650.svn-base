<?php
require_once '../config/constants.php';
require_once '../models/helper.php';
class guest_responsibility_entity {
    public $guest_id;
    public $employee_id;
    public $uid;
    
    // Constructor
    public function guest_responsibility_entity() {
        $this->uid = create_uid ();
    }
    
    // Clone
    public function copy() {
        $item = new guest_responsibility_entity ();
        
        $item->guest_id = $this->guest_id;
        $item->employee_id = $this->employee_id;
        $item->uid = $this->uid;
        
        return $item;
    }
    
    // Assign
    public function assign($array) {
        $this->guest_id = $array ['guest_id'];
        $this->employee_id = $array ['employee_id'];
        $this->uid = $array ['uid'];
    }
}