<?php 
    $title = "Công việc chi tiết";
 ?>

<!-- part-form-create.php -->
 <?php 
	$_token = $_GET['token'];
	// congvieccongtac init
	require_once "../models/congvieccongtac.php";
	$collaborative_work = new collaborative_work();
	$params 		 		 = 		array( "id", "mota", "ngayhoanthanh", "giatien", "attachment", "trangthai");
	$conditions				 = 		array( "id"=>$_token );
	$_list_data				 = 		$collaborative_work->getAll( $params, $conditions );
	$describe				 = 		array( "tag" => "span", "innerHTML", "value"=>$_list_data[0][1] );
	$date_complete 			 = 		array( "tag" => "span", "innerHTML", "value"=>$_list_data[0][2] );
	$cost 					 = 		array( "tag" => "span", "innerHTML", "value"=>$_list_data[0][3] );
	$attachment 			 = 		array( "tag" => "a", "innerHTML","value"=>"download", 
									"target" => '_blank'	,"href"=>$_list_data[0][4] );
	$status 		 		 = 		array( "tag" => "span", "innerHTML", 'style' => 'color:red', 
														"value"=>$collaborative_work->_LIST_STATUS[ $_list_data[0][5]] );
	$btn_accept 			 = 		array( "tag" => "input", "class" => "button", "id"=>"show-popup-accept", 
									"value"=>"Nhận công việc", "type"=> "button" );
    require_once "../models/approvecongviec.php";
	$approve_work 			 = new approve_work();
	$manv = current_account();
	
	// check emplyee accept work
	if ( $_list_data[0][5] == STATUS_APPROVE ) {
		$btn_accept = "";
	}

	$_labels 				 = 		array( "Mô tả", "Ngày hoàn thành", "Giá tiền", "attachment", "Trạng thái", "Chức năng");
    $_fields 				 = 		array( $describe, $date_complete, $cost, $attachment, $status, $btn_accept );

    // part_popup_accept_work.php
    $submission_date		 =		array( "tag" => "input", "type" => "text", "class"=>"datepicker", 
    								"name"=>"date_complete" );
    $btn_submit_popup 		 = 		array( "tag" => "input", "class" => "button","type" => "submit", "value" => "Xác nhận", 
    								"name"=>"insert-approvecongviec" );

    $_labels_popup 	 		 = 		array( "Ngày nộp bài", "Chức năng" );
    $_fields_popup 	 		 = 		array( $submission_date, $btn_submit_popup );
 ?>
