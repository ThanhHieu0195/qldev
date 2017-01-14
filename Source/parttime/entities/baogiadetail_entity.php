<?php
require_once '../config/constants.php';
require_once '../models/helper.php';
class baogiadetail_entity {
    public $id;
    public $ngaygionote;
    public $noidung;
    
    // Constructor
    public function baogiadetail_entity() {
        $this->id = '';
        $this->ngaygionote = current_timestamp ();
        $this->noidung = '';
    }
    
    // Clone
    public function copy() {
        $item = new baogiadetail_entity ();
        
        $item->id = $this->id;
        $item->ngaygionote = $this->ngaygionote;
        $item->noidung = $this->noidung;
        
        return $item;
    }
    
    // Assign
    public function assign($array) {
        $this->id = $array ['id'];
        $this->ngaygionote = $array ['ngaygionote'];
        $this->noidung = $array ['noidung'];
    }
}
