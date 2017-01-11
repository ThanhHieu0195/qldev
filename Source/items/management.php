<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate ( G_ITEMS, F_ITEMS_LIST, TRUE );

require_once '../models/tonkho.php';

if (isset ( $_REQUEST ['action'] )) {
    $action = $_REQUEST ['action'];
    $masotranh = $_REQUEST ['masotranh'];
    $makho = $_REQUEST ['makho'];
    
    $ton_kho = new tonkho ();
    switch ($action) {
        case 'update' :
            $soluong = $_REQUEST ['soluong'];
            if (! $ton_kho->them ( $masotranh, $makho, $soluong ))
                $ton_kho->cap_nhat_so_luong ( $masotranh, $makho, $soluong, FALSE );
            break;
        
        case 'delete' :
            $ton_kho->xoa ( $masotranh, $makho );
            break;
    }
    
    echo 'Done!';
}

require_once '../part/common_end_page.php';
?>