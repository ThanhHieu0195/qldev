<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_TASK, F_TASK_LIST_ALL, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách công việc đang thực hiện</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
            .blue-text { color: blue; font-weight: normal; }
        </style>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                var i = 0;
                var oTable = $('#example').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": "../ajaxserver/task_ongoing_list_server.php",
                    "bSort": false,
                    "bFilter": false,
                    "bJQueryUI": false,
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        if(aData[0] == '') {
                            $('td:eq(0)', nRow).html("<span class='bold blue-text'>" + aData[4] + "</span>").addClass('group');
                            $('td:eq(1)', nRow).html('').addClass('group');
                            $('td:eq(2)', nRow).html('').addClass('group');
                            $('td:eq(3)', nRow).html('').addClass('group');
                            $('td:eq(4)', nRow).html('').addClass('group');
                        }
                        else {
                            $('td:eq(0)', nRow).html("<a href='../task/detail.php?i=" + aData[0] + "' id='div" + iDisplayIndex + "'>" + aData[1] + "</a>");
                            $('td:eq(1)', nRow).html(aData[2]);
                            $('td:eq(2)', nRow).html(aData[3]);
                            $('td:eq(3)', nRow).html(aData[4]);
                            if(aData[5] == 1) {
                                $('td:eq(4)', nRow).html("<div class='box_content_player'><span class='tag belize'>Mới</span></div>");
                            } else {
                                $('td:eq(4)', nRow).html("<div class='box_content_player'><span class='tag pomegranate'>Quá hạn</span></div>");
                            }
                            /* Tooltip */
                            oTable.$('#div' + iDisplayIndex).tooltip({
                                delay: 50,
                                showURL: false,
                                bodyHandler: function() {
                                    return $("<div></div>").html(aData[6]);
                                }
                            });
                        }
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
                    <li>
                        <a class="shortcut-button on-going current" href="ongoing-list.php">
                            <span class="png_bg">Đang thực hiện</span>
                        </a>
                    </li>
                    <li>
                        <a class="shortcut-button finished" href="finished-list.php">
                            <span class="png_bg">Chờ đánh giá</span>
                        </a>
                    </li>
                    <li>
                        <a class="shortcut-button unevaluated" href="unevaluated-list.php">
                            <span class="png_bg">Chờ cho điểm</span>
                        </a>
                    </li>
                    <li>
                        <a class="shortcut-button completed" href="completed-list.php">
                            <span class="png_bg">Xong toàn bộ</span>
                        </a>
                    </li>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Danh sách công việc đang thực hiện</h3>
                    </div>
                    <div id="dt_example">
                        <div id="container">
                            <div id="demo">
                                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                    <thead>
                                        <tr>
                                            <th>Tiêu đề</th>
                                            <th>Người tạo</th>
                                            <th>Người thực hiện</th>
                                            <th>Thời hạn</th>
                                            <th>Trạng thái</th>
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
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>