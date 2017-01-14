<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_WORKING_CALENDAR, F_WORKING_CALENDAR_APPROVE_CALENDAR, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Chi tiết lịch làm việc</title>
        <?php require_once '../part/cssjs.php'; ?>
        <link rel="stylesheet" href="../resources/chosen/chosen.css">
        <style type="text/css" media="all">
          /* fix rtl for demo */
          .chosen-rtl .chosen-drop { left: -9000px; }
        </style>
        <style type="text/css" title="currentStyle">
            @import "../resources/css/practical.css3.tables.css";
            img { vertical-align: middle; }
        </style>
        <style type="text/css">
            .name { color: blue; font-weight: bolder; }
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            
            
            #upload_message span { font-size: 13px; }
            .error { color: #665252; }
            
            div.scroll { /*overflow: auto !important; scrollbar-base-color:#ffeaff !important;*/ }
            div.clear { padding-top: 50px; }
            #dt_example span { font-weight: normal !important; }
            #dt_example table.display td { padding: 10px; }
            #main-content tbody tr.alt-row { background: none; }
            #main-content tbody td.alt-row { background-color: #E2E4FF; }
            #dt_example table.display thead th.weekdays { background-color: #e5e5e5; color: black; }
            #dt_example table.display thead th.sat { background-color: green; color: white; }
            #dt_example table.display thead th.sun { background-color: red; color: white; }
        </style>
        <script type="text/javascript" src="../resources/scripts/utility/working_calendar/add-new.js"></script>
<!--         <script type="text/javascript" src="../resources/scripts/utility/working_calendar/plan-detail.js"></script> -->
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
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Chi tiết lịch làm việc</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <?php 
                            require_once '../models/working_plan.php';
                            
                            // DB model
                            $plan_model = new working_plan();
                            
                            // Get plan detail
                            $i = (isset($_GET['i'])) ? $_GET['i'] : '';
                            $plan = $plan_model->detail($i);
                            
                            if ($plan != NULL && $plan->approved == BIT_FALSE) {
                                //debug($plan);
                            ?>
                            <form id="plan_detail" action="../ajaxserver/working_calendar_add_new.php" method="post" target="hidden_upload">
                                <input type="hidden" name="plan_uid" value="<?php echo $plan->plan_uid; ?>" />
                                <input type="hidden" name="get_plan_detail" value="true" />
                                <div id="dt_example">
                                    <div id="container">
                                        <div id="demo">
                                        </div>
                                        <div>
                                            <div id="upload_notification" class="notification information png_bg" style="display: none;">
                                                <a href="#" class="close"><img src="../resources/images/icons/cross_grey_small.png" title="Close" alt="close"></a>
                                                <div id="upload_message">
                                                    Đã thực hiện sắp xếp lịch làm việc.
                                                </div>
                                            </div>
                                            <div id="actions_panel" style="display: none;">
                                                <!-- Action name -->
                                                <input type="hidden" name="action" id="action" value="" />
                                                <input type="button" class="button" value="Approve" name="approve" id="approve" onclick="return approvePlan('approve', '<?php echo $plan->plan_uid; ?>');" />
                                                <input type="button" class="button" value="Reject" name="reject" id="reject" onclick="return approvePlan('reject', '<?php echo $plan->plan_uid; ?>');" />
                                                <img id="actions_loading" src="../resources/images/loading54.gif" alt="loading" style="display: none;">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <script src="../resources/chosen/chosen.jquery.js" type="text/javascript"></script>
                                <script src="../resources/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
                                <iframe id="hidden_upload" name="hidden_upload" src="" onload="uploadDone('hidden_upload');" 
                                        style="width:0;height:0;border:0px solid #fff">
                                </iframe>
                            </form>
                            <?php } else { ?>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <!-- Dialog -->
                <div id="messages" style="display: none">
                    <h3>Chọn nhân viên</h3>
                    <p>
                        <strong>Tuần: </strong><label id="week_description">18 (05/05 - 11/05/2014)</label><br />
                        <strong>Kho hàng/Chi nhánh: </strong><label id="branch_name">a_Cộng Hòa</label><br />
                    </p>
                    <form id="add_new_worker" action="../ajaxserver/working_calendar_add_new.php" method="post" target="hidden_worker">
                        <input type="hidden" name="dest_plan_uid" id="dest_plan_uid" value="" />
                        <input type="hidden" name="start_date" id="start_date" value="" />
                        <input type="hidden" name="dest_branch" id="dest_branch" value="" />
                        <input type="hidden" name="row_id" id="row_id" value="" />
                        <fieldset>
                            <label>Nhân viên</label><br />
                            <div style="height: 10px"></div>
                            <select name="worker[]" id="worker">
                                <option value=""></option>
                                <?php 
                                require_once '../models/nhanvien.php';
                                
                                $nhanvien = new nhanvien();
                                $arr = $nhanvien->employee_list();
                                if(is_array($arr)):
                                    foreach ($arr as $item):
                                        echo "<option value=\"{$item['manv']}\">{$item['hoten']}</option>";
                                    endforeach;
                                endif;
                                ?>
                            </select>
                            <div style="height: 20px"></div>
                        </fieldset>
                        <fieldset>
                            <label>Các ngày làm việc</label><br />
                            <div style="height: 10px"></div>
                            <input type="checkbox" name="weekdays[]" value="0" checked>T2 &nbsp;<input type="checkbox" name="weekdays[]" value="1" checked>T3
                            <input type="checkbox" name="weekdays[]" value="2" checked>T4 &nbsp;<input type="checkbox" name="weekdays[]" value="3" checked>T5
                            <input type="checkbox" name="weekdays[]" value="4" checked>T6 &nbsp;<input type="checkbox" name="weekdays[]" value="5" checked>T7
                            <input type="checkbox" name="weekdays[]" value="6" checked>CN
                            <div style="height: 20px"></div>
                        </fieldset>
                        <fieldset>
                            <input class="button" type="submit" name="add_workers" value="Sắp xếp" />
                            <div style="height: 10px"></div>
                            <div class="notification error png_bg" id="notification_msg" style="display: none">
                                <div>
                                    Error notification. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Proin vulputate, sapien quis fermentum luctus, libero.
                                </div>
                            </div>
                        </fieldset>
                        <iframe id="hidden_worker" name="hidden_worker" src="" onload="addWorkerDone('hidden_worker');" 
                                style="width:0;height:0;border:0px solid #fff">
                        </iframe>
                    </form>
                </div>
                <?php include_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>