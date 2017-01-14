<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_WORKING_CALENDAR, F_WORKING_CALENDAR_LEAVE_DAYS, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Dời ngày nghỉ phép</title>
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
        <script type="text/javascript" src="../resources/scripts/utility/working_calendar/leave-days-change.js"></script>
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
                            <a class="shortcut-button add" href="../working_calendar/leave-days-add.php">
                                <span class="png_bg">Xin nghỉ thêm</span>
                            </a>
                        </li>
                        <li>
                            <a class="shortcut-button switch current" href="../working_calendar/leave-days-change.php">
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
                        <h3>Dời ngày nghỉ phép</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <?php 
                            require_once '../models/working_calendar.php';
                            
                            if (isset($_GET['worker'])) {
                                $worker = $_GET['worker'];
                            } else {
                                $worker = current_account();
                            }
                            
                            $model = new working_calendar();
                            $list = $model->leave_days_by_account($worker);
                            ?>
                            <form id="change_leave_days" action="../ajaxserver/working_calendar_leave_days_change.php" method="post" target="hidden_upload">
                                <fieldset>
                                    <?php if (verify_access_right(current_account(), F_WORKING_CALENDAR_LEAVE_DAYS_CHANGE)) { ?>
                                        <p>
                                            <label for="worker">Nhân viên (*)</label>
                                            <select name="worker" id="worker" data-placeholder=" " class="chosen-select" style="width:350px;">
                                                <option value=""></option>
                                                <?php 
                                                require_once '../models/nhanvien.php';
                                                
                                                $nhanvien = new nhanvien();
                                                $arr = $nhanvien->employee_list();
                                                if(is_array($arr)):
                                                    foreach ($arr as $item):
                                                        if ($item['manv'] == $worker) {
                                                            echo "<option value=\"{$item['manv']}\" selected>{$item['hoten']}</option>";
                                                        } else {
                                                            echo "<option value=\"{$item['manv']}\">{$item['hoten']}</option>";
                                                        }
                                                    endforeach;
                                                endif;
                                                ?>
                                            </select>
                                            <span class="error_icon input-notification error png_bg" id="error_worker" title="Nhập dữ liệu"></span>
                                            <br><small>Nhân viên cần thực hiện dời ngày nghỉ.</small>
                                        </p>
                                    <?php } else { ?>
                                        <input name="worker" id="worker" type="hidden" value="<?php echo $worker; ?>" />
                                    <?php } ?>
                                    <p>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th width="25%"><label>Ngày nghỉ (Y-m-d)</label></th>
                                                    <th width="30%"><label>Dời sang ngày (Y-m-d)</label></th>
                                                    <th><label>Ghi chú</label></th>
                                                    <th width="5%"></th>
                                                </tr>
                                            </thead>
                                            <tbody id="leave_days_list">
                                            <?php 
                                            $count = 0;
                                            if (is_array($list)):
                                                foreach ($list as $item):
                                                    $count++;
                                            ?>
                                                <tr>
                                                    <td>
                                                        <span class="blue-text bold"><?php echo $item->working_date; ?></span>
                                                        <input name="leave_days_old[]" type="hidden" value="<?php echo $item->working_date; ?>">
                                                    </td>
                                                    <td>
                                                        <input name="leave_days_new[]" class="text-input small-input date-picker" style="width: 150px !important" readonly type="text" value="">
                                                    </td>
                                                    <td>
                                                        <input name="leave_days_note[]" class="text-input medium-input" style="width: 95% !important" type="text" value="<?php echo $item->note; ?>">
                                                    </td>
                                                    <td>
                                                        <a id="clear_<?php echo $count; ?>" href="javascript:clearRow('clear_<?php echo $count; ?>')" title="Clear dòng này"><img src="../resources/images/icons/clear.png" alt="Clear"></a>
                                                    </td>
                                                </tr>
                                            <?php 
                                                endforeach;
                                            endif;
                                            ?>
                                            </tbody>
                                        </table>
                                        <div class="clear"></div>
                                    </p>
                                    <?php if ($count > 0): ?>
                                    <p>
                                        <div>
                                            <div id="upload_notification" class="notification information png_bg" style="display: none;">
                                                <a href="#" class="close"><img src="../resources/images/icons/cross_grey_small.png" title="Close" alt="close"></a>
                                                <div id="upload_message">
                                                    Message here!
                                                </div>
                                            </div>
                                        </div>
                                        <input type="submit" class="button" value="Dời ngày nghỉ" name="submit">
                                        <span id="error" style="padding-left: 20px" class="require"></span>
                                    </p>
                                    <?php endif; ?>
                                </fieldset>
                                <iframe id="hidden_upload" name="hidden_upload" src="" onload="uploadDone('hidden_upload');" 
                                        style="width:0;height:0;border:0px solid #fff">
                                </iframe>
                                <script src="../resources/chosen/chosen.jquery.js" type="text/javascript"></script>
                                <script src="../resources/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
                                <script type="text/javascript">
                                    var config = {
                                      '.chosen-select'           : {},
                                      '.chosen-select-deselect'  : {allow_single_deselect:true},
                                      '.chosen-select-no-single' : {disable_search_threshold:10},
                                      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                                      '.chosen-select-width'     : {width:"95%"}
                                    };
                                    for (var selector in config) {
                                      $(selector).chosen(config[selector]);
                                    }
                                </script>
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