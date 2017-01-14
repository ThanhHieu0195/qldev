<?php
require_once '../models/database.php';
//require 'phpagi/phpagi.php';
$phone = (isset($_GET['phone'])) ? $_GET['phone'] : '';
//$agi = new AGI();
//$phone = $agi->get_variable("CALLERID(num)");
//$phone = $agi->request[agi_callerid];
if (strlen($phone)>7) {
$db = new database();
$sql = "select n.dienthoaiban as d, k.hoten as hoten from nhanvien as n inner join guest_responsibility as g on g.employee_id = n.manv inner join khach as k on k.makhach = g.guest_id where dienthoai1 like '%".$phone."%' or dienthoai2 like '%".$phone."%' or dienthoai3 like '%".$phone."%' limit 1";
$db->setQuery($sql);
$arr = $db->loadAllRow();
if((is_array($arr)) && count($arr)>0):
    echo $arr[0]['d'] . "%%" .  $arr[0]['hoten'];
    //$agi->set_variable("", "0");
else:
    $sql = "select k.hoten as hoten from khach as k inner join nhomkhach as n on k.manhom = n.manhom where (dienthoai1 like '%".$phone."%' or dienthoai2 like '%".$phone."%' or dienthoai3 like '%".$phone."%') AND (k.manhom in (42,68,45)) limit 1";
    $db->setQuery($sql);
    $arr2 = $db->loadAllRow();
    if((is_array($arr2)) && count($arr2)>0):
        echo "400%%" .  $arr2[0]['hoten'];
    else:
        $sql="select hoten from nhanvien where dienthoai='" . $phone . "' limit 1";
        $db->setQuery($sql);
        $arr2 = $db->loadAllRow();
        if((is_array($arr2)) && count($arr2)>0):
            echo "200NL%%" .  $arr2[0]['hoten'] . "-NhiLong";
        else:
            echo "200%%" . $phone;
        endif; 
    endif;
endif;
} else {
    echo "200%%" . $phone;
}
//$no=preg_replace("#[^0-9]#","",$agi->request[agi_callerid]);

?>
