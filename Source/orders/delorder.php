<?php
require_once '../part/common_start_page.php';

// Authenticate
// Notice that 'orders_delete_order' constant does not exist
do_authenticate ( G_ORDERS, 'orders_delete_order', TRUE );

if (isset ( $_GET ['item'] )) {
    $madon = $_GET ['item'];
    require_once '../models/donhang.php';
    $db = new donhang ();
    $result = $db->xoa_don_hang ( $madon );
    
    redirect ( "../orders/orderlist.php" );
}

require_once '../part/common_end_page.php';
?>