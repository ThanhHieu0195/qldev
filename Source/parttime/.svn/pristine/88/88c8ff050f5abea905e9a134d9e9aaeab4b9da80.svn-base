<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ORDERS, F_ORDERS_CASH_LIST, TRUE);
    require_once "../models/motataikhoan.php";
    require_once "../models/finance_reference.php";
    require_once "../models/finance_product.php";
    require_once "../models/finance_category.php";

    $detail_tk = new detail_tk();
    $detail_tk = $detail_tk->detail_tk();
    $finance_reference = new finance_reference();
    $finance_reference = $finance_reference->get_list();
    $finance_product = new finance_product();
    $finance_product = $finance_product->get_list();
    $finance_category = new finance_category();
    $finance_category = $finance_category->get_list();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách đơn hàng chờ thu tiền</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <link rel="stylesheet" href="../resources/chosen/chosen.css">
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
            .group { font-weight: bold; color: #ff6600; }
            #reference_id {
                width: 120px;
            }
        </style>

        <!-- jQuery.bPopup -->
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
        
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/fnReloadAjax.js"></script>
        <script type="text/javascript" language="javascript" src="../resources/scripts/utility/cashlist.js"></script>

        <script src="../resources/chosen/chosen.jquery.js" type="text/javascript"></script>
        <script src="../resources/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">
           
            finance_reference = <?php echo json_encode($finance_reference); ?>;
            finance_product = <?php echo json_encode($finance_product); ?>;
            finance_category = <?php echo json_encode($finance_category); ?>;

            // 
            TIENTHICONG = '<?php echo TIENTHICONG; ?>';
            TIENCATTHAM = '<?php echo TIENCATTHAM; ?>';
            PHUTHUGIAOHANG = '<?php echo PHUTHUGIAOHANG; ?>';
            THUTIENGIUMKHACHSI = '<?php echo THUTIENGIUMKHACHSI; ?>';

            CASHED_TYPE_TIENTHICONG = '<?php echo CASHED_TYPE_TIENTHICONG; ?>';
            CASHED_TYPE_TIENCATTHAM = '<?php echo CASHED_TYPE_TIENCATTHAM; ?>';
            CASHED_TYPE_PHUTHUGIAOHANG = '<?php echo CASHED_TYPE_PHUTHUGIAOHANG; ?>';
            CASHED_TYPE_THUTIENGIUMKHACHSI = '<?php echo CASHED_TYPE_THUTIENGIUMKHACHSI; ?>';

            html_reference="";
            for (var i = 0; i < finance_reference.length; i++) {
                var obj = finance_reference[i];
                html_reference+=String.format("<option value='{0}'>{1}</option>", obj.reference_id, obj.name);
            }

            html_product="";
            for (var i = 0; i < finance_product.length; i++) {
                var obj = finance_product[i];
                html_product+=String.format("<option value='{0}'>{1}</option>", obj.product_id, obj.name);
            }

            html_category="";
            for (var i = 0; i < finance_category.length; i++) {
                var obj = finance_category[i];
                html_category+=String.format("<option value='{0}'>{1}</option>", obj.category_id, obj.name);
            }

            $(document).ready(function() {
                $('#reference_id').append(html_reference);
                $('#product_id').append(html_product);
                $('#category_id').append(html_category);
                $('#category_id').change(function(event) {
                    /* Act on the event */
                    var category_id = $('#category_id').val();
                     $.ajax({
                        url: "../ajaxserver/finance_server.php",
                        type: 'POST',
                        data: String.format('load_items_by_category={0}&category_id={1}', 'true', category_id),
                        success: function (data, textStatus, jqXHR) {
                            try {
                                var json = jQuery.parseJSON(data);
                                if(json.result == "success") {
                                    // Set items
                                    if (json.items.length != 0) {
                                        for (i = 0; i < json.items.length; i++) {
                                            var d = json.items[i];
                                            
                                            // Add to list
                                            $('#item_id').append(String.format("<option value='{0}'>{1}</option>", d.id, d.name));
                                        }
                                        $("#item_id").trigger("chosen:updated");
                                    }
                                } else {
                                    // Do nothing
                                }
                                
                                loading = false; 
                            }
                            catch(err) {
                                //Handle errors here
                                loading = false; 
                           }
                        },
                        timeout: 15000,      // timeout (in miliseconds)
                        error: function(qXHR, textStatus, errorThrown) {
                            if (textStatus === "timeout") {
                                // request timed out, do whatever you need to do here
                            }
                            else {
                                // some other error occurred
                            }
                            loading = false; 
                        }
                    });
                });
                var config = {
                    '.chosen-select'           : {width:"150px"},
                    '.chosen-select-deselect'  : {allow_single_deselect:true},
                    '.chosen-select-no-single' : {disable_search_threshold:10},
                    '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                    '.chosen-select-width'     : {width:"95%"}
                };
                for (var selector in config) {
                    $(selector).chosen(config[selector]);
                }
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
                    <li>
                        <?php if (verify_access_right(current_account(), F_ORDERS_CASH_STATISTIC)): ?>
                            <a class="shortcut-button new-page" href="cash_statistic.php">
                                <span class="png_bg">Thống kê thu tiền</span>
                            </a>
                        <?php endif; ?>
                    </li>
                </ul>
                <!-- //-- REQ20120508_BinhLV_N -->
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Danh sách đơn hàng chờ thu tiền</h3>
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
                                    <input class="button" type="button" id="export" name="export" value="Export danh sách hóa đơn" 
                                           onclick="return export2Excel();">
                                </div>
                            </form>
                            <hr />
                            <div id="dt_example">
                                <div id="container">
                                    <div id="demo">
                                    Hiển thị các đơn hàng: <input id='check_cho_giao' type="checkbox" checked="checked" onchange="refreshData();" />Chờ giao <input id='check_da_giao' checked="checked" onchange="refreshData();" type="checkbox" />Đã giao 
                                    <div style="height: 20px"></div>
                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                            <thead>
                                                <tr>
                                                    <th style="width: 90px; !important">Mã hóa đơn</th>
                                                    <th>Khách hàng</th>
                                                    <th>Nhóm khách</th>
                                                    <th>Tổng số tiền</th>
                                                    <th>Ngày phải thu tiền</th>
                                                    <th>Số tiền đã thu</th>
                                                    <th>Số tiền còn lại</th>
                                                    <th>Ngày giao hàng</th>
                                                    <th>Hóa đơn đỏ</th>
                                                    <th></th>
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
                <!-- Dialog -->
                <div id="cashing_dialog" class="bMulti3" style="display: none">
                    <span class="button_popup b-close"><span>X</span></span>
                    <h3 id="cashing_dialog_title">Thu tiền hóa đơn</h3>
                    <p></p>
                    <form id="detail_form" action="../ajaxserver/cash_orders_server.php" method="post" target="hidden_worker">
                        <input type="hidden" name="order_id" id="order_id" value="" />
                        <fieldset>
                            <p>
                                <input name="cashing_type" id="cashing_type_partly" type="radio" value="<?php echo CASHED_TYPE_PARTLY; ?>" /> <label>Thu một phần tiền</label>
                            </p>
                            <p>
                                <input name="cashing_type" id="cashing_type_coc" type="radio" value="<?php echo CASHED_TYPE_TIEN_COC; ?>" /> <label>Thu tiền cọc: <span class="price" id="s_type_tien_coc">5.000.000<span></label>
                            </p>
                            <p>
                                <input name="cashing_type" id="cashing_type_all" type="radio" value="<?php echo CASHED_TYPE_ALL; ?>" /> <label>Thu tất cả (Thu hết tiền còn lại của hóa đơn): <span class="price" id="s_type_all">15.000.000</span></label>
                            </p>
                            
                            <p id="c_vat">
                                 <input name="cashing_type" id="cashing_type_vat" type="radio" value="<?php echo CASHED_TYPE_VAT; ?>" /> <label>Thu VAT: <span class="price" id="s_type_vat">0<span></label>
                            </p>
                            <!-- danh sách thu chi -->
                             <p>
                                <input name="cashing_type" id="cashing_type" type="radio" value="<?php echo CASHED_TYPE_TIENTHICONG; ?>" /> <label>thu tiền thi công <span class="price" id="tienthicong">0<span></label>
                            </p>

                            <p>
                                <input name="cashing_type" id="cashing_type" type="radio" value="<?php echo CASHED_TYPE_TIENCATTHAM; ?>" /> <label>thu tiền cắt thảm: <span class="price" id="tiencattham">0<span></label>
                            </p>

                            <p>
                                <input name="cashing_type" id="cashing_type" type="radio" value="<?php echo CASHED_TYPE_PHUTHUGIAOHANG; ?>" /> <label>thu tiền phụ thu giao hàng: <span class="price" id="phuthugiaohang">0<span></label>
                            </p>

                            <p>
                                <input name="cashing_type" id="cashing_type" type="radio" value="<?php echo CASHED_TYPE_THUTIENGIUMKHACHSI; ?>" /> <label>Thu tiền giùm khách sĩ: <span class="price" id="thutiengiumkhachsi">0<span></label>
                            </p>

                            <p>
                            
                                <label>Số tham chiếu</label>
                                <select name="reference_id" id="reference_id" data-placeholder=" " class="chosen-select" required>
                                    <option value="">------</option>
                                </select>
                            </p>

                            <p>
                                <label>Sản phẩm</label>
                                <select name="product_id" id="product_id" data-placeholder=" " class="chosen-select" required>
                                    <option value="">------</option>
                                </select>
                            </p>

                            <p>
                                <label>Loại chi phí</label>
                                <select name="category_id" id="category_id" data-placeholder=" " class="chosen-select" required>
                                    <option value="">------</option>
                                </select>
                            </p>

                            <p>
                                <label>Loại chi phí chi tiết</label>
                                <select name="item_id" id="item_id" data-placeholder=" " class="chosen-select" required>
                                    <option value="">------</option>
                                </select>
                            </p>

                            <p>
                                <label>Tài khoản</label>
                                <select name="taikhoan" id="taikhoan">
                                    <?php for ($i=0; $i < count($detail_tk); $i++) { ?>
                                    
                                    <option value="<?php echo $detail_tk[$i]['taikhoan']; ?>"><?php echo $detail_tk[$i]['mota']; ?></option>

                                    <?php } ?>
                                </select>
                            </p>
                            <p id="c_money_amount">
                                <label>Số tiền</label>
                                <input id="money_amount" name="money_amount" class="text-input small-input numeric" maxlength="10" type="text" value="">
                                <span class="error_icon input-notification error png_bg" title="Dữ liệu không hợp lệ"></span>
                            </p>
                        </fieldset>
                        <fieldset>
                            <div id="detail_msg">
                            </div>
                            <input class="button" type="submit" id="detail_update" name="detail_update" style="display: block;" value="Thực hiện" />
                            <img id="detail_update_loading" alt="loading" src="../resources/images/loading.gif" style="display: none" />
                        </fieldset>
                        <iframe id="hidden_worker" name="hidden_worker" src="" onload="cashedDone('hidden_worker');" 
                                style="width:0;height:0;border:0px solid #fff">
                        </iframe>
                    </form>
                </div>
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';

?>
