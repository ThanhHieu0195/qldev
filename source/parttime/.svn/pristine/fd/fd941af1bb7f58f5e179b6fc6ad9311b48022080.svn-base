<?php

require_once '../config/constants.php';
require_once '../models/helper.php';

class orders_question_option_entity {
	public $uid;
	public $question_id;
	public $no;
	public $content;
	
	public function orders_question_option_entity()
	{
		$this->uid = create_uid();
	}
	
	public function copy()
	{
		$item = new orders_question_option_entity();
		
		$item->question_id = $this->question_id;
		$item->no = $this->no;
		$item->content = $this->content;
		
		return $item;
	}
	
	public function assign($array)
	{
		$this->uid = $array['uid'];
		$this->question_id= $array['question_id'];
		$this->no = $array['no'];
		$this->content = $array['content'];
	}
}