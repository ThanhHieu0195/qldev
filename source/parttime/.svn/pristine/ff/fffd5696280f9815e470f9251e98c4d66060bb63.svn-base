<?php

require_once '../config/constants.php';
require_once '../models/helper.php';

class task_template_entity {
	public $template_id;
	public $title;
	public $content;
	public $has_detail;
	
	public function task_template_entity()
	{
		$this->template_id = create_uid();
		$this->has_detail = BIT_FALSE;
	}
	
	public function copy()
	{
		$item = new task_template_entity();
		
		//$item->template_id = $this->template_id;
		$item->title = $this->title;
		$item->content = $this->content;
		$item->has_detail = $this->has_detail;
		
		return $item;
	}
	
	public function assign($array)
	{
		$this->template_id = $array['template_id'];
		$this->title = $array['title'];
		$this->content = $array['content'];
		$this->has_detail = $array['has_detail'];
	}
}