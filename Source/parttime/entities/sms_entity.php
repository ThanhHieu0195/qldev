<?php
require_once '../config/constants.php';
require_once '../models/helper.php';
class sms_entity {
    public $id;
    public $smstemplate;
    public $smstype;
    
    // Constructor
    public function sms_entity() {
        $this->id = create_uid();
        $this->smstemplate = '';
        $this->smstype = '';
    }
    
    // Clone
    public function copy() {
        $item = new sms_entity ();
        
        $item->id = $this->id;
        $item->smstemplate = $this->smstemplate;
        $item->smstype = $this->smstype;
        return $item;
    }
    
    // Assign
    public function assign($array) {
        $this->id = $array ['id'];
        $this->smstemplate = $array ['smstemplate'];
        $this->smstype = $array ['smstype'];
    }
}
