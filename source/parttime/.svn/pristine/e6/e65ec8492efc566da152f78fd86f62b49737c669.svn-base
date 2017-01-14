<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_COUPON, F_COUPON_FREELANCER_ASSIGN, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách coupon chờ sử dụng</title>
        <?php 
        require_once '../part/cssjs.php';
        ?>
        
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
        
        <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <script type="text/javascript">
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
                <script type="text/javascript" charset="utf-8">
                        $(function() {
                            var oTable = $('#example').dataTable( {
                                "bProcessing": true,
                                "bServerSide": true,
                                "bPaginate": false,
                                "sAjaxSource": "../ajaxserver/assign_freelancer_list_by_type_server.php?id=<?php echo current_account(UID); ?>&type=assign",
                                "aoColumnDefs": [
                                    { "sClass": "center", "aTargets": [ 4 ] }
                                ],
                                "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                                    $('td:eq(0)', nRow).html("<span class='blue-text'>" + aData[0] + "</span>");
                                    $('td:eq(1)', nRow).html(aData[1]);
                                    $('td:eq(2)', nRow).html("<span class='blue-violet'>" + aData[2] + "</span>");
                                    $('td:eq(3)', nRow).html(aData[3]);
                                    $('td:eq(4)', nRow).html("<span class='blue-text'>" + aData[4] + "</span>");
                                }
                            });
                        });
                </script>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Danh sách coupon chờ sử dụng</h3>
                    </div>
                    <div class="content-box-content tab-content default-tab" id="dt_example">
                        <div id="container">
                            <div id="demo">
                                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                    <thead>
                                        <tr>
                                            <th>Mã coupon</th>
                                            <th>Nhóm coupon</th>
                                            <th>Hạn sử dụng</th>
                                            <th>Loại</th>
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
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>