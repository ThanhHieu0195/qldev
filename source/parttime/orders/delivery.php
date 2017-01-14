<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate ( G_ORDERS, F_ORDERS_DELIVERY, TRUE );
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Giao hàng</title>
        <?php require_once '../part/cssjs.php'; ?>

        <script type="text/javascript" src="../resources/stickytooltip/stickytooltip.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/stickytooltip/stickytooltip.css" />
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
                        <h3>Giao hàng</h3>
                    </div>
                    <div style="padding: 20px">
                        <?php
                        if (isset($_GET['order'])
                            && isset($_GET['item'])
                            && isset($_GET['store']))
                        {
                            $madon = $_GET['order'];
                            $masotranh = $_GET['item'];
                            $makho = $_GET['store'];
                            $soluong = $_GET['amount'];
                            $uid = $_GET['uid'];
                            require_once "../models/deliver.php";
                            // Authenticate
                            $model = new deliver();
                            $listdeliver = $model->getDeliver($madon);
                            if ($listdeliver) { 
                                error_log ("Add new " . json_encode($listdeliver), 3, '/var/log/phpdebug.log');
                            
                            //debug($uid); exit();

                                require_once '../models/donhang.php';

                                $db = new donhang();
                                $output = $db->delivery($madon, $masotranh, $makho, $soluong, $uid);

                                if ($output['result'] == FALSE)
                                {
                                    echo $output['message'];
                                    echo "<a class='button' href='../orders/orderdetail.php?item=" . $madon . "'>Quay lại</a>";
                                }
                                else
                                {
                                    // Cap nhat ngay giao hang
                                    $db->set_delivery_date($madon, date('Y-m-d'));
                                
                                    redirect("../orders/orderdetail.php?item=" . $madon);
                                }
                             } else {
                                    $msg = "Vui lòng chọn nhân viên giao hàng trước khi giao";
                                    echo "<script type='text/javascript'>alert('$msg');window.history.back(); </script>";
                                    //redirect("../orders/orderdetail.php?item=" . $madon);
                             }
                        }      
                        ?>
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