<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_TASK, '', TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Dashboard</title>
        <?php require_once '../part/cssjs.php'; ?>
        <link rel="stylesheet" href="../resources/css/message.css" type="text/css" />
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
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
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                var oTable_1 = $('#example_1').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bPaginate": true,
                    "sAjaxSource": "../ajaxserver/task_list_to_me_server.php",
                    "aaSorting": [[ 3, "asc" ]],
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [ 0, 4 ] }
                    ],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        $('td:eq(0)', nRow).html(aData[0]);
                        $('td:eq(1)', nRow).html("<a href='../task/detail.php?i=" + aData[1] + "' id='div" + iDisplayIndex + "'>" + aData[2] + "</a>");
                        $('td:eq(2)', nRow).html(aData[3]);
                        $('td:eq(3)', nRow).html("<span class='blue-text'>" + aData[4] + "</span>");
                        if(aData[5] == 1) {
                            $('td:eq(4)', nRow).html("<div class='box_content_player'><span class='tag belize'>Mới</span></div>");
                        } else {
                            $('td:eq(4)', nRow).html("<div class='box_content_player'><span class='tag pomegranate'>Quá hạn</span></div>");
                        }
                        /* Tooltip */
                        oTable_1.$('#div' + iDisplayIndex).tooltip({
                            delay: 50,
                            showURL: false,
                            bodyHandler: function() {
                                return $("<div></div>").html(aData[6]);
                            }
                        });
                    }
                });

                var oTable_2 = $('#example_2').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bPaginate": true,
                    "sAjaxSource": "../ajaxserver/task_list_by_me_ongoing_server.php",
                    "aaSorting": [[ 3, "asc" ]],
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [ 0, 4 ] }
                    ],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        $('td:eq(0)', nRow).html(aData[0]);
                        $('td:eq(1)', nRow).html("<a href='../task/detail.php?i=" + aData[1] + "' id='div2" + iDisplayIndex + "'>" + aData[2] + "</a>");
                        $('td:eq(2)', nRow).html(aData[3]);
                        $('td:eq(3)', nRow).html("<span class='blue-text'>" + aData[4] + "</span>");
                        if(aData[5] == 1) {  // New
                            $('td:eq(4)', nRow).html("<div class='box_content_player'><span class='tag belize'>Mới</span></div>");
                        } else {
                            $('td:eq(4)', nRow).html("<div class='box_content_player'><span class='tag pomegranate'>Quá hạn</span></div>");
                        }
                        /* Tooltip */
                        oTable_2.$('#div2' + iDisplayIndex).tooltip({
                            delay: 50,
                            showURL: false,
                            bodyHandler: function() {
                                return $("<div></div>").html(aData[6]);
                            }
                        });
                    }
                });

                var oTable_3 = $('#example_3').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bPaginate": true,
                    "sAjaxSource": "../ajaxserver/task_list_by_me_finished_server.php",
                    "aaSorting": [[ 4, "asc" ]],
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [ 0, 5 ] }
                    ],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        $('td:eq(0)', nRow).html(aData[0]);
                        $('td:eq(1)', nRow).html("<a href='../task/detail.php?i=" + aData[1] + "' id='div3" + iDisplayIndex + "'>" + aData[2] + "</a>");
                        $('td:eq(2)', nRow).html(aData[3]);
                        $('td:eq(3)', nRow).html(aData[4]);
                        $('td:eq(4)', nRow).html("<span class='blue-text'>" + aData[5] + "</span>");
                        if(aData[6] == 3) { // Finished
                            $('td:eq(5)', nRow).html("<div class='box_content_player'><span class='tag turquoise'>Xong đúng hạn</span></div>");
                        } else {
                            $('td:eq(5)', nRow).html("<div class='box_content_player'><span class='tag orange'>Xong quá hạn</span></div>");
                        }
                        /* Tooltip */
                        oTable_3.$('#div3' + iDisplayIndex).tooltip({
                            delay: 50,
                            showURL: false,
                            bodyHandler: function() {
                                return $("<div></div>").html(aData[7]);
                            }
                        });
                    }
                });

                // Refresh data
                $("a[name='refresh_data']").click(function() {
                    $('#example_1').dataTable()._fnAjaxUpdate();
                    $('#example_2').dataTable()._fnAjaxUpdate();
                    $('#example_3').dataTable()._fnAjaxUpdate();
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
                
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Danh sách công việc của bạn</h3>
                    <div class="clear"></div>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab" id="dt_example">
                            <div id="container">
                                <div id="demo">
                                    <hr />
                                    <h4 style="color: blue">Công việc bạn được giao
                                        <a name="refresh_data" href="javascript:" title="Tải lại dữ liệu của các bảng">
                                            <img src="../resources/images/icons/refresh_32.png" alt="refresh" />
                                        </a>
                                    </h4>
                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example_1">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Tiêu đề công việc</th>
                                                <th>Người tạo</th>
                                                <th>Thời hạn hoàn thành</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <div style="padding: 35px"></div>
                                    <hr />
                                    <h4 style="color: #ff6600">Công việc bạn đang giao cho người khác làm
                                        <a name="refresh_data" href="javascript:" title="Tải lại dữ liệu của các bảng">
                                            <img src="../resources/images/icons/refresh_32.png" alt="refresh" />
                                        </a>
                                    </h4>
                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example_2">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Tiêu đề công việc</th>
                                                <th>Người thực hiện</th>
                                                <th>Thời hạn hoàn thành</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <div style="padding: 35px"></div>
                                    <hr />
                                    <h4 style="color: blueviolet">Công việc bạn đã giao cho người khác và họ đã làm xong – cần đánh giá
                                        <a name="refresh_data" href="javascript:" title="Tải lại dữ liệu của các bảng">
                                            <img src="../resources/images/icons/refresh_32.png" alt="refresh" />
                                        </a>
                                    </h4>
                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example_3">
                                        <thead>
                                            <tr>
                                                <th>STT</th>
                                                <th>Tiêu đề công việc</th>
                                                <th>Người thực hiện</th>
                                                <th>Thời hạn hoàn thành</th>
                                                <th>Ngày thực hiện</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
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