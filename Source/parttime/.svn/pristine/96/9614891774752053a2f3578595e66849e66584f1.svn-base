<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_GUEST_DEVELOPMENT, array(F_GUEST_DEVELOPMENT_LIST_ASSIGNED, 
                                           F_GUEST_DEVELOPMENT_LIST_ALL, 
                                           F_GUEST_DEVELOPMENT_LIST_CANCELLED,
                                           F_GUEST_DEVELOPMENT_LIST_FAVOURITE
                                          ),
                                    TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách khách hàng</title>
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
                <h2>Danh sách khách hàng</h2>
                <p id="page-intro">Chọn chức năng bạn muốn thực hiện:</p>
                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), F_GUEST_DEVELOPMENT_LIST_ASSIGNED)): ?>
                        <li>
                            <a class="shortcut-button on-going" href="../guest_development/list-assigned.php">
                                <span class="png_bg">Khách hàng đang theo dõi</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_GUEST_DEVELOPMENT_LIST_ALL)): ?>
                        <li>
                            <a class="shortcut-button list" href="../guest_development/list-all.php">
                                <span class="png_bg">Toàn bộ khách đang theo dõi</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_GUEST_DEVELOPMENT_LIST_CANCELLED)): ?>
                        <li>
                            <a class="shortcut-button switch" href="../guest_development/list-cancelled.php">
                                <span class="png_bg">Không cần theo dõi nữa</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_GUEST_DEVELOPMENT_LIST_FAVOURITE)): ?>
                        <li>
                            <a class="shortcut-button finished" href="../guest_development/list-favourite.php">
                                <span class="png_bg">Khách hàng cần quan tâm</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_GUEST_DEVELOPMENT_LIST_ASSIGNED)): ?>
                        <li>
                            <a class="shortcut-button list" href="../guest_development/guestlistnew.php">
                                <span class="png_bg">Danh sách khách hàng chưa phát triển</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_GUEST_DEVELOPMENT_LIST_UNFOLLOW)): ?>
                        <li>
                            <a class="shortcut-button list" href="../guest_development/unfollow.php">
                                <span class="png_bg">Danh sách khách hàng trả về</span>
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
