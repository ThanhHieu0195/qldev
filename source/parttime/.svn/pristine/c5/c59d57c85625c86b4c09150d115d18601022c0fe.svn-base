<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ORDERS, F_RETURN_APPROVE, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Chi tiết phiếu trả hàng</title>
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
            #token_table tbody tr.alt-row { background: none; }
            #process_msg{
                
            }
            #process_msg p {
                padding: 10px;
                text-align: center;
                color: #2400FF;
                border: 1px solid #A9A4A4;
                border-radius: 10px;
                box-shadow:  5px 2px 10px #FFE400;
            }
            #process_msg img {
                width: 30px;
                height: 30px;
            }
            #msg_success, #msg_error {
                display: none;
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
        <script type="text/javascript" src="../resources/scripts/utility/returns-details.js"> </script>
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
                    <?php if (verify_access_right(current_account(), F_RETURN_APPROVE)): ?>
                        <li>
                            <a class="shortcut-button on-going" href="../orders/return_approve_list.php">
                                <span class="png_bg">Danh sách cần approve</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Chi tiết phiếu trả hàng</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                        <?php
                        require_once '../models/trahang.php';
                            
                        // Get data and display
                        $id = (isset($_GET['i'])) ? $_GET['i'] : '';
                        $model = new trahang();
                        $result = $model->tim_kiem($id);
                        $th = $result[0];
                        ?>
                        <?php if ($th != NULL): 
                                // Token type
                        ?>
                            <form id="approve_form" action="../orders/returns-detail.php" method="post" target="hidden_approve">
                                <table id="token_table">
                                    <tbody>
                                        <tr>
                                            <td width="20%">
                                                <span class="bold">Mã phiếu</span>
                                            </td>
                                            <td>
                                                <input type="hidden" id="id" name="id" value="<?php echo $th['id']; ?>" />
                                                <span class="blue"><?php echo $th['id']; ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Ngày giờ tạo</span>
                                            </td>
                                            <td>
                                                <span class=""><i><?php echo $th['ngaylap']; ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Mã đơn</span>
                                            </td>
                                            <td>
                                                <span class=""><i id="token_total_items"><a href='../orders/orderdetail.php?item=<?php echo $th['madon'];?>' target='_blank'><?php echo $th['madon']; ?></i></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Tiền trả lại</span>
                                            </td>
                                            <td>
                                                <?php 
                                                    echo $th['tientralai'];
                                         ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Tổng doanh số </span>
                                            </td>
                                            <td>
                                                <?php
                                                    echo $th['tiendoanhso'];
                                                ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Người tạo</span>
                                            </td>
                                            <?php 
                                            $nv = new nhanvien();
                                            ?>
                                            <td>
                                                <span class=""><i><?php echo $nv->get_name($th['manv']); ?></i></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Nguyên nhân</span>
                                            </td>
                                            <td>
                                                <span class="bold"><?php echo $th['nguyennhan']; ?></span>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                                
                                <div class="clear" style="padding: 15px;"></div>
                                
                                <table class="bordered" id="items">
                                    <thead>
                                        <tr id="items_head">
                                            <th>id</th>
                                            <th>Mã đơn</th>
                                            <th>Mã số tranh</th>
                                            <th>Số lượng</th>
                                            <th>Tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody id="items_body">

                                    </tbody>
                                </table>
                                <div class="clear" style="padding: 10px;"></div>
                                <div id="action_panel" style="display:none">
                                    <input class="button" type="button" id="approve_result" name="approve_result" value="Approve" />
                                    <input class="button" type="button" id="reject_result" name="reject_result" value="Reject" />
                                    <input class="button" type="button" id="delete_result" name="delete_result" value="Delete" />
                                </div>
                                <div class="clear" style="padding: 15px;"></div>
                                <div id="process_msg">
                                    <p id="msg_success"><img src="../resources/images/approve.jpg" alt="approved">Thực hiện thao tác thành công</p>
                                    <p id="msg_error"><img src="../resources/images/reject.jpg" alt="error">Thực hiện thao tác thất bại</p>
                                </div>
                            </form>
                        <?php endif; ?>
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
