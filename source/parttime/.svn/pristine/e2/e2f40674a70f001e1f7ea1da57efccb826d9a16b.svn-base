<?php
require_once '../config/constants.php';
require_once '../models/helper.php';
class default_users_entity {
    public $account_id;
    public $password;
    public $enable;
    public function default_users_entity() {
        $this->enable = BIT_TRUE;
    }
    public function copy() {
        $item = new default_users_entity ();
        
        $item->account_id = $this->account_id;
        $item->password = $this->password;
        $item->enable = $this->enable;
        
        return $item;
    }
    public function assign($array) {
        $this->account_id = $array ['account_id'];
        $this->password = $array ['password'];
        $this->enable = $array ['enable'];
    }
}