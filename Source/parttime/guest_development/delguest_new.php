<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate ( G_GUEST, F_GUEST_DEVELOPMENT_POOL, TRUE );

if (isset ( $_GET ['item'] )) {
    $makhach = $_GET ['item'];
	require_once '../models/marketing.php';
	 $db2 = new marketing ();
    $result2 = $db2->xoa_khach_hang_marketing ( $makhach );
    
    redirect ( "../guest_development/guestlistnew.php" );
}

require_once '../part/common_end_page.php';
?>
