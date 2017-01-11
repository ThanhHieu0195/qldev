<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_FINANCE, array(F_FINANCE_CREATE_RECEIPT, 
                                           F_FINANCE_CREATE_PAYMENT
                                          ),
                                    TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Tạo phiếu thu - chi</title>
        <?php 
        require_once '../part/cssjs.php';
        ?>
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
                <h2>Tạo phiếu thu - chi</h2>
                <p id="page-intro">Chọn chức năng bạn muốn thực hiện:</p>
                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), F_FINANCE_CREATE_RECEIPT)): ?>
                        <li>
                            <a class="shortcut-button receipt" href="../finance/create-receipt.php">
                                <span class="png_bg">Tạo phiếu thu</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_FINANCE_CREATE_PAYMENT)): ?>
                        <li>
                            <a class="shortcut-button payment" href="../finance/create-payment.php">
                                <span class="png_bg">Tạo phiếu chi</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>