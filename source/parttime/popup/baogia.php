<?php
require_once '../models/database.php';
require_once '../models/nhanvien.php';
require_once '../models/baogia.php';
require_once '../models/baogiadetail.php';
require_once '../entities/baogia_entity.php';
require_once '../entities/baogiadetail_entity.php';

$baogiaid = (isset($_GET['baogiaid'])) ? $_GET['baogiaid'] : '';
$emailid = (isset($_GET['mailid'])) ? $_GET['mailid'] : '';
$email = (isset($_GET['email'])) ? $_GET['email'] : '';
$noidung = (isset($_GET['noidung'])) ? $_GET['noidung'] : '';
$nhanvien = new nhanvien();
$manv = $nhanvien->get_manv($email);
$continue = TRUE;
if (( ! empty ($baogiaid)) && (! empty ($manv))) {
    $baogia = new baogia();
    $baogiadetail = new baogiadetail();  
    $noidung .= '<br> Chi tiet:  <a href='.chr(34).'http'.chr(58).'//livechat.nhilong.com/mailbox/msg-' . $emailid . '.html" target="blank">Click here</a>';
    if (! $baogia->baogia_exist($baogiaid)) {
        $baogiaentities = new baogia_entity ();
        $baogiaentities->id = $baogiaid;
        $baogiaentities->ngaybaogia = '20' . substr($baogiaid,4,2) . '-' . substr($baogiaid,6,2) . '-' . substr($baogiaid,8,2) ;
        $baogiaentities->ngayclose = NULL;
        $baogiaentities->ngaycapnhat = date('Y-m-d');
        $baogiaentities->manhanvien = $manv;      
        error_log ("Update baogia " . $noidung . " " .$manv, 3, '/var/log/phpdebug.log');
        $baogiaentities->lastupdate = $noidung;
        $baogiaentities->status = 1;
        $baogiaentities->closereason = NULL;        
        $result = $baogia->them_moi ( $baogiaentities );
    } else {
        $baogia->update($baogiaid, $noidung, date('Y-m-d'), 1);
    }
    
}
?>
