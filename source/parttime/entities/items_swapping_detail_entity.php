<?php

require_once '../config/constants.php';
require_once '../models/helper.php';

class items_swapping_detail_entity {
    public $uid;
    public $swap_uid;
    public $product_id;
    public $amount;
    public $status;
    public $note;
    
    public function items_swapping_detail_entity()
    {
        $this->uid = create_uid();
        $this->status = SWAPPING_DETAIL_WAIT;
        $this->note = '';
    }
    
    public function copy()
    {
        $item = new items_swapping_detail_entity();
        
        $item->uid = $this->uid;
        $item->swap_uid = $this->swap_uid;
        $item->product_id = $this->product_id;
        $item->amount = $this->amount;
        $item->status = $this->status;
        $item->note = $this->note;
        
        return $item;
    }
    
    public function assign($array)
    {
        $this->uid = $array['uid'];
        $this->swap_uid = $array['swap_uid'];
        $this->product_id = $array['product_id'];
        $this->amount = $array['amount'];
        $this->status = $array['status'];
        $this->note = $array['note'];
    }
}