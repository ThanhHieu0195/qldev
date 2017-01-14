<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ORDERS, F_ORDERS_CHECKED_LIST, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thống kê đơn hàng đã kiểm tra</title>
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

        <script type="text/javascript" src="../resources/scripts/utility/orders/question_statistic.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/orders/question_statistic_guest_list.js"></script>
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
                        <h3>Thống kê đơn hàng đã kiểm tra</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form action="" method="get">
                                <div>
                                    <?php 
                                        require_once '../models/orders_question.php';
                                        require_once '../models/orders_question_option.php';

                                        $question_model = new orders_question();
                                        $questions = $question_model->get_all();
                                    ?>
                                    <label>Chọn câu hỏi:</label>
                                    <select name="question_id" id="question_id">
                                        <option value="">--- Chọn ---</option>
                                        <?php foreach ($questions as $q): ?>
                                            <option value="<?php echo $q->question_id; ?>"><?php echo $q->content; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                    <span id="error-1" style="color: red"></span> 
                                    <div style="height: 15px"></div>
                                </div>
                                <div>
                                    <a class="blue-text" href="javascript:statistic();" title="Thống kê">
                                        <img width="24px" src="../resources/images/icons/outgoing_32.png" alt="statistic">
                                        Thống kê
                                    </a>
                                    <!--&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a class="blue-text" href="javascript:exportExcel();" target="blank" title="Export file Excel">
                                        <img width="24px" src="../resources/images/icons/excel_32.png" alt="statistic">
                                        Export file Excel
                                    </a>-->
                                </div>
                                <div class="clear" style="padding: 15px;"></div>
                                <table class="bordered" id="tbl_total" style="display: none;">
                                    <thead>
                                        <tr id="tbl_total_head">
                                            <th>Số đơn hàng đã kiểm tra</th>
                                            <th>Số đơn hàng bỏ qua kiểm tra</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr id="tbl_total_body">
                                            <td><div class="box_content_player"><span class="tag belize" id="total_checked">100.000</span></div></td>
                                            <td><div id="total_skipped">50.000</div></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="clear" style="padding: 15px;"></div>
                                <!-- <div id="search_panel" style="float: right; padding-bottom: 3px; display: none;">
                                    <label>Tìm:</label>
                                    <input id="keyword" name="keyword"
                                           class="text-input medium-input" style="width: 175px !important" 
                                           type="search" />
                                    <img style="display: none;" id="keyword_loading" src="../resources/images/loading.gif" alt="keyword_loading">
                                </div> -->
                                <table type="filter" class="bordered" id="items" style="display: none;">
                                    <thead>
                                        <tr id="items_head">
                                            <th>STT</th>
                                            <th>Nội dung/Tiêu chí đánh giá</th>
                                            <th>Số hóa đơn</th>
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
                    <div id="detail_dialog_content">
                        <table class="bordered" id="detail_items">
                            <thead>
                                <tr id="detail_items_head">
                                </tr>
                            </thead>
                            <tbody id="detail_items_body">
                            </tbody>
                        </table>
                    </div>
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