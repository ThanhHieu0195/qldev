<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_GUEST_DEVELOPMENT, F_GUEST_DEVELOPMENT_STATISTIC_CONTACTED, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thống kê số lượng khách hàng đã liên hệ của nhân viên</title>
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
            #dt_example span { font-weight: normal !important; }
        </style>
        
        <!-- jQuery.bPopup -->
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
        
        <script type="text/javascript" src="../resources/scripts/utility/guest_development/statistic.js"></script>
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
                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), F_GUEST_DEVELOPMENT_STATISTIC_UPDATED)): ?>
                        <li>
                            <a class="shortcut-button on-going" href="../guest_development/statistic-updated.php">
                                <span class="png_bg">Khách hàng được update</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_GUEST_DEVELOPMENT_STATISTIC_CONTACTED)): ?>
                        <li>
                            <a class="shortcut-button add-employee current" href="../guest_development/statistic-contacted.php">
                                <span class="png_bg">Số khách hàng đã liên hệ</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Thống kê số lượng khách hàng đã liên hệ của nhân viên</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form action="" method="get">
                                <div>
                                    <?php 
                                    $from_date = sprintf("%s-%s-01", current_timestamp("Y"), current_timestamp("m"));
                                    $to_date = current_timestamp("Y-m-d");
                                    ?>
                                    <label>Từ ngày (Y-m-d):</label>
                                    <input id="from_date" name="from_date"
                                           class="text-input small-input" style="width: 150px !important"
                                           value="<?php echo $from_date; ?>" 
                                           type="text" readonly="readonly" />
                                    <span id="error-1" style="color: red"></span> 
                                    <div style="height: 10px"></div>
                                </div>
                                <div>
                                    <label>Đến ngày (Y-m-d):</label>
                                    <input id="to_date" name="to_date"
                                           class="text-input small-input" style="width: 150px !important" 
                                           value="<?php echo $to_date; ?>"
                                           type="text" readonly="readonly" />
                                    <span id="error-2" style="color: red"></span>
                                    <div style="height: 20px"></div>
                                </div>
                                <div>
                                    <a class="blue-text" href="javascript:statisticContacted();" title="Thống kê">
                                        <img width="24px" src="../resources/images/icons/outgoing_32.png" alt="statistic">
                                        Thống kê
                                    </a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <a class="blue-text" href="javascript:exportExcel('contacted');" target="blank" title="Export file Excel">
                                        <img width="24px" src="../resources/images/icons/excel_32.png" alt="statistic">
                                        Export file Excel
                                    </a>
                                </div>
                                <div class="clear" style="padding: 15px;"></div>
                                <table class="bordered" id="items">
                                    <thead>
                                        <tr id="items_head">
                                            <th>STT</th>
                                            <th>Nhân viên</th>
                                            <th>Tổng số khách cần liên hệ</th>
                                            <th>Số khách hàng đã liên hệ</th>
                                            <th>Số khách phát sinh doanh số</th>
                                            <th>Doanh số phát sinh</th>
                                    </thead>
                                    <tbody id="items_body">
                                    </tbody>
                                </table>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="detail_dialog" class="bMulti2" style="display: none">
                    <span class="button_popup b-close"><span>X</span></span>
                    <table class="bordered" id="detail_items">
                        <thead>
                            <tr id="detail_items_head">
                            </tr>
                        </thead>
                        <tbody id="detail_items_body">
                        </tbody>
                    </table>
                 </div>
                <div id="popup" style="display: none">
                    <div id="popup_msg"></div>
                </div>
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>