<?php 
    $title = "Chi tiết sản phẩm";
 ?>

<!-- part-form-create.php -->
 <?php 
    $labels = array('Mã chi tiết', 'Mã loại', 'Mô tả', 'Hình ảnh', 'Màu sắc', 'Dài', 'Rộng', 'Cao', 'Chức năng');
    $btn_add = array('tag' => 'input', 'class' => 'button', 'onclick' => 'show_form_add();', 'type' => 'button', 'value' => 'Add');
    $model = new loaichitietsanpham();
    $data = $model->getAll();
    $format_option = '<option value="%1$s">%2$s</option>';
    $option_loaima = '';
    for ($i=0; $i < count($data); $i++) { 
    	$obj = $data[$i];
    	$option_loaima .= sprintf($format_option, $obj[0], $obj[1]);
    }
 ?>