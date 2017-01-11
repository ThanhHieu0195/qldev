<?php 
	// option_machitiet
	$machitiet = array('tag' => 'select', 'innerHTML', 'name' => 'machitiet', 'value'=> $option_machitiet);
	$soluong = array('tag' => 'input', 'class' => 'text-input number-input','type' => 'text', 'name' => 'soluong');
	$field = array($machitiet, $soluong);
	// 
	$label = array('Mã chi tiết', 'Số lượng');
	// 
    $btn_faction = array('tag' => 'input', 'class' => 'button', 'name' => 'add', 'type' => 'submit', 'value' => 'Xác nhận');
    $btn_fexit = array('tag' => 'input', 'class' => 'button exit', 'name' => 'exit', 'type' => 'button', 'value' => 'Thoát');
	$function = array($btn_faction, $btn_fexit);
	// 
	$title = array('tag' => 'div', 'innerHTML', 'class' => 'title', 'value' => 'thêm loai chi tiết sản phầm');

	$attr = array('action' => '?token='.$_token.'&action=add', 'method'=>'post', 'id' => 'add-form');

	$_form_buiding = array('attr' => $attr, 'title' => $title, 'label' => $label, 'field' => $field, 'function' => $function);
 	echo _render_popup_form($_form_buiding);
 ?>
