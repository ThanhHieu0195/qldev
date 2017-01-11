<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_WORKING_CALENDAR, F_WORKING_CALENDAR_LEAVE_DAYS, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Xin nghỉ phép</title>
        <?php require_once '../part/cssjs.php'; ?>
        <link rel="stylesheet" href="../resources/chosen/chosen.css">
        <style type="text/css" media="all">
          /* fix rtl for demo */
          .chosen-rtl .chosen-drop { left: -9000px; }
        </style>
        <style type="text/css">
            .name { color: blue; font-weight: bolder; }
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #main-content tbody tr.alt-row { background: none; }
            #upload_message span { font-size: 13px; }
        </style>
        <script type="text/javascript" src="../resources/scripts/utility/working_calendar/leave-days-add.js"></script>
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
                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), F_WORKING_CALENDAR_LEAVE_DAYS)): ?>
                        <li>
                            <a class="shortcut-button on-going" href="../working_calendar/leave-days-list.php">
                                <span class="png_bg">Lịch nghỉ phép</span>
                            </a>
                        </li>
                        <li>
                            <a class="shortcut-button add current" href="../working_calendar/leave-days-add.php">
                                <span class="png_bg">Xin nghỉ thêm</span>
                            </a>
                        </li>
                        <li>
                            <a class="shortcut-button switch" href="../working_calendar/leave-days-change.php">
                                <span class="png_bg">Dời ngày nghỉ</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_WORKING_CALENDAR_LEAVE_DAYS_STATISTIC)): ?>
                        <li>
                            <a class="shortcut-button sum" href="../working_calendar/leave-days-statistic.php">
                                <span class="png_bg">Thống kê</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Xin nghỉ phép</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="add_new_leave_days" action="../ajaxserver/working_calendar_leave_days_add.php" method="post" target="hidden_upload">
                                <fieldset>
                                    <div class="notification information png_bg">
                                        <div>
                                            Chú ý khi xin nghỉ phép:
                                            <br />&nbsp;&nbsp;• Nếu muốn xin nghỉ các ngày liên tục từ A đến B thì nhập A vào cột 'Ngày nghỉ' và nhập B vào cột 'Đến ngày'.
                                            <br />&nbsp;&nbsp;• Nếu chỉ xin nghỉ các ngày đơn lẻ, ví dụ: X, Y, Z, ...,  thì tạo ra các dòng tương ứng và điền các ngày này vào cột 'Ngày nghỉ'.
                                        </div>
                                    </div>
                                    <p>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th width="25%"><label>Ngày nghỉ</label></th>
                                                    <th width="25%"><label>Đến ngày</label></th>
                                                    <th><label>Ghi chú</label></th>
                                                    <th width="10%"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="leave_days_list">
                                                <tr>
                                                    <td>
                                                        <input name="leave_days[]" class="text-input small-input date-picker" style="width: 150px !important" readonly type="text" value="">
                                                    </td>
                                                    <td>
                                                        <input name="leave_days_end[]" class="text-input small-input date-picker" style="width: 150px !important" readonly type="text" value="">
                                                    </td>
                                                    <td>
                                                        <input name="leave_days_note[]" class="text-input medium-input" style="width: 95% !important" type="text" value="">
                                                    </td>
                                                    <td>
                                                        <a href="javascript:addRow()" title="Thêm dòng mới"><img src="../resources/images/icons/add.png" alt="Add"></a>
                                                        <a id="clear_0" href="javascript:clearRow('clear_0')" title="Clear dòng này"><img src="../resources/images/icons/clear.png" alt="Clear"></a>
                                                        <!-- <a href="javascript:" class="remove" title="Delete"><img src="../resources/images/icons/cross.png" alt="Delete"></a> -->
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        <div class="clear"></div>
                                    </p>
                                    <p>
                                        <div>
                                            <div id="upload_notification" class="notification information png_bg" style="display: none;">
                                                <a href="#" class="close"><img src="../resources/images/icons/cross_grey_small.png" title="Close" alt="close"></a>
                                                <div id="upload_message">
                                                    Message here!
                                                </div>
                                            </div>
                                        </div>
                                        <input type="submit" class="button" value="Thêm ngày nghỉ" name="submit">
                                        <input type="reset" class="button" value="Làm lại" id="reset" name="reset">
                                    </p>
                                </fieldset>
                                <iframe id="hidden_upload" name="hidden_upload" src="" onload="uploadDone('hidden_upload');" 
                                        style="width:0;height:0;border:0px solid #fff">
                                </iframe>
                            </form>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <?php include_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>