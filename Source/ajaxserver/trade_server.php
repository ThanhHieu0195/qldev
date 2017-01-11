<?php
require_once '../part/common_start_page.php';
require_once '../models/doanhthu.php';

if (verify_access_right(current_account(), F_VIEW_TRADE))
{
    $maso = $_REQUEST['maso'];
    $ngay = $_REQUEST['ngay'];
    $makho = $_REQUEST['makho'];
    $nguoicapnhat = current_account();
    $ngaygiocapnhat = current_timestamp();
    $ghichu = $_REQUEST['ghichu'];
    $loaisanpham = explode('|', $_REQUEST['loaisanpham']);
    $sotien = explode('|', $_REQUEST['sotien']);
    $format = '{ "result":%d , "message":"%s", "nguoicapnhat":"%s", "ngaygiocapnhat":"%s", "tongso":"%s" }';
        
    $dt = new doanhthu();
    $tongso = $dt->cap_nhat_doanh_thu($maso, $ngay, $makho, $nguoicapnhat, $ngaygiocapnhat, $ghichu, $loaisanpham, $sotien);
    if ($tongso >= 0)
    {
    	$result = 1;
    	$message = "OK";
    }
    else
    {
    	$result = 0;
    	$message = $dt->_error;
    }
    $json = sprintf($format, $result, $message, $nguoicapnhat, $ngaygiocapnhat, number_2_string($tongso));
    echo $json;
}

require_once '../part/common_end_page.php';
?>