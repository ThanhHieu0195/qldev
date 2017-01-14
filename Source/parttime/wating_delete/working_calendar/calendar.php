<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_WORKING_CALENDAR, F_WORKING_CALENDAR_CALENDAR, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Lịch làm việc</title>
        <?php 
        require_once '../part/cssjs.php';
        ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/css/practical.css3.tables.css";
            img { vertical-align: middle; }
        </style>
        
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            div.scroll { overflow: auto !important; scrollbar-base-color:#ffeaff !important; }
            div.clear { padding-top: 50px; }
            #dt_example span { font-weight: normal !important; }
            #dt_example table.display td { padding: 10px; }
            #main-content tbody tr.alt-row { background-color: #E2E4FF; }
            #main-content tbody td.alt-row { background-color: #E2E4FF; }
            #dt_example table.display thead th.weekdays { background-color: #e5e5e5; color: black; }
            #dt_example table.display thead th.sat { background-color: green; color: white; }
            #dt_example table.display thead th.sun { background-color: red; color: white; }
        </style>
        
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        
        <script type="text/javascript" src="../resources/scripts/utility/working_calendar/calendar.js"></script>
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
                <?php if (verify_access_right(current_account(), F_WORKING_CALENDAR_UPDATE_CALENDAR)): ?>
                    <ul class="shortcut-buttons-set">
                        <?php if (verify_access_right(current_account(), F_WORKING_CALENDAR_CALENDAR)): ?>
                            <li>
                                <a class="shortcut-button calendar-approve current" href="../working_calendar/calendar.php">
                                    <span class="png_bg">Xem lịch làm việc</span>
                                </a>
                            </li>
                        <?php endif; ?>
                        <?php if (verify_access_right(current_account(), F_WORKING_CALENDAR_UPDATE_CALENDAR)): ?>
                            <li>
                                <a class="shortcut-button switch" href="../working_calendar/update-calendar.php">
                                    <span class="png_bg">Cập nhật lịch làm việc</span>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                <?php endif; ?>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Lịch làm việc</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="calendar" action="../ajaxserver/working_calendar_calendar_server.php" method="post" target="hidden_upload">
                                <?php if (verify_access_right(current_account(), F_WORKING_CALENDAR_CALENDAR_BY_TIME)): ?>
                                <div>
                                    <label>Từ ngày (Y-m-d):</label>
                                    <input id="from" name="from"
                                           class="text-input small-input" style="width: 150px !important"
                                           value="" type="text" readonly="readonly" />
                                    <span id="error-1" style="color: red"></span> 
                                    <div style="height: 10px"></div>
                                </div>
                                <div>
                                    <label>Đến ngày (Y-m-d):</label>
                                    <input id="to" name="to"
                                           class="text-input small-input" style="width: 150px !important" 
                                           value="" type="text" readonly="readonly" />
                                    <span id="error-2" style="color: red"></span> 
                                    <div style="height: 10px"></div>
                                </div>
                                <div>
                                    <input class="button" type="submit" id="view" name="view" value="Xem" />
                                    <input class="button" type="submit" id="view_all" name="view_all" value="Xem tất cả" />
                                    <!-- <input class="button" type="button" id="export" name="export" value="Export file Excel 2003" onclick="return export2Excel();" /> -->
                                </div>
                                <?php endif; ?>
                                <div id="dt_example">
                                    <div id="container">
                                        <div id="demo">
                                        </div>
                                    </div>
                                </div>
                                <iframe id="hidden_upload" name="hidden_upload" src="" onload="uploadDone('hidden_upload');" 
                                        style="width:0;height:0;border:0px solid #fff">
                                </iframe>
                            </form>
                        </div>
                    </div>
                </div>
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>