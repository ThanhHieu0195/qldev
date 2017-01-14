<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ORDERS, F_ORDERS_RESERVATION_LIST, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Duyệt đơn hàng</title>
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
                        <h3>Duyệt đơn hàng</h3>
                    </div>
                    <div style="padding: 20px">
                        <?php
                        if (isset($_GET['do']))
                        {
                            require_once '../models/donhang.php';
                            
                            $do = $_GET['do'];
                            $madon = $_GET['item'];
                            $trangthai = $_GET['status'];
                            $dh = new donhang();

                            switch ($do)
                            {
                                case 'approve':  // approve
                                    $output = $dh->approve($madon, $trangthai);
                                    require_once "../models/chitietphanbu.php";
                                    $chitietphanbu = new chitietphanbu();

                                    if ($chitietphanbu->is_exist(array( 'madonhang' => $madon )) && $output==true ) {
                                        $output = $chitietphanbu->update(array('trangthai'=>1), array('madonhang' => $madon) );
                                    }
                                    break;

                                case 'reject':  // reject
                                    $output = $dh->reject($madon);
                                    break;
                            }

                            if ($trangthai == donhang::$DA_GIAO && $output['result'] == FALSE)
                            {
                                echo $output['message'];
                                echo "<a class='button' href='../orders/orderdetail.php?item=" . $madon . "'>Quay lại</a>";
                            }
                            else
                            {
                                //switch ($do)
                                //{
                                //    case 'approve':  // approve
                                //        header("location: ../orders/orderdetail.php?item=" . $madon);
                                //        break;
                                //
                                //    case 'reject':  // reject
                                //        header("location: ../orders/reservationlist.php");
                                //        break;
                                //}
                                header("location: ../orders/reservationlist.php");
                                exit();
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