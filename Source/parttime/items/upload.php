<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ITEMS, F_ITEMS_UPLOAD, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Quản lý upload sản phẩm</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <script type="text/javascript" src="../resources/scripts/jquery.alphanumeric.js"></script>
        <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                var oTable = $('#example').dataTable({
                    "bProcessing": true,
                    "bPaginate": false,
                    "bSort": true,
                    "bServerSide": true,
                    "sAjaxSource": "../ajaxserver/upload_list_server.php",
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        $('td:eq(0)', nRow).html("<a href='../items/upload_detail.php?item=" + aData[4] + "&file=" + aData[0] + "'>" + aData[0] + "</a>");
                        $('td:eq(1)', nRow).html(aData[1]);
                        $('td:eq(2)', nRow).html(aData[2]);
                        $('td:eq(3)', nRow).html("<span class='blue-text'>" + aData[3] + "</span>");
                    },
                    "aaSorting": [[ 0, "desc" ]]
                });
            });
        </script>
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
        </style>        
        <style type="text/css">
            div#demo { overflow: auto !important; scrollbar-base-color:#ffeaff !important; }
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #dt_example span { font-weight: normal !important; }  
        </style>
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
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Quản lý upload sản phẩm</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                                <div id="dt_example">
                                    <div id="container">
                                        <div id="demo">
                                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                                <thead>
                                                    <tr>
                                                        <th>File</th>
                                                        <th>Ngày</th>
                                                        <th>Giờ</th>
                                                        <th>Nhân viên upload</th>
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
                </div>
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>