<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ORDERS, F_ORDERS_TP, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách sản phẩm cần sản xuất</title>
        <?php require_once '../part/cssjs.php'; ?>

        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
        </style>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <style type="text/css">
            img { vertical-align: middle; }
        </style>

        <script type="text/javascript" src="../resources/scripts/jquery.alphanumeric.js"></script>
        <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                var oTable = $('#example').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": "../ajaxserver/tp_list_server.php",
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [ 3 ] }
                    ],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        // Ma so san pham
                        $('td:eq(0)', nRow).html("<a title='Chi tiết' href='../items/tpdetail.php?item=" + aData[0] + "'>" + aData[0] + "</a>");
                        // So luong
                        $('td:eq(3)', nRow).html("<span class='price'>" + aData[3] + "</span>");
                        // Gia ban
                        $('td:eq(4)', nRow).html("<span class='price'>" + aData[4] + "</span>");
                        // Ngay giao
                        $('td:eq(6)', nRow).html("<a title='Chi tiết hóa đơn' href='../orders/orderdetail.php?item=" + aData[11] + "'>" + aData[6] + "</a>");
                    }
                });
            } );
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
                        <h3>Danh sách sản phẩm cần sản xuất</h3>
                    </div>
                    <div id="dt_example">
                        <div id="container">
                            <div id="demo">
                                <?php
                                require_once '../models/dathang.php';
                                
                                // Xoa het cac san pham dat hang khong hop le
                                $dathang = new dathang();
                                $dathang->_xoa_tranh_dat_khong_hop_le();
                                ?>
                                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                    <thead>
                                        <tr>
                                            <th>Mã sản phẩm</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Loại sản phẩm</th>
                                            <th>Số lượng</th>
                                            <th>Giá bán</th>
                                            <th>Showroom</th>
                                            <th>Ngày giao</th>
                                            <th>Ghi chú</th>
                                            <th>Trạng thái</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <div style="margin: 10px;"></div><br />
                                <div class="bulk-actions align-left">
                                    <a class="button" href="../phpexcel/export2exel.php?do=export&table=dathang">Xuất ra dạng Excel 2003</a>
                                    <div style="margin: 30px;"></div>
                                </div>
                            </div>
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