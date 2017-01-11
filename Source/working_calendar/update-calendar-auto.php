<?php
require_once '../part/common_start_page.php';
require_once "../models/danhsachnghi.php";
require_once "../models/danhsachsongaynghi.php";
require_once "../models/phanquyen.php";
$num_leave = new leave_number();
if ($num_leave->autoUpdateByMonth()) {
    echo "OK";
}
?>
