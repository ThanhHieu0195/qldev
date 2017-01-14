<?php
require_once '../config/constants.php';
require_once '../models/helper.php';
class default_users_stores_entity {
    public $account_id;
    public $store_id;
    public function default_users_stores_entity() {
    }
    public function copy() {
        $item = new default_users_stores_entity ();
        
        $item->account_id = $this->account_id;
        $item->store_id = $this->store_id;
        
        return $item;
    }
    public function assign($array) {
        $this->account_id = $array ['account_id'];
        $this->store_id = $array ['store_id'];
    }
}