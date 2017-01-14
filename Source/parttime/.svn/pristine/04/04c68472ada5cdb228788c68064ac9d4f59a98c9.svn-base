<?php
require_once '../part/common_start_page.php';
require_once '../models/cart.php';

if (verify_access_right ( current_account (), F_VIEW_SALE )) {
    $masotranh = $_REQUEST ['masotranh'];
    $makho = $_REQUEST ['makho'];
    
    $cart = new Cart ( CART_NAME );
    $cart->register ();
    $cart->delete ( $masotranh, $makho );
}

redirect ( "../view/cart.php" );

require_once '../part/common_end_page.php';
?>