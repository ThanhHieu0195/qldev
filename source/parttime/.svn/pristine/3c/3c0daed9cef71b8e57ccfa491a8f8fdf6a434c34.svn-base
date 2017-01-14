<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate ( G_ITEMS, F_ITEMS_TYPE, TRUE );

if (isset ( $_GET ['item'] )) {
    $maloai = $_GET ['item'];
    require_once '../models/loaitranh.php';
    $db = new loaitranh ();
    $result = $db->xoa_loai_tranh ( $maloai );
    
    redirect ( "../items/type.php" );
}

require_once '../part/common_end_page.php';
?>