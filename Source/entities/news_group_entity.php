<?php
require_once '../config/constants.php';
require_once '../models/helper.php';
class news_group_entity {
    // Properties
    public $group_id;
    public $name;
    public $note;
    public $enable;
    public $uid;
    
    // Constructor
    public function news_group_entity() {
        $this->group_id = create_uid ();
        $this->enable = BIT_TRUE;
    }
    
    // Clone method
    public function copy() {
        $item = new news_group_entity ();
        
        $item->group_id = $this->group_id;
        $item->name = $this->name;
        $item->note = $this->note;
        $item->enable = $this->enable;
        $item->uid = $this->uid;
        
        return $item;
    }
    
    // Assign method
    public function assign($array) {
        $this->group_id = $array ['group_id'];
        $this->name = $array ['name'];
        $this->note = $array ['note'];
        $this->enable = $array ['enable'];
        $this->uid = $array ['uid'];
    }
}