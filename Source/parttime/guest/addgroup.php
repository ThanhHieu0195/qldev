<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate ( G_GUEST, F_GUEST_GUEST_GROUP, TRUE );

if (isset ( $_POST ["submit"] )) {
    $tennhom = $_POST ["tennhom"];
    require_once ("../models/nhomkhach.php");
    $db = new nhomkhach ();
    $result = $db->them_nhom_khach ( $tennhom );
    
    redirect ( "../guest/group.php" );
}

require_once '../part/common_end_page.php';
?>
