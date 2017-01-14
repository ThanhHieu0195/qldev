<?php
require_once '../models/helper.php';
class baogia_entity {
    public $id;
    public $ngaybaogia;
    public $ngayclose;
    public $manhanvien;
    public $ngaycapnhat;
    public $lastupdate;
    public $status;
    public $closereason;
    
    // Constructor
    public function baogia_entity() {
        $this->id = '';
        $this->manhanvien = '';
        $this->lastupdate = '';
        $this->status = '';
        $this->closereason = '';
    }
    
    // Clone
    public function copy() {
        $item = new baogia_entity ();
        $item->id = $this->id;
        $item->ngaybaogia = $this->ngaybaogia;
        $item->ngayclose = $this->ngayclose;
        $item->manhanvien = $this->manhanvien;
        $item->ngaycapnhat = $this->ngaycapnhat;
        $item->lastupdate = $this->lastupdate;
        $item->status = $this->status;
        $item->closereason = $this->closereason;
        return $item;
    }
    
    // Assign
    public function assign($array) {
        $this->id = $array ['id'];
        $this->ngaybaogia = $array ['ngaybaogia'];
        $this->ngayclose = $array ['ngayclose'];
        $this->manhanvien = $array ['manhanvien'];
        $item->ngaycapnhat = $array ['ngaycapnhat'];
        $this->lastupdate = $array ['lastupdate'];
        $this->status = $array ['status'];
        $this->closereason = $array ['closereason'];
    }
}
