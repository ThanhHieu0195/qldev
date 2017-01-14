<!-- request_expenses.php -->
<?php
require_once '../part/common_start_page.php';
do_authenticate(G_FINANCE, F_REQUEST_EXPENSES, TRUE);

    if (isset($_REQUEST['action'])) {
        $status = true;
        $message = "";
        $order_id = $_REQUEST['order_id'];
        $money = $_REQUEST['money'];
        $note  = $_REQUEST['note'];
        $employee_id=current_account();

        $result = "success";

        require_once "../models/danhsachthuchi.php";
        // kiểm tra đơn hàng
        if (!is_empty($order_id)) {
            require_once "../models/donhang.php";
            $model_order = new donhang();
            $status = $model_order->exists($order_id);
        }

        if ($status == true) {
            $listExpenses = new listExpenses();
            $result = $listExpenses->insert('', $employee_id, $order_id, 1, $money, $note, 0, 0);
            if ($result == true) {
                $message = "Thêm thành công";
                $result = "success";
            } else {
                $message = "Thêm thất bại";
                $result = "error";
            }
        } else {
            $result = "error";
            $message = "Đơn hàng không tồn tại trong hệ thống";
        }
    } else {
        $result = "";
    }   
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Phát sinh khoản chi</title>
        <?php require_once '../part/cssjs.php'; ?>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <style type="text/css">
            .none  {
                display: none;
            }
            .form_notification {
                height: 70px;
                width: 40%;
                text-align: center;
                margin: 10px 10px;
                font-size: 15pt;
                color: blue;
            }
            
            #status {
                border-radius: 50px;
                background-color: #000CFF;
                color: #FFFFFF;
                box-shadow: 2px 2px 2px #C3B3B3;
                text-shadow: 2px 2px 2px #C3B3B3;
            }
            .title {
                width: 70px;
                font-weight: bold;
                text-shadow: 1px 1px 1px;
            }
            #submit{
                width: 100px;
                padding: 10px;
                margin: 10px 20px;
            }
            #submit:hover{
                font-weight: bold;
            }
            .content-box{
                width: 40%;
            }

            #frequest {
                text-align: center;
            }
            .space {
                 width: 25%;
            }
            #note {
            }
            .center {
                position: relative;
                left: 20%;
            }
        </style>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
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
                <div class="center">
                    <div class="form_notification">
                        <p id="status" class="none">Thêm thành công</p>
                    </div>
                    
                    <div class="content-box column-left">
                        <div class="content-box-header">
                            <h3>Phát sinh khoản chi</h3>
                        </div>
                        <form id="frequest" action="" method="POST">
                            <input type="hidden" name="action" />
                            <table>
                                <tr>
                                    <td class="space"></td>
                                    <td class="title">Mã đơn</td>
                                    <td><input type="text" name="order_id" id="order_id" placeholder="Nhập mã đơn" /></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="space"></td>
                                    <td class="title">Sô tiền</td>
                                    <td><input type="text" placeholder="Nhập số tiền" id="money" name="money" /></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td class="space"></td>
                                    <td class="title">Ghi chú</td>
                                    <td><textarea placeholder="Nhập ghi chú" id="note" name="note" rows="5"></textarea></td>
                                    <!-- <td><input type="text" placeholder="Nhập ghi chú" id="note" name="note" rows="5"/></td> -->
                                    <td></td>
                            </table>
                            <input type="submit" value="Xác nhận" id="submit" name="submit" />
                        </form>
                    </div>
                </div>
                <?php require_once '../part/footer.php'; ?>

                <!-- thiết lập khung select -->
                <script src="../resources/chosen/chosen.jquery.js" type="text/javascript"></script>
                <script src="../resources/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
                <script type="text/javascript">
                </script>
                <!-- bpopup -->
                <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
                <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
            </div>
        </div>
        <script type="text/javascript">
            var status = "<?php echo $result; ?>";
            if (status != "") {
                var message = '<?php echo $message; ?>';
                $('#status').html(message);
                $('#status').show(500);
                if (status == "success") {
                    $('#status').css('background-color', 'blue');
                } else {
                  $('#status').css('background-color', 'red');
                }
            } else {
                $('#status').hide(500);
            }
            reset();

            function reset() {
                $('#money').val();
                $('#note').val();
                $('#order_id').val();
            }

        </script>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
