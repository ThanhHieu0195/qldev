<?php

require_once '../config/constants.php';
require_once '../models/helper.php';

class task_template_detail_entity {
	public $uid;
	public $template_id;
	public $no;
	public $content;
	
	public function task_template_detail_entity()
	{
		$this->uid = create_uid();
	}
	
	public function copy()
	{
		$item = new task_template_detail_entity();
		
		$item->template_id = $this->template_id;
		$item->no = $this->no;
		$item->content = $this->content;
		
		return $item;
	}
	
	public function assign($array)
	{
		$this->uid = $array['uid'];
		$this->template_id= $array['template_id'];
		$this->no = $array['no'];
		$this->content = $array['content'];
	}
}