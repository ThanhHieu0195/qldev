<?php 
	// 
$makhoan= array('tag' => 'input', 'class' => 'text-input','type' => 'text', 'name' => 'makhoan');
$mota= array('tag' => 'input', 'class' => 'text-input','type' => 'text', 'name' => 'mota');

$field = array($makhoan, $mota);

$label = array('Mã khoan', 'Mô tả');

$btn_faction = array('tag' => 'input', 'class' => 'button', 'name' => 'edit', 'type' => 'submit', 'value' => 'Xác nhận');
$btn_fexit = array('tag' => 'input', 'class' => 'button exit', 'name' => 'exit', 'type' => 'button', 'value' => 'Thoát');
$function = array($btn_faction, $btn_fexit);

$title = array('tag' => 'div', 'innerHTML', 'class' => 'title', 'value' => 'Chỉnh sửa mã dán chỉ');
$makhoancu =  array('tag' => 'input', 'class' => 'text-input','type' => 'text', 'name' => 'makhoancu');
$attr = array('action' => '?action=edit', 'method'=>'post', 'id' => 'edit-form', 'onsubmit' => ' return checkvalueedit()');
$_form_buiding = array('attr' => $attr, 'title' => $title, 'label' => $label, 'field' => $field, 'function' => $function, 'hidden' => array($makhoancu) );
echo _render_popup_form($_form_buiding);
