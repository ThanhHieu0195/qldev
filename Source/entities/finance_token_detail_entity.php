<?php
require_once '../config/constants.php';
require_once '../models/helper.php';

// Entity class
class finance_token_detail_entity {
    // Properties
    public $uid;
    public $madon;
    public $token_id;
    public $reference_id;
    public $product_id;
    public $item_id;
    public $perform_by;
    public $money_amount;
    public $taikhoan;
    public $note;
    public $perform_date;
    
    // Constructor
    public function finance_token_detail_entity() {
        $this->uid = create_uid ();
        $this->money_amount = 0;
        $this->note = '';
        $this->perform_date = current_timestamp ( 'Y-m-d' );
    }
    
    // Clone
    public function copy() {
        $item = new finance_token_detail_entity ();
        
        $item->uid = $this->uid;
        $item->token_id = $this->token_id;
        $item->reference_id = $this->reference_id;
        $item->madon = $this->madon;
        $item->product_id = $this->product_id;
        $item->item_id = $this->item_id;
        $item->perform_by = $this->perform_by;
        $item->money_amount = $this->money_amount;
        $item->taikhoan = $this->taikhoan;
        $item->note = $this->note;
        $item->perform_date = $this->perform_date;
        
        return $item;
    }
    
    // Assign
    public function assign($array) {
        $this->uid = $array ['uid'];
        $this->token_id = $array ['token_id'];
        $this->reference_id = $array ['reference_id'];
        $this->madon = $array ['madon'];
        $this->product_id = $array ['product_id'];
        $this->item_id = $array ['item_id'];
        $this->perform_by = $array ['perform_by'];
        $this->money_amount = $array ['money_amount'];
        $this->taikhoan = $array ['taikhoan'];
        $this->note = $array ['note'];
        $this->perform_date = $array ['perform_date'];
    }
}