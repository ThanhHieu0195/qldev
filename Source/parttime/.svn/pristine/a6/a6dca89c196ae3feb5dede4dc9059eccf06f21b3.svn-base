<?php

require_once '../config/constants.php';
require_once '../models/helper.php';

class rewards_penalty_entity {
    public $rewards_uid;
    public $created_date;
    public $content;
    public $created_by;
    public $assign_to;
    public $rewards_level;
    public $rewards_value;
    public $approved;
    public $feedback;
    
    public function rewards_penalty_entity()
    {
        $this->rewards_uid = create_uid();
        $this->created_date = current_timestamp();
        $this->content = '';
        $this->created_by = '';
        $this->assign_to = '';
        $this->rewards_level = 0;
        $this->rewards_value = 0;
        $this->approved = BIT_FALSE;
        $this->feedback = '';
    }
    
    public function copy()
    {
        
    }
    
    public function assign($array)
    {
        $this->rewards_uid = $array['rewards_uid'];
        $this->created_date = $array['created_date'];
        $this->content = $array['content'];
        $this->created_by = $array['created_by'];
        $this->assign_to = $array['assign_to'];
        $this->rewards_level = $array['rewards_level'];
        $this->rewards_value = $array['rewards_value'];
        $this->approved = $array['approved'];
        $this->feedback = $array['feedback'];
    }
}