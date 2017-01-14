<?php

require_once '../config/constants.php';
require_once '../models/helper.php';

class orders_question_result_entity {
	public $order_id;
	public $question_id;
	public $option;
	public $note;
        public $date;
	
	public function orders_question_result_entity()
	{
		$order_id = "";
		$question_id = "";
		$option = "";
		$note = "";
                $date = "";
	}
	
	public function copy()
	{
		$item = new orders_question_result_entity();
		
		$item->order_id = $this->order_id;
		$item->question_id = $this->question_id;
		$item->option = $this->option;
		$item->note = $this->note;
                $item->date = $this->date;
		
		return $item;
	}
	
	public function assign($array)
	{
		$this->order_id = $array['order_id'];
		$this->question_id= $array['question_id'];
		$this->option= $array['option'];
		$this->note= $array['note'];
                $this->date= $array['date'];
	}
}
