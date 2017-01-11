<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ORDERS, F_ORDERS_SUPPORT_LIST, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách đơn hàng chờ chăm sóc</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
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
                    "sAjaxSource": "../ajaxserver/support_list_server.php",
                    "aaSortingFixed": [[3,'asc']],
                    //"aaSorting": [[ 3, "asc" ]],
                    "bSort": false,
                    //"bJQueryUI": true,
                    /*"aoColumnDefs": [
                        { "sClass": "center", "aTargets": [ 5 ] }
                    ],*/
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        if(aData[0] == '') {
                            $('td:eq(0)', nRow).html("<span class='price'>" + aData[3] + "</span>");
                            $('td:eq(1)', nRow).html('');
                            $('td:eq(2)', nRow).html('');
                            $('td:eq(3)', nRow).html('');
                            $('td:eq(4)', nRow).html('');
                            $('td:eq(5)', nRow).html('');
                        }
                        else {
                            $('td:eq(0)', nRow).html("<a href='../orders/orderdetail.php?item=" + aData[0] + "' id='div" + iDisplayIndex + "'>" + aData[0] + "</a>");
                            $('td:eq(1)', nRow).html("<label style='text-align: center; color: blue;'>" + aData[1] + "</label>");
                            $('td:eq(2)', nRow).html(aData[2]);
                            $('td:eq(3)', nRow).html(aData[3]);
                            $('td:eq(4)', nRow).html("<label style='text-align: center; color: blue;'>" + aData[4] + "</label>");
                            $('td:eq(5)', nRow).html(aData[5]);
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
                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), F_ORDERS_SUPPORT_LIST)): ?>
                        <li>
                            <a class="shortcut-button add-event current" href="support_list.php">
                                <span class="png_bg">Đơn hàng chờ chăm sóc</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_ORDERS_SPECIAL_LIST)): ?>
                        <li>
                            <a class="shortcut-button new-page" href="special_list.php">
                                <span class="png_bg">Đơn hàng cần theo dõi đặc biệt</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <!-- //-- REQ20120508_BinhLV_N -->
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Đơn hàng chờ chăm sóc</h3>
                    </div>
                    <div id="dt_example">
                        <div id="container">
                            <div id="demo">
                                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                    <thead>
                                        <tr>
                                            <th>Mã hóa đơn</th>
                                            <th>Khách hàng</th>
                                            <th>Nhóm khách</th>
                                            <th>Ngày đặt</th>
                                            <th>Ngày giao</th>
                                            <th>Thành tiền</th>
                                            <!--<th>Xóa</th>-->
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