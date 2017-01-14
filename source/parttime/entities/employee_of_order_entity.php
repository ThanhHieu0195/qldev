<?php
require_once '../config/constants.php';
require_once '../models/helper.php';
class employee_of_order_entity {
    public $order_id;
    public $employee_id;
    public function employee_of_order_entity() {
    }
    public function copy() {
        $item = new employee_of_order_entity ();
        
        $item->order_id = $this->order_id;
        $item->employee_id = $this->employee_id;
        
        return $item;
    }
    public function assign($array) {
        $this->order_id = $array ['order_id'];
        $this->employee_id = $array ['employee_id'];
    }
}