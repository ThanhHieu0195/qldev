<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_VIEW, array(F_VIEW_CART, F_VIEW_SALE), TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>       
        <title>Giỏ hàng</title>
        <?php require_once '../part/cssjs.php'; ?>
    </head>
    <body>
        <div id="body-wrapper"> 
            <?php
            require_once '../part/menu.php';
            ?>
            <div id="main-content">
                <!-- //++ REQ20120508_BinhLV_N -->
                <noscript>
                    <div class="notification error png_bg">
                        <div>
                            Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
                        </div>
                    </div>
                </noscript>
                <!-- //-- REQ20120508_BinhLV_N -->
                <?php
                include_once '../part/divcart.php';
                ?>
                <div class="clear"></div>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Giỏ hàng</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <?php
                            require_once '../models/cart.php';
                            require_once '../config/constants.php';
                            require_once '../models/helper.php';
                            
                            $cart = new Cart(CART_NAME);
                            $cart->register();
                            $array = $cart->detail_list();
                            ?>
                            <form action="" method="post">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Xóa</th>
                                            <th>Sản phẩm</th>
                                            <th>Showroom</th>
                                            <th>Đơn giá(VNĐ)</th>
                                            <th>Số lượng</th>
                                            <th>Thành tiền</th>
                                        </tr>
                                    </thead>                                                                 
                                    <tbody>
                                        <?php
                                        $total = 0;
                                        if($array !== NULL):
                                            foreach ($array as $key => $value):
                                                $total += $value['thanhtien'];
                                                $link = sprintf('../models/delcart.php?masotranh=%s&makho=%s',
                                                                $value['masotranh'], $value['makho']);
                                        ?>
                                                <tr>
                                                    <td>
                                                        <a title="Xóa khỏi giỏ hàng" href="<?php echo $link; ?>">
                                                            <img alt="delete" src="../resources/images/recycle.jpg" />
                                                        </a>
                                                    </td>
                                                    <td>
                                                        <img alt="hinhanh" src="<?php echo '../' . $value['hinhanh']; ?>" width="120px" height="120px" /><br />
                                                        <span>Mã số: <?php echo $value['masotranh']; ?></span>
                                                    </td>
                                                    <td>
                                                        <?php echo $value['tenkho']; ?>
                                                    </td>
                                                    <td class="price">
                                                        <?php echo number_2_string($value['giaban']); ?>
                                                    </td>
                                                    <td>
                                                        <?php echo $value['soluong']; ?>
                                                    </td>
                                                    <td class="price">
                                                        <?php echo str_replace(',', '.', number_format($value['thanhtien'])); ?>
                                                    </td>
                                                </tr>
                                        <?php
                                            endforeach;
                                        endif;
                                        ?>                                        
                                        <tr>
                                            <td></td>
                                            <td colspan="3"></td>
                                            <td style="font-weight: bold; font-size: 15px;">Tổng tiền</td>
                                            <td class="price">
                                                <?php echo str_replace(',', '.', number_format($total)); ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="6">
                                                <div class="cart_button_list">
                                                    <a href="store.php" class="button" title="Tiếp tục mua">Tiếp tục mua</a>
                                                    <a href="pay.php" class="button" title="Thanh toán">Thanh toán</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
                <?php include_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>

</html>
<?php 
require_once '../part/common_end_page.php';
?>