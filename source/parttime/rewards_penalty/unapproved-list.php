<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_REWARDS_PENALTY, F_REWARDS_PENALTY_UNAPPROVED_LIST, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách ghi nhận cần approve</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
        </style>
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal !important; }
            .blue-violet { color: blueviolet; font-weight: normal !important; }
            .orange { color: #FF6600; font-weight: normal !important; }
            .bold { font-weight: bolder; }
        </style>
        
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                var oTable = $('#example').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bPaginate": true,
                    "sAjaxSource": "../ajaxserver/rewards_unapproved_list_server.php",
                    "aaSorting": [[ 1, "desc" ]],
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [4] }
                    ],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        $('td:eq(0)', nRow).html(String.format("<a href='../rewards_penalty/detail.php?i={0}' id='div{1}'>{2}</a>", aData[6], iDisplayIndex, aData[0]));
                        $('td:eq(1)', nRow).html(aData[1]);
                        $('td:eq(2)', nRow).html(aData[2]);
                        $('td:eq(3)', nRow).html(aData[3]);
                        $('td:eq(4)', nRow).html(String.format("<span class='blue-text'>{0}</span>", aData[4]));
                        $('td:eq(5)', nRow).html(String.format("<span class='orange'>{0}</span>", aData[5]));
                        
//                         /* Tooltip */
//                         oTable.$('#div' + iDisplayIndex).tooltip({
//                             delay: 50,
//                             showURL: false,
//                             bodyHandler: function() {
//                                 return $("<div></div>").html(aData[7]);
//                             }
//                         });
                    }
                });
            });
        </script>
    </head>

    <body>
        <div id="body-wrapper">
            <?php
            require_once '../part/menu.php';
            ?>
            <div id="main-content">
                <!-- //++ REQ20120508_BinhLV_N -->
                <noscript>
                    <div class="notification error png_bg">
                        <div>
                            Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
                        </div>
                    </div>
                </noscript>
                <!-- //-- REQ20120508_BinhLV_N -->
                <div class="clear"></div>
                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), F_REWARDS_PENALTY_CREATED_LIST)): ?>
                        <li>
                            <a class="shortcut-button finished" href="created-list.php">
                                <span class="png_bg">Bạn đã tạo</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_REWARDS_PENALTY_ASSIGNED_LIST)): ?>
                        <li>
                            <a class="shortcut-button unevaluated" href="assigned-list.php">
                                <span class="png_bg">Ghi nhận về bạn</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_REWARDS_PENALTY_UNAPPROVED_LIST)): ?>
                        <li>
                            <a class="shortcut-button on-going current" href="unapproved-list.php">
                                <span class="png_bg">Cần approve</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Danh sách ghi nhận cần approve</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <div id="dt_example">
                                <div id="container">
                                    <div id="demo">
                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                            <thead>
                                                <tr>
                                                    <th>Nội dung sự kiện</th>
                                                    <th>Ngày giờ</th>
                                                    <th>Người ghi nhận</th>
                                                    <th>Người bị/được ghi nhận</th>
                                                    <th>Mức độ quan trọng</th>
                                                    <th>Mức độ mất mát hoặc đóng góp</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        <div style="padding-bottom: 10px;"></div>
                                    </div>
                                </div>
                            </div>
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