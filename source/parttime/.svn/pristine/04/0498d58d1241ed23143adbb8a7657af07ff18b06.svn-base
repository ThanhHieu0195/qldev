<?php

require_once '../config/constants.php';
require_once '../models/helper.php';

class task_entity {
	public $task_id;
	public $title;
	public $content;
	public $has_detail;
	public $created_by;
	public $assign_to;
	public $created_date;
	public $deadline;
	public $is_finished;
	public $finished_date;
	public $attachment;
	public $status;
	public $rank;
	public $comment;
	public $checked;
    public $template_id;
	
	public function task_entity()
	{
		$this->task_id = create_uid();
		$this->has_detail = BIT_FALSE;
		$this->created_date = current_timestamp();
		$this->is_finished = BIT_FALSE;
		$this->finished_date = current_timestamp();
		$this->status = TASK_STATUS_NEW;
		$this->rank = TASK_RANK_NONE;
		$this->comment = '';
		$this->checked = BIT_FALSE;
        $this->template_id = '';
	}
	
	public function copy()
	{
		$item = new task_entity();
		
		//$item->task_id = $this->task_id;
		$item->title = $this->title;
		$item->content = $this->content;
		$item->has_detail = $this->has_detail;
		$item->created_by = $this->created_by;
		$item->assign_to = $this->assign_to;
		//$item->created_date = $this->created_date;
		$item->deadline = $this->deadline;
		$item->is_finished = $this->is_finished;
		$item->finished_date = $this->finished_date;
		$item->attachment = $this->attachment;
		$item->status = $this->status;
		$item->rank = $this->rank;
		$item->comment = $this->comment;
		$item->checked = $this->checked;
        $item->template_id = $this->template_id;
		
		return $item;
	}
	
	public function assign($array)
	{
		$this->task_id = $array['task_id'];
		$this->title = $array['title'];
		$this->content = $array['content'];
		$this->has_detail = $array['has_detail'];
		$this->created_by = $array['created_by'];
		$this->assign_to = $array['assign_to'];
		$this->created_date = $array['created_date'];
		$this->deadline = $array['deadline'];
		$this->is_finished = $array['is_finished'];
		$this->finished_date = $array['finished_date'];
		$this->attachment = $array['attachment'];
		$this->status = $array['status'];
		$this->rank = $array['rank'];
		$this->comment = $array['comment'];
		$this->checked = $array['checked'];
        $this->template_id = $array['template_id'];
	}
}