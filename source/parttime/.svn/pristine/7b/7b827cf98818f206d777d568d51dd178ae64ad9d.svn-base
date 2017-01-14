<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ORDERS, array(F_ORDERS_UNCHECKED_LIST, F_ORDERS_CHECKED_LIST), TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Hậu mãi đơn hàng</title>
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
                <div class="clear"></div>
                <h2>Hậu mãi đơn hàng</h2>
                <p id="page-intro">Chọn chức năng bạn muốn thực hiện:</p>
                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), F_ORDERS_UNCHECKED_LIST)): ?>
                        <li>
                            <a class="shortcut-button add-event" href="unchecked_list.php">
                                <span class="png_bg">Đơn hàng chờ kiểm tra</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_ORDERS_CHECKED_LIST)): ?>
                        <li>
                            <a class="shortcut-button new-page" href="checked_list.php">
                                <span class="png_bg">Đơn hàng đã kiểm tra</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <!-- //-- REQ20120508_BinhLV_N -->
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>