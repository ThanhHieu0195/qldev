<?php 
    $btn_faction = array('tag' => 'input', 'class' => 'button', 'name' => 'del', 'type' => 'submit', 'value' => 'Xác nhận');
    $btn_fexit = array('tag' => 'input', 'class' => 'button exit', 'name' => 'exit', 'type' => 'button', 'value' => 'Thoát');
	$function = array($btn_faction, $btn_fexit);
	// 
	$title = array('tag' => 'div', 'innerHTML', 'class' => 'title', 'value' => 'Xóa loai chi tiết sản phầm');
	$machitiet = array('tag' => 'input', 'name' => 'machitiet');
	$hidden = array($machitiet);
	$attr = array('action' => '?token='.$_token.'&action=del', 'method'=>'post', 'id' => 'del-form');

	$_form_buiding = array('attr' => $attr, 'title' => $title, 'function' => $function, 'hidden' => $hidden);
 	echo _render_popup_form($_form_buiding);
 ?>