<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate ( G_GUEST, F_GUEST_GUEST_LIST, TRUE );

if (isset ( $_GET ['item'] )) {
    $makhach = $_GET ['item'];
    require_once '../models/khach.php';
    $db = new khach ();
    $result = $db->xoa_khach_hang ( $makhach );
    
    redirect ( "../guest/guestlist.php" );
}

require_once '../part/common_end_page.php';
?>