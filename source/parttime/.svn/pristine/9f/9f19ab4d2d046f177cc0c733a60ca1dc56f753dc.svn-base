<?php
require_once '../part/common_start_page.php';
require_once '../models/khach.php';

if (verify_access_right(current_account(), F_GUEST_ADD_GUEST)) {
    $format = '{ "result":%d , "message":"%s", "nguoicapnhat":"%s", "ngaygiocapnhat":"%s", "tongso":"%s" }';
    
    $hoten = $_POST ['hoten']; // ho ten
    $nhomkhach = $_POST ['nhomkhach']; // nhom khach
    $diachi = $_POST ['diachi']; // so nha, phuong
    $huyen = $_POST ['huyen'];
    $tinh = $_POST ['tinh'];
    $tiemnang = $_POST ['tiemnang'];
    $dienthoai1 = $_POST ['dienthoai1'];
    $dienthoai2 = $_POST ['dienthoai2'];
    $dienthoai3 = $_POST ['dienthoai3'];
    
    $id = 0;
    // Them khach moi vao database
    $khach = new khach ();
    $done = $khach->add_new ( $id, $nhomkhach, $hoten, $diachi, $huyen, $tinh, $tiemnang, $dienthoai1, $dienthoai2, $dienthoai3 );
    // Lay thong tin chi tiet khach moi them vao
    $array = $khach->detail ( $id );
    
    if ($done) {
        $array ['result'] = 1;
    } else
        $array ['result'] = 0;
    
    echo json_encode ( $array );
}

require_once '../part/common_end_page.php';
?>