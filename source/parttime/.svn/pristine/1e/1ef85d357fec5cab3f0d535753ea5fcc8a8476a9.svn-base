<?php
require_once '../config/constants.php';
require_once '../models/helper.php';
class guest_entity {
    public $makhach;
    public $manhom;
    public $hoten;
    public $diachi;
    public $quan;
    public $tp;
    public $tiemnang;
    public $dienthoai1; // DT
    public $dienthoai2; // DD
    public $dienthoai3;
    public $email;
    public $emailphu;
    public $development;
    
    // Constructor
    public function guest_entity() {
        $this->makhach = 0;
        $this->diachi = '';
        $this->quan = '';
        $this->tp = '';
        $this->tiemnang = 0x00;
        $this->dienthoai1 = '';
        $this->dienthoai2 = '';
        $this->dienthoai3 = '';
        $this->email = '';
        $this->development = GUEST_DEVELOPMENT_ONGOING;
    }
    
    // Clone
    public function copy() {
        $item = new guest_entity ();
        
        $item->makhach = $this->makhach;
        $item->manhom = $this->manhom;
        $item->hoten = $this->hoten;
        $item->diachi = $this->diachi;
        $item->quan = $this->quan;
        $item->tp = $this->tp;
        $item->tiemnang = $this->tiemnang;
        $item->dienthoai1 = $this->dienthoai1;
        $item->dienthoai2 = $this->dienthoai2;
        $item->dienthoai3 = $this->dienthoai3;
        $item->email = $this->email;
        $item->emailphu = $this->emailphu;
        $item->development = $this->development;
        
        return $item;
    }
    
    // Assign
    public function assign($array) {
        $this->makhach = $array ['makhach'];
        $this->manhom = $array ['manhom'];
        $this->hoten = $array ['hoten'];
        $this->diachi = $array ['diachi'];
        $this->quan = $array ['quan'];
        $this->tp = $array ['tp'];
        $this->tiemnang = $array ['tiemnang'];
        $this->dienthoai1 = $array ['dienthoai1'];
        $this->dienthoai2 = $array ['dienthoai2'];
        $this->dienthoai3 = $array ['dienthoai3'];
        $this->email = $array ['email'];
        $this->emailphu = $array ['emailphu'];
        $this->development = $array ['development'];
    }
}
