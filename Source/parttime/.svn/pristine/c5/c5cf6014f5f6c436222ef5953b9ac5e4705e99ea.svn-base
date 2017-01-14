<?php

require_once '../config/constants.php';
require_once '../models/helper.php';

class account_role_group_entity {
	public $role_id;
	public $role_name;
    public $enable;
	
	public function account_role_group_entity()
	{
        $this->enable = BIT_TRUE;
	}
	
	public function copy()
	{
		$item = new account_role_group_entity();
		
		$item->role_id = $this->role_id;
		$item->role_name = $this->role_name;
        $item->enable = $this->enable;
		
		return $item;
	}
	
	public function assign($array)
	{
        $this->role_id = $array['role_id'];
		$this->role_name = $array['role_name'];
        $this->enable = $array['enable'];
	}
}