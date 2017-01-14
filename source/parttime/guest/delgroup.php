<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate ( G_GUEST, F_GUEST_GUEST_GROUP, TRUE );

if (isset ( $_GET ['item'] )) {
    $manhom = $_GET ['item'];
    require_once '../models/nhomkhach.php';
    $db = new nhomkhach ();
    $result = $db->xoa_nhom_khach ( $manhom );
    
    redirect ( "../guest/group.php" );
}

require_once '../part/common_end_page.php';
?>