<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ORDERS, F_ORDERS_DETAIL_LIST, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Đơn hàng</title>
        <?php 
        require_once '../part/cssjs.php';
        ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/css/practical.css3.tables.css";
            img { vertical-align: middle; }
        </style>
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #dt_example span { font-weight: normal !important; }
            #main-content tbody tr.alt-row { background: none; }
        </style>
        
          <!-- jQuery.bPopup -->
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
        
        <script type="text/javascript" src="../resources/scripts/utility/orders/order_statistic.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/orders/cashedTableFilter.js"></script>
    </head><body>
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
                <ul class="shortcut-buttons-set">
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Đơn hàng</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form action="" method="get">
                                <div>
                                    <?php
                                    $filter = (isset($_REQUEST['filter']));
                                    if ($filter) {
                                        $from_date = isset($_REQUEST['from']) ? $_REQUEST['from'] : '';
                                        $to_date = isset($_REQUEST['to']) ? $_REQUEST['to'] : '';
                                        $cashier = isset($_REQUEST['cashier']) ? $_REQUEST['cashier'] : '';
                                    }
                                    else {
                                        $from_date = sprintf("%s-%s-01", current_timestamp("Y"), current_timestamp("m"));
                                        $to_date = current_timestamp("Y-m-d");
                                        $cashier = '';
                                    }
                                    ?>
                                    <label>Từ ngày (Y-m-d):</label>
                                    <input id="from_date" name="from_date"
                                           class="text-input small-input" style="width: 150px !important"
                                           value="<?php echo $from_date; ?>" 
                                           type="text" readonly="readonly" />
                                    <span id="error-1" style="color: red"></span> 
                                    <div style="height: 10px"></div>
                                </div>
                                <div>
                                    <label>Đến ngày (Y-m-d):</label>
                                    <input id="to_date" name="to_date"
                                           class="text-input small-input" style="width: 150px !important" 
                                           value="<?php echo $to_date; ?>"
                                           type="text" readonly="readonly" />
                                    <span id="error-2" style="color: red"></span>
                                    <div style="height: 20px"></div>
                                </div>
                                <div>
                                    <label>Nhân viên:</label>
                                    <select name="cashier" id="cashier">
                                        <option value="">-- Tất cả --</option>
                                        <?php 
                                        require_once '../models/nhanvien.php';
                                        
                                        $nhanvien = new nhanvien();
                                        $arr = $nhanvien->employee_list();
                                        if(is_array($arr)):
                                            foreach ($arr as $item):
                                                $selected = '';
                                                if ($cashier == $item['manv']) {
                                                    $selected = 'selected';
                                                }
                                                echo "<option {$selected} value=\"{$item['manv']}\">{$item['hoten']}</option>";
                                             endforeach;
                                        endif;
                                        ?>
                                    </select>
                                    <div style="height: 20px"></div>
                                </div>
                                <div>
                                    <a class="blue-text" href="javascript:statistic();" title="Thống kê">
                                        <img width="24px" src="../resources/images/icons/outgoing_32.png" alt="statistic">
                                        Xem danh sách
                                    </a>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <a class="blue-text" href="javascript:exportExcel();" target="blank" title="Export file Excel">
                                        <img width="24px" src="../resources/images/icons/excel_32.png" alt="statistic">
                                        Export file excel
                                    </a>
                                     <a class="blue-text" href="javascript:summary();" target="blank" title="Export file Excel">
                                        <img width="24px" src="../resources/images/icons/currency_dollar_blue_48.png" alt="statistic">
                                        Tổng kết
                                    </a>
                                    
                                </div>
                                <div class="clear" style="padding: 15px;"></div>
                                <table class="bordered" id="tbl_total" style="display: none;">
                                    <thead>
                                        <tr id="tbl_total_head">
                                            <th>Tổng doanh số</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="tbl_total_body">
                                            <td><div class="box_content_player"><span class="tag belize">100.000</span></div></td>
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
                                              <th>Số lượng khách hàng cũ </th>
                                                <th>Số lượng khách hàng mới </th>
                                        </tr>
                                    </thead>
                                    <tbody id="sales_body">
                                    </tbody>
                                </table>
                                <div class="clear" style="padding: 15px;"></div>
                                <div id="search_panel" style="float: right; padding-bottom: 3px; display: none;">
                                    <label>Tìm:</label>
                                    <input id="keyword" name="keyword"
                                           class="text-input medium-input" style="width: 175px !important" 
                                           type="search" />
                                    <img style="display: none;" id="keyword_loading" src="../resources/images/loading.gif" alt="keyword_loading">
                                </div>
                                <table type="filter" class="bordered" id="items" style="display: none;">
                                    <thead>
                                        <tr id="items_head">
                                            <th>Mã hóa đơn</th>
                                            <th>Nhóm khách hàng</th>                                        
                                            <th>Tổng tiền</th>
                                            <th>Tiền giảm</th>
                                            <th>Phần trăm giảm</th>
                                             <th>Doanh số</th>
                                            <th>Nhân viên bán</th>
                                            <th>Khách mua lần</th>
                                              
                                            <th>Ngày đặt</th>
                                               <th>Trạng thái</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody id="items_body">
                                    </tbody>
                                </table>
                                <div id="loading" style="display: none;">
                                    <center>
                                        <img src="../resources/images/loadig_big.gif" alt="">
                                    </center>
                                </div>
                            </form>
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
        <script type="text/javascript" charset="utf-8">
            $(function() {
                // Auto load data
                <?php if (isset($filter) && $filter): ?>
                    statistic();
                <?php endif; ?>
            });
        </script>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>