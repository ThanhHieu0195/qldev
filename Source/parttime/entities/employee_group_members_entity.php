<?php
require_once '../config/constants.php';
require_once '../models/helper.php';
class employee_group_members_entity {
    public $group_id;
    public $employee_id;
    public function employee_group_members_entity() {
    }
    public function copy() {
        $item = new employee_group_members_entity ();
        
        $item->group_id = $this->group_id;
        $item->employee_id = $this->employee_id;
        
        return $item;
    }
    public function assign($array) {
        $this->group_id = $array ['group_id'];
        $this->employee_id = $array ['employee_id'];
    }
}