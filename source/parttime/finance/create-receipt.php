<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_FINANCE, F_FINANCE_CREATE_RECEIPT, TRUE);

// Token type name
$type_names = array (
        FINANCE_RECEIPT => 'thu',
        FINANCE_PAYMENT => 'chi'
);

// Token type
$token_type = FINANCE_RECEIPT;
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Tạo phiếu <?php echo $type_names[$token_type]; ?></title>
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
            .chosen-container { min-width: 220px !important; }
            #detail_form .lb{
                margin: 7px 0px;
                font-weight: bold;
            }
            #detail_form > fieldset > div {
                margin-bottom: 10px;
            }
        </style>
        
        <!-- jQuery.bPopup -->
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
        
        <link rel="stylesheet" href="../resources/chosen/chosen.css">
        <style type="text/css" media="all">
          /* fix rtl for demo */
          .chosen-rtl .chosen-drop { left: -9000px; }
        </style>
        
        <script type="text/javascript" src="../resources/scripts/utility/finance/row_management.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/finance/create.js"></script>
        <script type="text/javascript">
            var typeName = '<?php echo $type_names[$token_type]; ?>';
        </script>
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
                    <?php if (verify_access_right(current_account(), F_FINANCE_CREATE_RECEIPT)): ?>
                        <li>
                            <a class="shortcut-button receipt current" href="../finance/create-receipt.php">
                                <span class="png_bg">Tạo phiếu thu</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_FINANCE_CREATE_PAYMENT)): ?>
                        <li>
                            <a class="shortcut-button payment" href="../finance/create-payment.php">
                                <span class="png_bg">Tạo phiếu chi</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Tạo phiếu <?php echo $type_names[$token_type]; ?></h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="token_form" action="../ajaxserver/finance_server.php" method="post" target="hidden_report">
                                <input type="hidden" name="token_type" id="token_type" value="<?php echo $token_type; ?>" />
                                <input type="hidden" name="token_id" id="token_id" value="" />
                                <div id="loading" style="display: none;">
                                    <center>
                                        <img src="../resources/images/loadig_big.gif" alt="">
                                    </center>
                                </div>
                                <table class="bordered" id="items" style="display: none;">
                                    <thead>
                                        <tr id="items_head">
                                            <th>Số tham chiếu</th>
                                            <th>Mã đơn</th>
                                            <th>Sản phẩm</th>
                                            <th>Loại chi phí</th>
                                            <th>Loại chi phí chi tiết</th>
                                            <th>Người <?php echo $type_names[$token_type]; ?></th>
                                            <th>Số tiền</th>
                                            <th>Tài khoản</th>
                                            <th>Ghi chú</th>
                                            <th>Ngày <?php echo $type_names[$token_type]; ?></th>
                                            <th width="8%">
                                                <a href="javascript:addRow()" title="Thêm dòng mới"><img src="../resources/images/icons/add.png" alt="add"></a>
                                            </th>
                                    </thead>
                                    <tbody id="items_body">
                                    </tbody>
                                </table>
                                <div class="clear" style="padding: 10px;"></div>
                                <div id="action_panel" style="display: none">
                                    <input class="button" type="submit" id="report_token" name="report_token" value="Báo cáo" />
                                </div>
                                <div class="clear" style="padding: 15px;"></div>
                                <div id="process_msg">
                                </div>
                                <iframe id="hidden_report" name="hidden_report" src="" onload="reportDone('hidden_report');" 
                                        style="width:0;height:0;border:0px solid #fff">
                                </iframe>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Dialog -->
                <div id="detail_dialog" class="bMulti3" style="display: none">
                    <span class="button_popup b-close"><span>X</span></span>
                    <h3 id="detail_dialog_title">Chi tiết thu</h3>
                    <p></p>
                    <form id="detail_form" action="../ajaxserver/finance_server.php" method="post" target="hidden_worker">
                        <input type="hidden" name="detail_token_id" id="detail_token_id" value="" />
                        <input type="hidden" name="uid" id="uid" value="" />
                        <input type="hidden" name="action" id="action" value="" /> <!-- Actions: "add", "edit" -->
                        <fieldset>
                            <div>
                                <div class="lb">Số tham chiếu</div>
                                <select name="reference_id" id="reference_id" data-placeholder=" " class="chosen-select">
                                    <option value=""></option>
                                </select>
                                <span class="error_icon input-notification error png_bg" title="Dữ liệu không hợp lệ"></span>
                            </div>
                            <div>
                                <div class="lb">Mã đơn</div>
                                <input type="text" id="madon" name="madon" class="text-input small-input" maxlength="24"/>
                                <span class="error_icon input-notification error png_bg" title="Dữ liệu không hợp lệ"></span>
                            </div>
                            <div>
                                <div class="lb">Sản phẩm</div>
                                <select name="product_id" id="product_id" data-placeholder=" " class="chosen-select">
                                    <option value=""></option>
                                </select>
                                <span class="error_icon input-notification error png_bg" title="Dữ liệu không hợp lệ"></span>
                            </div>
                            <div>
                                <div class="lb">Loại chi phí</div>
                                <select name="category_id" id="category_id" data-placeholder=" " class="chosen-select">
                                    <option value=""></option>
                                </select>
                                <img id="category_loading" alt="loading" src="../resources/images/loading.gif" style="display: none" />
                                <span class="error_icon input-notification error png_bg" title="Dữ liệu không hợp lệ"></span>
                            </div>
                            <div>
                                <div class="lb">Loại chi phí chi tiết</div>
                                <select name="item_id" id="item_id" data-placeholder=" " class="chosen-select">
                                    <option value=""></option>
                                </select>
                                <span class="error_icon input-notification error png_bg" title="Dữ liệu không hợp lệ"></span>
                            </div>
                            <div>
                                <div class="lb">Người <?php echo $type_names[$token_type]; ?></div>
                                <select name="perform_by" id="perform_by" data-placeholder=" " class="chosen-select">
                                    <option value=""></option>
                                </select>
                                <span class="error_icon input-notification error png_bg" title="Dữ liệu không hợp lệ"></span>
                            </div>
                            <div>
                                <div class="lb">Số tiền</div>
                                <input id="money_amount" name="money_amount" class="text-input small-input numeric" maxlength="10" type="text" value="">
                                <span class="error_icon input-notification error png_bg" title="Dữ liệu không hợp lệ"></span>
                            </div>

                            <div>
                                <div class="lb">Tài khoản</div>
                                <!-- VCB, VTB, SCB, TietMat -->
                                <select name="taikhoan" id="taikhoan">
                                   <option value=""></option>
                                </select>
                                <span class="error_icon input-notification error png_bg" title="Dữ liệu không hợp lệ"></span>
                            </div>
                            <div>
                                <div class="lb">Ghi chú</div>
                                <textarea name="note" id="note" rows="3" cols="10"></textarea>
  
                            </div>
                            <div>
                                <div class="lb">Ngày <?php echo $type_names[$token_type]; ?> (Y-m-d)</div>
                                <input type="hidden" id="today" value="<?php echo current_timestamp('Y-m-d'); ?>" />
                                <input id="perform_date" name="perform_date" class="text-input small-input datetime" type="text" readonly="readonly" value="">
                            </div>
                        </fieldset>
                        <fieldset>
                            <div id="detail_msg">
                            </div>
                            <input class="button" type="submit" id="detail_update" name="detail_update" style="display: block;" value="Thực hiện" />
                            <img id="detail_update_loading" alt="loading" src="../resources/images/loading.gif" style="display: none" />
                        </fieldset>
                        <iframe id="hidden_worker" name="hidden_worker" src="" onload="updateDetailDone('hidden_worker');" 
                                style="width:0;height:0;border:0px solid #fff">
                        </iframe>
                        <script src="../resources/chosen/chosen.jquery.js" type="text/javascript"></script>
                        <script src="../resources/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
                        <script type="text/javascript">
                              var config = {
                                '.chosen-select'           : {},
                                '.chosen-select-deselect'  : {allow_single_deselect:true},
                                '.chosen-select-no-single' : {disable_search_threshold:10},
                                '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                                '.chosen-select-width'     : {width:"95%"}
                              };
                              for (var selector in config) {
                                $(selector).chosen(config[selector]);
                              }
                        </script>
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