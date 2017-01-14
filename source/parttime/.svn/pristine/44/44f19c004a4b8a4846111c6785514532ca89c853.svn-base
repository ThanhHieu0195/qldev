<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate('', '', FALSE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Access forbidden</title>
        <?php require_once '../part/cssjs.php'; ?>
        <style type="text/css" title="currentStyle">
            img { vertical-align: middle; }
        </style>
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
                <center>
                    <h2>Xin lỗi, <?php echo current_account(TENNV); ?>!</h2>
                    <p id="page-intro">
                        Bạn không có quyền truy cập chức năng này. Vui lòng liên hệ admin để được trợ giúp!
                        <?php if (isset($_GET['url'])) :?>
                            <br /> <i>(URL vừa truy cập:  <?php echo urldecode($_GET['url']); ?>)</i>
                        <?php endif; ?>
                    </p>
                    <img src="../resources/images/access_denided.png" width="450px" alt="access_forbidden" />
                </center>
                <div class="clear"></div>
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>