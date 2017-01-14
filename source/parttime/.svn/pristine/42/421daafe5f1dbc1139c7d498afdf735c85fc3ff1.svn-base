<?php
require_once '../config/constants.php';
require_once '../models/helper.php';
class guest_events_entity {
    public $uid;
    public $guest_id;
    public $event_date;
    public $note;
    public $is_event;
    public $enable;
    
    // Constructor
    public function guest_events_entity() {
        $this->uid = create_uid ();
        $this->note = '';
        $this->is_event = BIT_TRUE;
        $this->enable = BIT_FALSE;
    }
    
    // Clone
    public function copy() {
        $item = new guest_events_entity ();
        
        $item->uid = $this->uid;
        $item->guest_id = $this->guest_id;
        $item->event_date = $this->event_date;
        $item->note = $this->note;
        $item->is_event = $this->is_event;
        $item->enable = $this->enable;
        
        return $item;
    }
    
    // Assign
    public function assign($array) {
        $this->uid = $array ['uid'];
        $this->guest_id = $array ['guest_id'];
        $this->event_date = $array ['event_date'];
        $this->note = $array ['note'];
        $this->is_event = $array ['is_event'];
        $this->enable = $array ['enable'];
    }
}