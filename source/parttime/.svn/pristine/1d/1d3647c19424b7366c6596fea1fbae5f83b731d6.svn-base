<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ORDERS, F_ORDERS_ORDER_DELIVERED, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách đơn hàng đã giao</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
        </style>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        
        <?php
        require_once '../models/donhang.php';
        $don_hang = new donhang();
        ?>
          <!-- jQuery.bPopup -->
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
         <script type="text/javascript" src="../resources/scripts/utility/orders/cashedTableFilter.js"></script>
        
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/orderdelivered.js"></script>
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">

            $(function() {
                var oTable = $('#example').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "sAjaxSource": "../ajaxserver/order_delivered_server.php",
                    "aaSorting": [[ 4, "desc" ]],
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [ 6 ] }
                    ],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        $('td:eq(0)', nRow).html("<a href='../orders/orderdetail.php?item=" + aData[0] + "' id='div" + iDisplayIndex + "'>" + aData[0] + "</a>");
                        $('td:eq(1)', nRow).html("<label style='text-align: center; color: blue;'>" + aData[1] + "</label>");
                        $('td:eq(2)', nRow).html(aData[2]);
                        $('td:eq(3)', nRow).html(aData[3]);
                        $('td:eq(4)', nRow).html("<label style='text-align: center; color: #F60;'>" + aData[4] + "</label>");
                        $('td:eq(5)', nRow).html(aData[5]);
                        $('td:eq(6)', nRow).html(aData[6]);
                        $('td:eq(7)', nRow).html(aData[7]);
                        <?php if (verify_access_right(current_account(), F_ORDERS_ASSIGN_DELIVERED)): ?>
                            $('td:eq(8)', nRow).html("<a title='Assign coupon mới'" +
                                    "   href='../coupon/coupon-assign.php?bill_code=" + aData[0] + "'>" +
                                    "    <img alt='Assign' src='../resources/images/icons/add.png'>Assign</a>");
                        <?php endif; ?>
                        
                        /* Tooltip */
                        oTable.$('#div' + iDisplayIndex).tooltip({
                            delay: 50,
                            showURL: false,
                            bodyHandler: function() {
                                return $("<div></div>").html(aData[8]);
                            }
                        });
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
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Danh sách đơn hàng đã giao</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="excel-export" action="" method="POST">
                                <div>
                                    <label>Từ ngày (yyyy-mm-dd):</label>
                                    <input id="tungay" name="tungay"
                                           class="text-input small-input" style="width: 150px !important"
                                           value="<?php echo (isset($_REQUEST['tungay'])) ? $_REQUEST['tungay'] : '' ?>" 
                                           type="text" readonly="readonly" />
                                    <span id="error-1" style="color: red"></span> 
                                    <div style="height: 10px"></div>
                                </div>
                                <div>
                                    <label>Đến ngày (yyyy-mm-dd):</label>
                                    <input id="denngay" name="denngay"
                                           class="text-input small-input" style="width: 150px !important" 
                                           value="<?php echo (isset($_REQUEST['denngay'])) ? $_REQUEST['denngay'] : '' ?>"
                                           type="text" readonly="readonly" />
                                    <span id="error-2" style="color: red"></span> 
                                    <div style="height: 10px"></div>
                                </div>
                                <div>
                                    <table>
                                        <tr>
                                            <td>
                                                <input class="button" type="button" id="export" name="export" value="Export danh sách hóa đơn" onclick="return export2Excel('1');">
                                           </td>
                                           <td>
                                                <input class="button" type="button" id="export_doanhso_bansi" name="export" value="Export doanh số bán sĩ" onclick="return export2Excel('20');">
                                                 <input class="button" type="button" id="export_doanhso_banle" name="export" value="Export doanh số bán lẻ"  onclick="return export2Excel('21');">
                                           </td>
                                           <td>
                                                <input class="button" type="button" id="export_doanhthu_bansi" name="export" value="Tổng kết bán sĩ"  onclick="return summary('0');">
                                                <input class="button" type="button" id="export_doanhthu_banle" name="export" value="Tổng kết lẻ"  onclick="return summary('1');">
                                           </td>
                                        </tr>
                                    </table>
                                </div>
                            </form>
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
                                                    <th>Hóa đơn đỏ</th>
                                                    <th>Thành tiền</th>
                                                    <th>Số lần assign</th>
                                                    <?php if (verify_access_right(current_account(), F_ORDERS_ASSIGN_DELIVERED)): ?>
                                                        <th>Assign</th>
                                                    <?php endif; ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        <div style="padding-bottom: 10px;"></div>
                                    </div>
                                </div>
                            </div>

                             <div id="dt_sales">
                             <table class="bordered" id="tbl_total" style="display: none;">
                                    <thead>
                                        <tr id="tbl_total_head">
                                            <th>Tổng doanh số</th>
                                            <th>Tổng tiền lãi hiệu chỉnh</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="tbl_total_body">
                                            <td><div class="box_content_player"><span class="tag belize">0</span></div></td>
                                             <td><div class="box_content_player"><span class="tag belize" id="tonglai">0</span></div></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div id="search_panel1" style="float: right; padding-bottom: 3px; display: none;">
                                    <label>Tìm:</label>
                                    <input id="keyword" name="keyword"
                                           class="text-input medium-input" style="width: 175px !important" 
                                           type="search" />
                                    <img style="display: none;" id="keyword_loading" src="../resources/images/loading.gif" alt="keyword_loading">
                                </div>
                                       <table type="filter" class="bordered" id="sales" style="display: none;">
                                    <thead>
                                        <tr id="sales_head">
                                            <th>Tên nhân viên</th>
                                            <th>Doanh số khách hàng cũ</th>                                        
                                            <th>Doanh số khách hàng mới</th>
                                            <th>Tổng doanh số </th>
                                            <th>Doanh số trả lại</th>
                                            <th>Doanh số điều chỉnh</th>
                                            <th>Số lượng khách hàng cũ </th>
                                            <th>Số lượng khách hàng mới </th>
                                            <th>Tiền lãi đơn hàng </th>
                                            <th>Tiền lãi trả hàng </th>
                                            <th>Tiền lãi hiệu chỉnh </th>
                                        </tr>
                                    </thead>
                                    <tbody id="sales_body">
                                    </tbody>
                                </table>
                                        <div style="padding-bottom: 10px;"></div>
                                  
                            </div>
                        </div>
                    </div>
                </div>
                
                  <div id="detail_dialog" class="bMulti2" style="display: none">
                    <span class="button_popup b-close"><span>X</span></span>
                    <table class="bordered" id="detail_items">
                        <thead>
                            <tr id="detail_items_head">
                            </tr>
                        </thead>
                        <tbody id="detail_items_body">
                        </tbody>
                    </table>
                 </div>
                <div id="popup" style="display: none">
                    <div id="popup_msg"></div>
                </div>
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
