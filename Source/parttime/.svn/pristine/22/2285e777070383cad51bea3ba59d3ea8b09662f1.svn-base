<?php
require_once '../config/constants.php';
require_once '../models/helper.php';
class employee_group_entity {
    public $group_id;
    public $group_name;
    public $enable;
    public function employee_group_entity() {
        $this->group_id = create_uid ();
        $this->group_name = '';
        $this->enable = BIT_TRUE;
    }
    public function copy() {
        $item = new employee_group_entity ();
        
        $item->group_id = $this->group_id;
        $item->group_name = $this->group_name;
        $item->enable = $this->enable;
        
        return $item;
    }
    public function assign($array) {
        $this->group_id = $array ['group_id'];
        $this->group_name = $array ['group_name'];
        $this->enable = $array ['enable'];
    }
}