<?php
require_once '../config/constants.php';
require_once '../models/helper.php';
class guest_development_history_entity {
    public $uid;
    public $guest_id;
    public $created_date;
    public $employee_id;
    public $note;
    public $is_history;
    
    // Constructor
    public function guest_development_history_entity() {
        $this->uid = create_uid ();
        $this->created_date = current_timestamp ();
        $this->note = '';
        $this->is_history = BIT_TRUE;
    }
    
    // Clone
    public function copy() {
        $item = new guest_development_history_entity ();
        
        $item->uid = $this->uid;
        $item->guest_id = $this->guest_id;
        $item->created_date = $this->created_date;
        $item->employee_id = $this->employee_id;
        $item->note = $this->note;
        $item->is_history = $this->is_history;
        
        return $item;
    }
    
    // Assign
    public function assign($array) {
        $this->uid = $array ['uid'];
        $this->guest_id = $array ['guest_id'];
        $this->created_date = $array ['created_date'];
        $this->employee_id = $array ['employee_id'];
        $this->note = $array ['note'];
        $this->is_history = $array ['is_history'];
    }
}