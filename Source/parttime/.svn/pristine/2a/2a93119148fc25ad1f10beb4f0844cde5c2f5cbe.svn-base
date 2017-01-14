<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate ( G_WORKING_CALENDAR, array (
        F_WORKING_CALENDAR_APPROVE_CALENDAR,
        F_WORKING_CALENDAR_APPROVE_LEAVE_DAYS_ADD,
        F_WORKING_CALENDAR_APPROVE_LEAVE_DAYS_CHANGE 
), TRUE );

// Reset site function
//set_site_function(get_site_function(KEY_GROUP, ''));
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Approve menu</title>
        <?php 
        require_once '../part/cssjs.php';
        ?>
    </head><body>
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
                <!-- Page Head -->
                <h2>Approve menu</h2>
                <p id="page-intro">Chọn chức năng bạn muốn thực hiện:</p>
                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), F_WORKING_CALENDAR_APPROVE_CALENDAR)): ?>
                        <li>
                            <a class="shortcut-button calendar-approve" href="../working_calendar/approve-calendar.php">
                                <span class="png_bg">Approve lịch làm việc</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_WORKING_CALENDAR_APPROVE_LEAVE_DAYS_ADD)): ?>
                        <li>
                            <a class="shortcut-button add" href="../working_calendar/approve-leave-days-add.php">
                                <span class="png_bg">Approve xin nghỉ thêm</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_WORKING_CALENDAR_APPROVE_LEAVE_DAYS_CHANGE)): ?>
                        <li>
                            <a class="shortcut-button switch" href="../working_calendar/approve-leave-days-change.php">
                                <span class="png_bg">Approve dời ngày nghỉ</span>
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