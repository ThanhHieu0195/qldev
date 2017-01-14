<?php 
	// 
	$maloai = array('tag' => 'input', 'class' => 'text-input','type' => 'text', 'name' => 'maloai');;
	$mota = array('tag' => 'textarea', 'name' => 'mota', 'innerHTML', 'rows' => 4);
	$fields = array($maloai, $mota);
	// 
	$labels = array('Mã loại', 'Mô tả');
	// 
    $btn_faction = array('tag' => 'input', 'class' => 'button', 'name' => 'add', 'type' => 'submit', 'value' => 'Xác nhận');
    $btn_fexit = array('tag' => 'input', 'class' => 'button exit', 'name' => 'exit', 'type' => 'button', 'value' => 'Thoát');
	$function = array($btn_faction, $btn_fexit);
	// 
	$title = array('tag' => 'div', 'innerHTML', 'class' => 'title', 'value' => 'Chỉnh sửa loai chi tiết sản phầm');
	$btn_old_maloai = array('tag' => 'input', 'name' => 'old_maloai');
	$hidden = array($btn_old_maloai);
	$attr = array('action' => '?action=edit', 'method'=>'post', 'id' => 'edit-form');

	$_form_buiding = array('attr' => $attr, 'title' => $title, 'label' => $labels, 'field' => $fields, 'function' => $function, 'hidden' => $hidden);
 	echo _render_popup_form($_form_buiding);
 ?>
