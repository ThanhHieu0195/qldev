<?php

require_once '../config/constants.php';
require_once '../models/helper.php';

class account_role_of_employee_entity {
	public $employee_id;
	public $role_id;
	
	public function account_role_of_employee_entity()
	{
	}
	
	public function copy()
	{
		$item = new account_role_of_employee_entity();
		
		$item->employee_id = $this->employee_id;
		$item->role_id = $this->role_id;
		
		return $item;
	}
	
	public function assign($array)
	{
		$this->employee_id = $array['employee_id'];
		$this->role_id = $array['role_id'];
	}
}