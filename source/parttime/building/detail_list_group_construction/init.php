<?php 
	if ( !isset($_GET['token']) ) die;
	$_data		  = $_list_group_construction->getAll('', array('id' => $_id),'');
	$_data		  = $_data[0];
	$nam_building = array('tag'=>'label', 'innerHTML', 'value'=>$_data[1]);
	$address	  = array('tag'=>'label', 'innerHTML', 'value'=>$_data[2]);
	$phone		  = array('tag'=>'label', 'innerHTML', 'value'=>$_data[3]);
	$id_buiding   = array('tag'=>'label', 'innerHTML', 'value'=>$_data[4]);
	$_fields_main = array($nam_building, $address, $phone, $id_buiding);
	$_title  	  = "Chi tiết đội thi công";
?>