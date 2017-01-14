<?php
require_once '../config/constants.php';
require_once '../models/helper.php';

// Entity class
class finance_token_entity {
    // Properties
    public $token_id;
    public $created_date;
    public $created_by;
    public $amount;
    public $token_type;
    public $is_finished;
    public $approved;
    
    // Constructor
    public function finance_token_entity() {
        $this->token_id = create_uid ( FALSE );
        $this->created_date = current_timestamp ();
        $this->amount = 0;
        $this->token_type = FINANCE_RECEIPT;
        $this->is_finished = BIT_FALSE;
        $this->approved = BIT_FALSE;
    }
    
    // Clone
    public function copy() {
        $item = new finance_token_entity ();
        
        $item->token_id = $this->token_id;
        $item->created_date = $this->created_date;
        $item->created_by = $this->created_by;
        $item->amount = $this->amount;
        $item->token_type = $this->token_type;
        $item->is_finished = $this->is_finished;
        $item->approved = $this->approved;
        
        return $item;
    }
    
    // Assign
    public function assign($array) {
        $this->token_id = $array ['token_id'];
        $this->created_date = $array ['created_date'];
        $this->created_by = $array ['created_by'];
        $this->amount = $array ['amount'];
        $this->token_type = $array ['token_type'];
        $this->is_finished = $array ['is_finished'];
        $this->approved = $array ['approved'];
    }
}