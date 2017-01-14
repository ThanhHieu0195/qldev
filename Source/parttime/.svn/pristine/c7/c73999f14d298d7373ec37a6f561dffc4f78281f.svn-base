<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate ( G_ITEMS, F_ITEMS_TYPE, TRUE );

if (isset ( $_POST ["submit"] )) {
    $tenloai = $_POST ["tenloai"];
    $donvi = $_POST ["donvi"];
    $giasi = $_POST ["giasi"];
    $giale = $_POST ["giale"];
    require_once ("../models/loaitranh.php");
    $db = new loaitranh ();
    $result = $db->them_loai_tranh ( $tenloai, $donvi , $giasi, $giale);
    
    redirect ( "../items/type.php" );
}

require_once '../part/common_end_page.php';
?>
