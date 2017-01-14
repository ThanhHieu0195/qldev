<?php 
	// 
$madanchi= array('tag' => 'input', 'class' => 'text-input','type' => 'text', 'name' => 'madanchi');
$mota= array('tag' => 'input', 'class' => 'text-input','type' => 'text', 'name' => 'mota');

$field = array($madanchi, $mota);

$label = array('Mã dán chỉ', 'Mô tả');

$btn_faction = array('tag' => 'input', 'class' => 'button', 'name' => 'edit', 'type' => 'submit', 'value' => 'Xác nhận');
$btn_fexit = array('tag' => 'input', 'class' => 'button exit', 'name' => 'exit', 'type' => 'button', 'value' => 'Thoát');
$function = array($btn_faction, $btn_fexit);

$title = array('tag' => 'div', 'innerHTML', 'class' => 'title', 'value' => 'Chỉnh sửa mã dán chỉ');
$madanchicu =  array('tag' => 'input', 'class' => 'text-input','type' => 'text', 'name' => 'madanchicu');
$attr = array('action' => '?action=edit', 'method'=>'post', 'id' => 'edit-form', 'onsubmit' => ' return checkvalueedit()');
$_form_buiding = array('attr' => $attr, 'title' => $title, 'label' => $label, 'field' => $field, 'function' => $function, 'hidden' => array($madanchicu) );
echo _render_popup_form($_form_buiding);
