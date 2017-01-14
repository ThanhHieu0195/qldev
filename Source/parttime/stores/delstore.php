<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate ( G_STORES, F_STORES_STORE_MANAGEMENT, TRUE );

if (isset ( $_GET ['item'] )) {
    $makho = $_GET ['item'];
    require_once '../models/khohang.php';
    $k = new khohang ();
    $xoa_kho_hang = $k->xoa_kho_hang ( $makho );
    
    redirect ( "../stores/storelist.php" );
}

require_once '../part/common_end_page.php';
?>