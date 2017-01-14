
<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_FINANCE, F_RETURN_WAITING, TRUE);
require_once '../ajaxserver/return_payment_list.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách khoản chi cần chi tiền</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
        </style>
        <link rel="stylesheet" href="../resources/chosen/chosen.css">
        <style type="text/css">
            img { vertical-align: middle; }
            #notification_msg span { font-size: 13px; }
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #dt_example span { font-weight: normal !important; }
            .none {
                display: none;
            }
            #msg p {
                padding: 10px;
                text-align: center;
                color: #2400FF;
                border: 1px solid #A9A4A4;
                border-radius: 10px;
                box-shadow:  5px 2px 10px #FFE400;
            }
            #msg img {
                width: 30px;
                height: 30px;
            }
            #msg_success, #msg_error {
                display: none;
            }

            #btndel {
                margin: 10px;
            }
        </style>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
        <script type="text/javascript" src="../resources/scripts/utility/return_payment_list.js"></script>
        
        <script src="../resources/chosen/chosen.jquery.js" type="text/javascript"></script>
        <script src="../resources/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" src="../resources/scripts/utility/infomation_reference_expenses.js"></script>
        <script type="text/javascript">
            var data_return = [];
            var data_tk = [];
            finance_reference = <?php echo json_encode($finance_reference); ?>;
            finance_product = <?php echo json_encode($finance_product); ?>;
            finance_category = <?php echo json_encode($finance_category); ?>;

            $(function() {
                data_tk = <?php echo json_encode($detail_tk); ?>;
                var html = "";
                var fm = '<option value="{0}">{1}</option>';
                for (var i = 0; i < data_tk.length; i++) {
                    var obj = data_tk[i];
                    html += String.format(fm, obj['taikhoan'], obj['mota']);
                }
                $('#taikhoan').html(html);

                data_return = <?php echo json_encode($arr_return_payment_list); ?>;
                for (var i = 0; i < data_return.length; i++) {
                    var obj = data_return[i];
                    if (obj.id != null) {
                       //console.log(obj);
                       html = "<tr id={0}>{1}</tr>";
                       vhtml="";
                       // // mã phiếu 
                        vhtml+=String.format("<td><a href='../orders/returns-detail.php?i={0}' target='_blank'>{1}</a></td>", obj.id, obj.id);
                        if (obj.loai == "0") {
                            vhtml+=String.format("<td>{0}</td>", "chi trả hàng");
                        } else {
                            vhtml+=String.format("<td>{0}</td>", "chi phí");
                        }
                        vhtml+=String.format("<td><span class='blue-text'>{0}</span></td>", obj.ngaylap);
                        vhtml+=String.format("<td><a href='../orders/orderdetail.php?item={0}' target='_blank'>{1}</a></td>", obj.madon, obj.madon);
                        if (obj.donhangmoi) {
                            vhtml+=String.format("<td><a href='../orders/orderdetail.php?item={0}' target='_blank'>{1}</a></td>", obj.donhangmoi, obj.donhangmoi);
                        } else {
                             vhtml+="<td></td>";
                        }
                        
                        vhtml+=String.format("<td>{0}</td>", number2string(obj.tientralai));
                        vhtml+=String.format("<td>{0}</td>", number2string(obj.chuthich));
                        vhtml+=String.format("<td>{0}</td>", obj.manv);
                        if (obj.status==1) {
                            vhtml+=String.format("<td>{0}</td>", createCashButton(obj.id, obj.madon, obj.tientralai, obj.amount, obj.loai, obj.chuthich));
                        }
                        else {
                            vhtml+=String.format("<td>{0}</td>", "Chưa nhập kho!");
                        }
                        if (obj.loai == "1") {
                            vhtml+=String.format("<td><input type='checkbox' value='{0}' id='{0}' name='checkdel' /></td>", obj.id);
                        } else {
                            vhtml+=String.format("<td></td>");
                        }

                       html = String.format(html, obj.id, vhtml);
                       //console.log(html);
                        $('#example > tbody').append(html);
                    }
                }

                $('#example').dataTable();
                $('#detail_update').click(function(event) {
                    /* Act on the event */
                    return checkReference();
                });

                function checkReference() {
                    var reference_id = $('#reference_id').val();
                    var product_id = $('#product_id').val();
                    var category_id = $('#category_id').val();
                    if (is_empty(reference_id)||is_empty(product_id) ||is_empty(category_id)) {
                        return false;
                    }
                    return true;
                }

                function is_empty(x) {
                    if (x=="") {
                        return true;
                    }
                    return false;
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
                <!-- //-- REQ20120508_BinhLV_N -->
                <div class="clear"></div>
                <ul class="shortcut-buttons-set">
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Danh sách khoản chi cần chi tiền</h3>
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
                                                    <th>Loại</th>
                                                    <th>Ngày giờ tạo</th>
                                                    <th>Mã đơn</th>
                                                    <th>Mã đơn mới</th>
                                                    <th>Tổng chi</th>
                                                    <th>Ghi chú</th>
                                                    <th>Nhân viên</th>
                                                    <th>Trạng thái</th>
                                                    <th><input type="checkbox" value="" id="checkdelall" /></th>
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
                        <div id="msg">
                            <p id="msg_success"><img src="../resources/images/approve.jpg" alt="approved"></p>
                            <p id="msg_error"><img src="../resources/images/reject.jpg" alt="error">Thực hiện thao tác thất bại</p>
                        </div>
                    </div>
                    <?php if (verify_access_right(current_account(), F_EXPENSES_APPROVE)): ?>
                    <input type="button" value="Xóa phiếu" id="btndel" class="button" />
                    <?php endif; ?>

                </div>
               
                <!-- Dialog -->
                <div id="cashing_dialog" class="bMulti3" style="display: none">
                    <span class="button_popup b-close"><span>X</span></span>
                    <h3 id="cashing_dialog_title">Tạo phiếu chi tiền</h3>
                    <p></p>
                    <form id="detail_form" action="../ajaxserver/return_payment_list_server.php" method="post" target="hidden_worker">
                        <input type="hidden" name="id" id="f_id" value="" />
                        <input type="hidden" name="type" id="f_type" value="" />
                        <fieldset>
                           <div>
                            <p>
                                <label>Số tiền cần chi:</label> <label id="moneyr"> </label>
                                <input class="none" type="text" id="donhangid" name="donhangid" />
                                <input class="none" type="text" id="amount" name="amount" />
                                <input id="money_amount" name="money_amount" class="text-input small-input numeric" maxlength="10" type="text" value="" readonly="readonly" hidden>
                            </p>
                           </div>
                           <div>
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
                                <label> Chọn tài khoản thanh toán:</label>
                                <select id="taikhoan" name="taikhoan">
                                </select>
                            </p>
                            <p>
                                <label>Ghi chú</label>
                                 <textarea id="note" name="note" readonly>---------</textarea>
                            </p>
                           </div>
                        </fieldset>
                        <fieldset>
                            <div id="detail_msg">
                            </div>
                            <input class="button" type="submit" id="detail_update" name="detail_update" style="display: block;" value="Thực hiện" />
                            <img id="detail_update_loading" alt="loading" src="../resources/images/loading.gif" style="display: none" />
                        </fieldset>
                        <iframe id="hidden_worker" name="hidden_worker" onload="cashedDone();" class="none">
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
