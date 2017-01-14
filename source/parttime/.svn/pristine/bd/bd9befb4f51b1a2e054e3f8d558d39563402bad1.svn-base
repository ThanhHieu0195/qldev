<?php

require_once '../config/constants.php';
require_once '../models/helper.php';

class orders_question_entity {
	public $question_id;
	public $content;
	public $enable;
	
	public function orders_question_entity()
	{
		$this->question_id = create_uid();
		$this->enable = BIT_TRUE;
	}
	
	public function copy()
	{
		$item = new orders_question_entity();
		
		//$item->question_id = $this->question_id;
		$item->content = $this->content;
		$item->enable = $this->enable;
		
		return $item;
	}
	
	public function assign($array)
	{
		$this->question_id = $array['question_id'];
		$this->content = $array['content'];
		$this->enable = $array['enable'];
	}
}