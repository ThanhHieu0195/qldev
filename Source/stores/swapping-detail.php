<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_STORES, F_STORES_SWAP, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Chi tiết phiếu chuyển</title>
        <?php require_once '../part/cssjs.php'; ?>
        <style type="text/css" title="currentStyle">
            @import "../resources/css/practical.css3.tables.css";
            img { vertical-align: middle; }
        </style>
        
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder !important; }
            img { vertical-align: middle; }
            #swapping_table tbody tr.alt-row { background: none; }
            #dt_example span { font-weight: normal !important; }
            form select { -moz-border-radius: 0px; -webkit-border-radius: 0px; border-radius: 0px; }
            #example_processing { padding-top: 30px; padding-bottom: 30px; }
        </style>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <!-- jQuery.bPopup -->
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
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
                <ul class="shortcut-buttons-set">
                    <li>
                        <a class="shortcut-button new-page" href="../stores/draft-list.php">
                            <span class="png_bg">Phiếu đã tạo</span>
                        </a>
                    </li>
                    <li>
                        <a class="shortcut-button outgoing" href="../stores/outgoing-list.php">
                            <span class="png_bg">Chuyển đi</span>
                        </a>
                    </li>
                    <li>
                        <a class="shortcut-button ingoing" href="../stores/ingoing-list.php">
                            <span class="png_bg">Chuyển đến</span>
                        </a>
                    </li>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Chi tiết phiếu chuyển</h3>
                    </div>
                    <div class="content-box-content">
                        <form id="task-detail" action="" method="post">
                            <?php
                            require_once '../models/items_swapping.php';
                            require_once '../models/khohang.php';
                            
                            // Get data and display
                            $swap_uid = (isset($_GET['i'])) ? $_GET['i'] : '';
                            $model = new items_swapping();
                            $item = $model->detail($swap_uid);
                            // Check access right
                            $access = 0;
                            if ($item != NULL) {
                                $access = items_swapping::check_viewing_right(current_account(), $item);
                            }
                            ?>
                            <?php if ($access != 0): ?>

                                <!-- Processing script -->
                                <script type="text/javascript" src="../resources/scripts/utility/stores/swapping.js"></script>

                                <table id="swapping_table">
                                    <tbody>
                                        <tr>
                                            <td width="20%">
                                                <span class="bold">Phiếu chuyển kho</span>
                                            </td>
                                            <td>
                                                <input type="hidden" id="swap_uid" name="swap_uid" value="<?php echo $swap_uid; ?>" />
                                                <span class="blue"><?php echo $item->swap_uid; ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Ngày giờ chuyển</span>
                                            </td>
                                            <td>
                                                <span class=""><i><?php echo dbtime_2_systime($item->created_date, 'H:i:s d/m/Y'); ?></span>
                                            </td>
                                        </tr>
                                        <?php 
                                            $kho = new khohang();
                                        ?>
                                        <tr>
                                            <td>
                                                <span class="bold">Kho chuyển đi</span>
                                            </td>
                                            <td>
                                                <span class=""><i><?php echo $kho->ten_kho($item->from_store); ?></i></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Kho chuyển đến</span>
                                            </td>
                                            <td>
                                                <span class="price"><?php echo $kho->ten_kho($item->to_store); ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Số lượng mã hàng</span>
                                            </td>
                                            <td>
                                                <span class=""><i><?php echo $item->total_amount; ?></i></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Người thực hiện</span>
                                            </td>
                                            <?php 
                                            $nv = new nhanvien();
                                            $tennv = $nv->thong_tin_nhan_vien($item->created_by);
                                            $tennv = (is_array($tennv)) ? $tennv['hoten'] : '';
                                            ?>
                                            <td>
                                                <span class=""><i><?php echo $tennv; ?></i></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><span class="bold">Trạng thái</span></td>
                                            <td>
                                                <?php
                                                $arr = items_swapping::$tokenStyleArr[$item->status];
                                                 ?>
                                                <div id="swap_status" class="box_content_player"><span class="<?php echo $arr['css']; ?>"><?php echo $arr['text']; ?></span></div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <?php
                                            require_once '../models/items_swapping_note.php';

                                            // Note list of this bill
                                            $items_swapping_note = new items_swapping_note();
                                            $note_list = $items_swapping_note->get_notes_list($swap_uid);
                                            ?>
                                            <td>
                                                <span class="bold">Ghi chú:</span>
                                            </td>
                                            <td>
                                                <div id="notes_list">
                                                    <?php foreach ($note_list as $note): ?>
                                                        <div class="notification information png_bg">
                                                            <!--<a class="close" href="#">
                                                                <img alt="close" title="Close this notification" src="">
                                                            </a>-->
                                                            <div>
                                                                <span class="blue-violet"><?php echo(sprintf('%s - %s', $note['create_by'], $note['create_date'])); ?></span><br />
                                                                <?php echo($note['content']); ?>
                                                            </div>
                                                        </div>
                                                    <?php endforeach; ?>
                                                </div>
                                                <div id="note_saving_error" style="display: none" class="notification error png_bg">
                                                    <a class="close" href="#">
                                                        <img alt="close" title="Close this notification" src="../resources/images/icons/cross_grey_small.png">
                                                    </a>
                                                    <div id="note_saving_error_message">zzz</div>
                                                </div>
                                                <textarea id="ghichu" name="ghichu"></textarea>
                                                <div style="float: right;">
                                                    <a id="save_note" href='javascript:saveNote();' title="Lưu ghi chú">
                                                        <img height="24px" width="24px" src="../resources/images/icon_save.jpg" alt="save">
                                                    </a>
                                                    <img id="save_loading" style="display: none" src="../resources/images/loading2.gif" alt="loading">
                                                </div>
                                            </td>
                                        </tr>
                                        <?php if ($item->status == SWAPPING_NEW||$item->status == SWAPPING_COMPLETED): ?>
                                            <tr>
                                                <td colspan="2">
                                                    <div class="bulk-actions align-left">
                                                        <a id="export-panel" title="Xuất phiếu chuyển kho" href="export-swap-token-xls.php?i=<?php echo $swap_uid; ?>" target="blank">
                                                            <img width="24" alt="export" src="../resources/images/icons/excel_32.png"> Xuất phiếu chuyển kho
                                                        </a>
                                                    </div>
                                                    <div class="clear"></div>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                                <div class="clear" style="padding: 15px;"></div>
                                <table class="bordered" id="items">
                                    <thead>
                                        <tr id="items_head">
                                            <th>STT</th>
                                            <th>Mã hàng</th>
                                            <th>Kích thước</th>
                                            <th>Tên hàng</th>
                                            <th>ĐVT</th>
                                            <th>Số lượng</th>
                                            <th>Đơn giá</th>
                                            <th>Trạng thái</th>
                                    </thead>
                                    <tbody id="items_body">
                                    </tbody>
                                </table>
                                <div id="swap_actions" class="clear" style="padding: 20px; display: none;">
                                    <a rel="modal" class="blue-text" href="#messages" title="Nhận tất cả hàng vào kho" onclick="showDialog('<?php echo $swap_uid; ?>', '', '', 'delivery', 'multi');">
                                        <img src="../resources/images/icons/ingoing_32.png" alt="accept-all">
                                        Nhận tất cả hàng đang chờ nhận
                                    </a>
                                    &nbsp;&nbsp;
                                    <a rel="modal" class="blue-text" href="#messages" title="Trả lại tất cả hàng" onclick="showDialog('<?php echo $swap_uid; ?>', '','', 'return', 'multi');">
                                        <img src="../resources/images/icons/outgoing_32.png" alt="reject-all">
                                        Trả lại tất cả hàng đang chờ nhận
                                    </a>
                                </div>
                                <div id="report_shipping" class="clear" style="padding: 20px; display: none;">
                                    <a class="blue-text" href="javascript:" title="Hoàn tất chuyển kho" onclick="reportShipping('accept');">
                                        <img src="../resources/images/icons/outgoing_32.png" alt="ok">
                                      Chuyển hàng
                                    </a>
                                   
                                </div>
                                <div id="report_actions" class="clear" style="padding: 20px; display: none;">
                                    <a class="blue-text" href="javascript:" title="Hoàn tất chuyển kho" onclick="reportSwapping('accept');">
                                        <img src="../resources/images/icons/ok_32.png" alt="ok">
                                        Hoàn tất
                                    </a>
                                    &nbsp;&nbsp;
                                    <a class="blue-text" href="javascript:" title="Hủy bỏ" onclick="reportSwapping('cancel');">
                                        <img src="../resources/images/icons/cancel_32.png" alt="cancel">
                                        Hủy bỏ
                                    </a>
                                </div>
                                <div id="report_msg" style="padding-top: 20px;"></div>
                            <?php endif; ?>
                        </form>
                    </div>
                </div>
                <div id="popup">
                    <span class="button_popup b-close"><span>X</span></span>
                    <div id="notification_msg"></div>
                </div>
                <!-- Dialog -->
                <div id="messages" style="display: none">
                    <h3 id="dialog_title">Xử lý sản phẩm</h3>
                    <p id="dialog_description">
                        <strong>Sản phẩm: </strong><label id="product_name">AN001</label><br />
                        <strong>Số lượng: </strong><label id="amount_name">5</label><br />
                    </p>
                    <form id="swap_processing_form" action="../ajaxserver/items_swapping_server.php" method="post" target="hidden_swap">
                        <input type="hidden" name="item_uid" id="item_uid" value="" /> <!--UID of swapping detail item -->
                        <input type="hidden" name="action" id="action" value="" /> <!--Actions: 'delivery', 'return' -->
                        <input type="hidden" name="swap_type" id="swap_type" value="" /> <!--Type: 'single', 'multi' -->
                        <h6>Ghi chú (nếu có):</h6>
                        <fieldset>
                            <textarea class="textarea" name="note" cols="65" rows="5"></textarea>
                        </fieldset>
                        <fieldset>
                            <input class="button" type="submit" id="swap_processing" name="swap_processing" value="Nhận hàng" />
                            <div style="height: 10px"></div>
                        </fieldset>
                        <iframe id="hidden_swap" name="hidden_swap" src="" onload="processSwappingItem('hidden_swap');" 
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