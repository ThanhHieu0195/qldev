<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate ( G_EMPLOYEES, F_EMPLOYEES_STAFF_LIST, TRUE );

if (isset ( $_GET ['item'] )) {
    $matho = $_GET ['item'];
    require_once '../models/tho.php';
    $db = new tho ();
    $result = $db->xoa_tho ( $matho );
    
    redirect ( "../employees/staff.php" );
}

require_once '../part/common_end_page.php';
?>