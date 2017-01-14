<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_SYSTEM_ADMIN, 
                array(F_SETTINGS_ORDER_CONFIGURE, 
                      F_SETTINGS_MAIL_CONFIGURE, 
                      F_SETTINGS_TASK_CONFIGURE
                ), 
                TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Settings</title>
        <?php require_once '../part/cssjs.php'; ?>
    </head>
    <body>
        <div id="body-wrapper">
            <?php
            require_once '../part/menu.php';
            ?>
            <div id="main-content">
                <noscript>
                    <div class="notification error png_bg">
                        <div>
                            Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
                        </div>
                    </div>
                </noscript>
                <div class="clear"></div>
                <h2>Settings</h2>
                <p id="page-intro">Chọn chức năng bạn muốn thực hiện:</p>
                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), F_SETTINGS_ORDER_CONFIGURE)): ?>
                        <li>
                            <a class="shortcut-button settings_orders" href="../settings/order_configure.php">
                                <span class="png_bg">Thông tin đặt hàng</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_SETTINGS_MAIL_CONFIGURE)): ?>
                        <li>
                            <a class="shortcut-button settings_mail" href="../settings/mail_configure.php">
                                <span class="png_bg">Thông tin gửi mail</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_SETTINGS_TASK_CONFIGURE)): ?>
                        <li>
                            <a class="shortcut-button settings_task" href="../settings/task_configure.php">
                                <span class="png_bg">Trọng số cho điểm</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <?php include_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>