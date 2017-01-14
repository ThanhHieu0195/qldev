<?php

require_once '../config/constants.php';
require_once '../models/helper.php';

class task_detail_entity {
	public $uid;
	public $task_id;
	public $no;
	public $content;
	public $checked;
	
	public function task_detail_entity()
	{
		$this->uid = create_uid();
		$this->checked = BIT_FALSE;
	}
	
	public function copy()
	{
		$item = new task_detail_entity();
		
		$item->task_id = $this->task_id;
		$item->no = $this->no;
		$item->content = $this->content;
		$item->checked = $this->checked;
		
		return $item;
	}
	
	public function assign($array)
	{
		$this->uid = $array['uid'];
		$this->task_id= $array['task_id'];
		$this->no = $array['no'];
		$this->content = $array['content'];
		$this->checked = $array['checked'];
	}
}