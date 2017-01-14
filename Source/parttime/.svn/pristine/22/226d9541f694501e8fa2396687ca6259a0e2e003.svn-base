<?php 
	$machitiet = array('tag' => 'span', 'innerHTML', 'name' => 'machitiet');
	$soluong = array('tag' => 'input', 'class' => 'text-input number-input','type' => 'text', 'name' => 'soluong');
	$old_machitiet = array('tag' => 'input', 'type' => 'hidden', 'name' => 'old_machitiet');
	$field = array($machitiet, $soluong);
	// 
	$label = array('Mã chi tiết', 'Số lượng');
	// 
    $btn_faction = array('tag' => 'input', 'class' => 'button', 'name' => 'edit', 'type' => 'submit', 'value' => 'Xác nhận');
    $btn_fexit = array('tag' => 'input', 'class' => 'button exit', 'name' => 'exit', 'type' => 'button', 'value' => 'Thoát');
	$function = array($btn_faction, $btn_fexit);
	// 
	$title = array('tag' => 'div', 'innerHTML', 'class' => 'title', 'value' => 'Chinh sua loai chi tiết sản phầm');

	$attr = array('action' => '?token='.$_token.'&action=edit', 'method'=>'post', 'id' => 'edit-form');
	$hidden =array($old_machitiet);
	$_form_buiding = array('attr' => $attr, 'title' => $title, 'label' => $label, 'field' => $field, 'function' => $function, 'hidden' => $hidden);
 	echo _render_popup_form($_form_buiding);
 ?>
