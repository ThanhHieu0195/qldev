<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_GUEST_DEVELOPMENT, F_GUEST_DEVELOPMENT_ADD_NEW, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thêm khách hàng cần phát triển</title>
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
                <h2>Thêm khách hàng cần phát triển</h2>
                <p id="page-intro">Chọn chức năng bạn muốn thực hiện:</p>
                <ul class="shortcut-buttons-set">
                    <li>
                        <a class="shortcut-button add" href="../guest_development/add-new.php">
                            <span class="png_bg">Thêm khách hàng cần phát triển</span>
                        </a>
                    </li>
                   <!-- <li>
                        <a class="shortcut-button list" href="../guest_development/add-from-db.php">
                            <span class="png_bg">Thêm khách hàng cần phát triển từ hệ thống</span>
                        </a>
                    </li> -->
                </ul>
                <?php include_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
