<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_FINANCE, F_FINANCE_APPROVE, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách phiếu thu/chi cần approve</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
        </style>
        <style type="text/css">
            img { vertical-align: middle; }
            #notification_msg span { font-size: 13px; }
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
                var oTable = $('#example').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bPaginate": true,
                    "sAjaxSource": "../ajaxserver/finance_token_approve_list_server.php",
                    "aaSorting": [[ 0, "asc" ]],
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [ 2, 5 ] },
                        { bSortable: false, aTargets: [ 3 ] } // <-- gets columns and turns off sorting
                    ],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        $('td:eq(0)', nRow).html(String.format("<a href='../finance/token-detail.php?i={0}' id='div{1}'>{2}</a>", aData[0], iDisplayIndex, aData[0]));
                        $('td:eq(1)', nRow).html(String.format("<span class='blue-text'>{0}</span>", aData[1]));
                        $('td:eq(2)', nRow).html(aData[2]);
                        $('td:eq(3)', nRow).html(aData[3]);
                        $('td:eq(4)', nRow).html(aData[4]);
                        if(aData[5] == 0) { // Token's type
                            $('td:eq(5)', nRow).html(String.format("<span class='blue-text'>{0}</span>", "Thu"));
                        } else {
                            $('td:eq(5)', nRow).html(String.format("<span class='orange'>{0}</span>", "Chi"));
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
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Danh sách phiếu thu/chi cần approve</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <div id="dt_example">
                                <div id="container">
                                    <div id="demo">
                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                            <thead>
                                                <tr>
                                                    <th>Mã phiếu</th>
                                                    <th>Ngày giờ tạo</th>
                                                    <th>Số hạng mục</th>
                                                    <th>Tổng tiền</th>
                                                    <th>Người tạo</th>
                                                    <th>Loại</th>
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