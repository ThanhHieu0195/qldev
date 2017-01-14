<?php
require_once '../config/constants.php';
require_once '../models/helper.php';
class news_entity {
    // Properties
    public $news_id;
    public $group_id;
    public $title;
    public $summary;
    public $content;
    public $created_date;
    public $last_modified;
    public $news_order;
    public $enable;
    
    // Constructor
    public function news_entity() {
        $this->news_id = create_uid ( FALSE );
        $this->created_date = current_timestamp ();
        $this->last_modified = current_timestamp ();
        $this->news_order = 1;
        $this->enable = BIT_TRUE;
    }
    
    // Clone method
    public function copy() {
        $item = new news_entity ();
        
        $item->news_id = $this->news_id;
        $item->group_id = $this->group_id;
        $item->title = $this->title;
        $item->summary = $this->summary;
        $item->content = $this->content;
        $item->created_date = $this->created_date;
        $item->last_modified = $this->last_modified;
        $item->news_order = $this->news_order;
        $item->enable = $this->enable;
        
        return $item;
    }
    
    // Assign method
    public function assign($array) {
        $this->news_id = $array ['news_id'];
        $this->group_id = $array ['group_id'];
        $this->title = $array ['title'];
        $this->summary = $array ['summary'];
        $this->content = $array ['content'];
        $this->created_date = $array ['created_date'];
        $this->last_modified = $array ['last_modified'];
        $this->news_order = $array ['news_order'];
        $this->enable = $array ['enable'];
    }
}