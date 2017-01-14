<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_WORKING_CALENDAR, F_REQUEST_ADD, TRUE);

require_once "../models/phanquyen.php";
$model_pq = new phanquyen();
$manager_id = current_account();
$list_employee = $model_pq->loadEmployee($manager_id );
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Yêu cầu làm thêm</title>
        <?php require_once '../part/cssjs.php'; ?>
       
        <style type="text/css">
            .name { color: blue; font-weight: bolder; }
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #main-content tbody tr.alt-row { background: none; }
            #upload_message span { font-size: 13px; }
            .none {
                display: none;
            }
        </style>
        
        <link rel="stylesheet" href="../resources/chosen/chosen.css">
        <script src="../resources/chosen/chosen.jquery.js" type="text/javascript"></script>
        <script src="../resources/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" src="../resources/scripts/utility/working_calendar/request-add.js"></script>
        <script type="text/javascript">
            listemployee = <?php echo json_encode($list_employee); ?>;
        </script>
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
                        <h3>Yêu cầu làm thêm</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="add_new_request_days" action="../ajaxserver/working_calendar_request_server.php" method="post" target="hidden_upload">
                                <fieldset>
                                    <p>
                                        <table>
                                                <tr>
                                                    <th width="25%"><label>Nhân viên</label></th>
                                                    <td>
                                                        <select  style="width: 150px !important" id="request_employee" name="request_employee">
                                                            <option value="">----</option>
                                                        </select>
                                                        <img id="request_employee_error" name="request_employee_error" class="none" src="../resources/images/icons/cross_circle.png">
                                                    </td>
                                                </tr>

                                                <tr class="none" id="r_max_num_leave">
                                                    <th width="25%"><label>Số ngày nghỉ tối đa</label></th>
                                                    <td>
                                                        <input type="text" id="max_num_leave" readonly="readonly" class="text-input small-input"/>
                                                        <img id="request_employee_error" name="request_employee_error" class="none" src="../resources/images/icons/cross_circle.png">
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <th width="25%"><label>Ngày làm thêm</label></th>
                                                    <td>
                                                        <input type="text" id="request_day" name="request_day"  class="text-input small-input" readonly />
                                                        <img id="request_day_error" class="none" src="../resources/images/icons/cross_circle.png">
                                                    </td>
                                                </tr>

                                                 <tr>
                                                    <th width="25%"><label>Số ngày làm thêm</label></th>
                                                    <td>
                                                        <select  style="width: 150px !important" id="request_day_number" name="request_day_number">
                                                            <option value="">----</option>
                                                        </select>

                                                        <img id="request_day_error" class="none" src="../resources/images/icons/cross_circle.png">
                                                    </td>
                                                </tr>
                                                 <tr>
                                                    <th width="25%"><label>Ghi chú</label></th>
                                                    <td>
                                                       <textarea name="request_days_note" id="request_days_note" cols="15" rows="5"></textarea>
                                                    </td>
                                                </tr>
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
                                        <input type="submit" class="button" value="Xác nhân" name="addrequest" id="addrequest">
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
