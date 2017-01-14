<?php
require_once '../part/common_start_page.php';
// Authenticate
do_authenticate(G_MANAGER_BUILDING_1, F_LIST_BUILDING_IMPLEMENT, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Danh sách công trình</title>
    <?php require_once '../part/cssjs.php'; ?>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <style type="text/css" title="currentStyle">
        @import "../resources/datatable/css/demo_page.css";
        @import "../resources/datatable/css/demo_table.css";
    </style>
    <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
    <!-- <link rel="stylesheet" type="text/css" href="../resources/css/building/custom-popup.css"> -->
    <!-- jQuery.bPopup -->
    <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
    <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
    <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
    <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
    <!--  -->

    <script type="text/javascript" src="../resources/scripts/utility/building/function-support.js"></script>
    <!-- <script type="text/javascript" src="../resources/scripts/utility/building/detail_category.js"></script> -->
    <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
    <script type="text/javascript">
          $(function() {
            var oTable = $('#example').dataTable( {
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": "../ajaxserver/list_building_server_wait_for_implement.php",
                "aoColumnDefs": [
                    { "sClass": "center", "aTargets": [ 0, 1, 3, 4, 5, 6, 7, 8] }
                ],
                "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                    console.log(aData);
                    $('td:eq(0)', nRow).html( aData[1] );
                    $('td:eq(1)', nRow).html( aData[2] );
                    $('td:eq(2)', nRow).html( aData[3] );
                    $('td:eq(3)', nRow).html( aData[4] );
                    $('td:eq(4)', nRow).html( aData[5] );
                    $('td:eq(5)', nRow).html( aData[6] );
                    $('td:eq(6)', nRow).html( number2string(aData[7]) );
                    
                    var list_status_category = aData[8];
                    var status_category = "";
                    for (var i = 0; i < list_status_category.length; i++) {
                        arr = list_status_category[i];
                        if (arr[0] != null) {
                            status_category += arr[0] + " - " + arr[1] + "<br>";
                        }
                    }
                    $('td:eq(7)', nRow).html(aData[8]);
                    $('td:eq(8)', nRow).html("<a href='detail_building_implement.php?token_id="+aData[0]+"' target='blank'>Chi tiết</a>");
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
        <div id="main-content" style="display: table">
            <noscript>
                <div class="notification error png_bg">
                    <div>
                        Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
                    </div>
                </div>
            </noscript>
            <div class="content-box column-left" style="width:100%">
                <div class="content-box-header">
                    <h3>Danh sách công trình</h3>
                </div>
                <div class="content-box-content">
                    <div class="tab-content default-tab">
                        <div id="dt_example">
                            <div id="container">
                                <div class="detail-category">
                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                        <thead>
                                            <tr>
                                                <th>Tên công trình</th>
                                                <th>Ngày bắt đầu</th>
                                                <th>Ngày kết thúc</th>
                                                <th>Trạng thái</th>
                                                <th>Dự toán</th>
                                                <th>Thực tế</th>
                                                <th>Phát sinh</th>
                                                <th>Đang thi công</th>
                                                <th>Xem</th>
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
        </div>
    </body>
    </html>
    <?php 
    require_once '../part/common_end_page.php';
    ?>
