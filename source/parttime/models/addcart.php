<?php
require_once '../part/common_start_page.php';
require_once '../models/cart.php';
require_once '../models/chitietdonhang.php';

if (verify_access_right ( current_account (), F_VIEW_SALE )) {
    $masotranh = $_POST ['masotranh'];
    $makho = $_POST ['makho'];
    $soluong = $_POST ['soluong'];
    
    $cart = new Cart ( CART_NAME );
    $cart->register ();
    $cart->add ( $masotranh, $makho, $soluong, chitietdonhang::$CO_SAN );
    
    $output = array (
            'result' => 200,
            'count' => $cart->count () 
    );
} else {
    $output = array (
            'result' => 500,
            'count' => 0 
    );
}
echo json_encode ( $output );

require_once '../part/common_end_page.php';
?>