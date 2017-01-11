<?php
require_once '../config/constants.php';
require_once '../models/helper.php';
class marketing_entity {
    public $manv;
    public $makhach;
    public $chiendich;
    public $lienhe;
    public $ghichu;
    
    // Constructor
    public function marketing_entity() {
        $this->manv = '';
        $this->makhach = '';
        $this->chiendich = '';
        $this->lienhe = 0;
        $this->ghichu = '';
    }
    
    // Clone
    public function copy() {
        $item = new marketing_entity ();
        
        $item->manv = $this->manv;
        $item->makhach = $this->makhach;
        $item->chiendich = $this->chiendich;
        $item->lienhe = $this->lienhe;
        $item->ghichu = $this->ghichu;
        return $item;
    }
    
    // Assign
    public function assign($array) {
        $this->manv = $array ['manv'];
        $this->manhom = $array ['makhach'];
        $this->chiendich = $array ['chiendich'];
        $this->lienhe = $array ['lienhe'];
        $this->ghichu = $array ['ghichu'];
    }
}
