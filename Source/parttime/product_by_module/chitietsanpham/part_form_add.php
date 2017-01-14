<?php 
	// 
	$machitiet = array('tag' => 'input', 'class' => 'text-input','type' => 'text', 'name' => 'machitiet');
	$maloai = array('tag' => 'select', 'innerHTML', 'class' => 'text-input chosen', 'name' => 'maloai', 'value' =>  $option_loaima);

	$mota = array('tag' => 'textarea', 'name' => 'mota', 'innerHTML', 'rows' => 4);
	$hinhanh = array('tag' => 'input', 'type' => 'file', 'name' => 'hinhanh');
	$mausac = array('tag' => 'input', 'class' => 'text-input','type' => 'text', 'name' => 'mausac');
	$dai = array('tag' => 'input', 'class' => 'text-input','type' => 'text', 'name' => 'dai');
	$rong = array('tag' => 'input', 'class' => 'text-input','type' => 'text', 'name' => 'rong');
	$cao = array('tag' => 'input', 'class' => 'text-input','type' => 'text', 'name' => 'cao');

	$field = array($machitiet, $maloai, $mota, $hinhanh, $mausac, $dai, $rong, $cao);
	// 
	$label = array('Mã chi tiết', 'Mã loại', 'Mô tả', 'Hình ảnh', 'Màu sắc', 'Dài', 'Rộng', 'Cao');
	// 
    $btn_faction = array('tag' => 'input', 'class' => 'button', 'name' => 'add', 'type' => 'submit', 'value' => 'Xác nhận');
    $btn_fexit = array('tag' => 'input', 'class' => 'button exit', 'name' => 'exit', 'type' => 'button', 'value' => 'Thoát');
	$function = array($btn_faction, $btn_fexit);
	// 
	$title = array('tag' => 'div', 'innerHTML', 'class' => 'title', 'value' => 'thêm loai chi tiết sản phầm');

	$attr = array('action' => '?action=add', 'method'=>'post', 'id' => 'add-form', 'enctype' =>'multipart/form-data', 'onsubmit' => ' return checkvalueAdd()');
	$_form_buiding = array('attr' => $attr, 'title' => $title, 'label' => $label, 'field' => $field, 'function' => $function);
 	echo _render_popup_form($_form_buiding);
 ?>
