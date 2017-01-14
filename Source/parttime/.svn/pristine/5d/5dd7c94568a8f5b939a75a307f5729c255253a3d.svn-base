<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ORDERS, F_ORDERS_RESERVATION_LIST, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách đơn hàng chờ duyệt</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <script type="text/javascript" src="../resources/stickytooltip/stickytooltip.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/stickytooltip/stickytooltip.css" />

        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
        </style>
        <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(document).ready(function() {
                $('#example').dataTable();
                $("input[type='text']").addClass("text-input small-input");
            } );
        </script>
    </head>

    <body>
        <div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->

            <?php
            require_once '../part/menu.php';
            ?>

            <div id="main-content"> <!-- Main Content Section with everything -->
                <!-- //++ REQ20120508_BinhLV_N -->
                <noscript>
                    <div class="notification error png_bg">
                        <div>
                            Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
                        </div>
                    </div>
                </noscript>
                <!-- //-- REQ20120508_BinhLV_N -->

                <div class="content-box column-left" style="width:100%"><!-- Start Content Box -->

                    <div class="content-box-header">
                        <h3>Đơn hàng chờ duyệt</h3>
                    </div>

                    <form action="" method="post">
                        <div id="dt_example">
                            <div id="container">
                                <div id="demo">
                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                        <thead>
                                            <tr>
                                                <th class="sorting_asc ui-state-default">Mã hóa đơn</th>
                                                <th class="sorting ui-state-default">Khách hàng</th>
                                                <th class="sorting ui-state-default">Nhóm khách</th>
                                                <th class="sorting ui-state-default">Ngày đặt</th>
                                                <th class="sorting ui-state-default">Ngày giao</th>
                                                <th class="sorting ui-state-default">Thành tiền</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            require_once '../models/donhang.php';
                                            $db = new donhang();
                                            $array = $db->danh_sach_don_hang_cho_duyet();
                                            
                                            foreach ($array as $value) {
                                            ?>
    
                                                <tr>
                                                    <td class=" sorting_1">
                                                        <a href="orderdetail.php?item=<?php echo $value['madon'] ?>"><?php echo $value['madon'] ?></a>
                                                    </td>
                                                    <td>
                                                        <span class="blue">
                                                            <?php echo $value['hoten'] ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="">
                                                            <?php echo $value['tennhom'] ?>
                                                        </span>
                                                    </td>
                                                    <td class="">
                                                        <?php
                                                        //date_default_timezone_set('Europe/London');
                                                        //$datetime = new DateTime($value['ngaydat']);
                                                        //echo $datetime->format("d/m/Y");
                                                        echo $value['ngaydat'];
                                                        ?>
                                                    </td>
                                                    <td>
                                                        <span class="blue">
                                                            <?php 
                                                            //$datetime = new DateTime($value['ngaygiao']);
                                                            //echo $datetime->format("d/m/Y"); 
                                                            echo $value['ngaygiao'];
                                                            ?>
                                                        </span>
                                                    </td>
                                                    <td class="">
                                                        <span class="price"><?php echo number_format($value['thanhtien'], 0, '', '.'); ?></span>
                                                    </td>
                                                </tr>
                                            <?php
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                    <br />
                                    <br />
                                </div>
                            </div>
                        </div>
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