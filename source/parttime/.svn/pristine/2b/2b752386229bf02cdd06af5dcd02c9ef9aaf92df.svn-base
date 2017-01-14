<?php 
    $_title = "Loại chi tiết sản phẩm";
    $tranh = new tranh();
    $data = $tranh->chi_tiet_tranh($_token);
    $chitietsanpham = new chitietsanpham();

    $data_chitietsanpham = $chitietsanpham->getAll( array('machitiet', 'mota') );
    $format_option = '<option value="%1$s">%2$s</option>';
    $option_loaima = '';
    for ($i=0; $i < count($data_chitietsanpham); $i++) { 
    	$obj = $data_chitietsanpham[$i];
    	$option_machitiet .= sprintf($format_option, $obj[0], $obj[1]);
    }
 ?>

