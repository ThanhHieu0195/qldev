<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_WORKING_CALENDAR, F_WORKING_CALENDAR_APPROVE_LEAVE_DAYS_ADD, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Approve xin nghỉ thêm</title>
        <?php 
        require_once '../part/cssjs.php';
        ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
            .text { padding: .4em; }
            .small-padding { padding: 1px !important; -webkit-border-radius: 0 !important; border-radius: 0 !important; }
        </style>
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #dt_example span { font-weight: normal !important; }
        </style>
        
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        
        <script type="text/javascript" src="../resources/scripts/utility/working_calendar/approve-leave-days-add.js"></script>
        <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                var enable = false;
                $('#action-panel').hide();
                
                $('#example').dataTable({
                    "bProcessing": true,
                    "bPaginate": true,
                    "bSort": true,
                    "bFilter": true,
                    "bServerSide": true,
                    "sAjaxSource": "../ajaxserver/working_calendar_leave_days_add_list_server.php",
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        $('td:eq(0)', nRow).html(String.format("<input type='checkbox' id='leave_days_{0}' name='leave_days[]' value='{1}'>", iDisplayIndex, aData[0]));
                        $('td:eq(1)', nRow).html(String.format("<span class='blue-text'>{0}</span>", aData[1]));
                        $('td:eq(2)', nRow).html(String.format("<span class='orange'>{0}</span>", aData[2]));
                        $('td:eq(3)', nRow).html(aData[3]);

                        if (enable == false) {
                            enable = true;
                            $('#action-panel').show();
                        }
                    },
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [0] },
                        { bSortable: false, aTargets: [ 0 ] } // <-- gets first column and turns off sorting
                    ]
                });

                $("input[aria-controls='example']").addClass("text-input small-input small-padding");
                $("select[aria-controls='example']").addClass("small-padding");
                // $('input[aria-controls="example"]').tooltip({
                     // delay: 50,
                     // showURL: false,
                     // bodyHandler: function() {
                         // return $("<div class='orange'></div>").html('Tìm theo mã/tên dụng cụ');
                     // }
                 // });
            });
        </script>
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
                    <?php if (verify_access_right(current_account(), F_WORKING_CALENDAR_APPROVE_CALENDAR)): ?>
                        <li>
                            <a class="shortcut-button calendar-approve" href="../working_calendar/approve-calendar.php">
                                <span class="png_bg">Approve lịch làm việc</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_WORKING_CALENDAR_APPROVE_LEAVE_DAYS_ADD)): ?>
                        <li>
                            <a class="shortcut-button add current" href="../working_calendar/approve-leave-days-add.php">
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
                        <h3>Approve xin nghỉ thêm</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="approve-leave-days-add" action="../ajaxserver/working_calendar_approve_leave_days_add.php" method="post" target="hidden_upload">
                                <div id="dt_example">
                                    <div id="container">
                                        <div id="demo">
                                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                                <thead>
                                                    <tr>
                                                        <th><input class="check-all" type="checkbox"></th>
                                                        <th>Nhân viên</th>
                                                        <th>Ngày nghỉ</th>
                                                        <th>Ghi chú</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                            <div style="margin: 30px;"></div>
                                            <div id="action-panel" class="bulk-actions align-left">
                                                <input type="submit" name="approve" value="Approve" class="button" />
                                                <input type="submit" name="reject" value="Reject" class="button" />
                                                <span id="error" style="padding-left: 20px" class="require"></span>
                                            </div>
                                            <div class="clear"></div>
                                            <div>
                                                <div id="upload_notification" class="notification information png_bg" style="display: none;">
                                                    <a href="#" class="close"><img src="../resources/images/icons/cross_grey_small.png" title="Close" alt="close"></a>
                                                    <div id="upload_message">
                                                        Message here!
                                                    </div>
                                                </div>
                                            </div>
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