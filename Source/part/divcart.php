<div id="cart_top">
    <a href="../view/cart.php" title="Giỏ hàng">
        <img src="../resources/images/big_cart.png" alt="Giỏ hàng" title="Giỏ hàng" align="absmiddle" />
    </a>
    <?php
    require_once '../config/constants.php';
    require_once '../models/cart.php';
    
    $cart = new Cart(CART_NAME);
    $result = $cart->count();
    echo "Giỏ hàng có <span id='cart'>" . $result . "</span> sản phẩm";
    ?>
</div>