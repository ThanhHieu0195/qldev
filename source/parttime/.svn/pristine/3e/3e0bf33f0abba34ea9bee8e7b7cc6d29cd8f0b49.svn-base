<?php
require_once '../part/common_start_page.php';

// Authenticate
// Notice that 'items_delete_item' constant does not exist
do_authenticate ( G_ITEMS, 'items_delete_item', TRUE );

if (isset ( $_GET ['item'] )) {
    $idtranh = $_GET ['item'];
    require_once '../models/tranh.php';
    $db = new tranh ();
    $result = $db->xoa_tranh ( $idtranh );
    
    redirect ( "../items/list.php" );
}

require_once '../part/common_end_page.php';
?>