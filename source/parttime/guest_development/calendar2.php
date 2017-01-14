<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_GUEST_DEVELOPMENT, F_GUEST_DEVELOPMENT_EVENTS, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Lịch sự kiện - liên hệ khách hàng</title>
        <?php require_once '../part/cssjs.php'; ?>
        <style type="text/css">
            #calendar { font-family: "Ubuntu", Helvetica, Arial, sans-serif !important; font-size: 13px !important; line-height: 18px; }
        </style>
        <!-- calander plugin -->
        <link href='../resources/fullcalendar/fullcalendar.css' rel='stylesheet'>
        <link href='../resources/fullcalendar/fullcalendar.print.css' rel='stylesheet' media='print'>
        <script src='../resources/fullcalendar/fullcalendar.min.js'></script>
        
        <!-- jQuery.bPopup -->
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
        
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        
        <script type="text/javascript" src="../resources/scripts/utility/guest_development/calendar.js"></script>
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
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Lịch sự kiện - liên hệ khách hàng</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab" style="display: block;">
                            <div id="calendar"></div>
                        </div>
                    </div>
                </div>
                <div id="popup" style="display: none">
                    <span id="button_close_popup" class="button_popup b-close" style="display: none"><span>X</span></span>
                    <div id="notification_msg"></div>
                </div>
                <?php include_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>