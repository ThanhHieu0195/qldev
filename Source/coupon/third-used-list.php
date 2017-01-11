<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_COUPON, F_COUPON_THIRD_USED, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách coupon giới thiệu</title>
        <?php 
        require_once '../part/cssjs.php';
        ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
        </style>
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
        </style>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        
        <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <script type="text/javascript">
            $(function() {
                $('#example').dataTable( {
                    "bProcessing": true,
                    "bSort": false,
                    "bPaginate": false,
                    "bFilter": true
                });

                // tooltip
                $('.tooltip').tooltip({
                    delay : 50,
                    showURL : false,
                    bodyHandler : function() {
                        return $("<div></div").html($($(this).attr('data-tooltip')).html());
                    }
                });
            });
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
                <div class="clear"></div>
                <!-- End .content-box -->
                <div class="content-box column-left" style="width:100%"><!-- Start Content Box -->
                    <div class="content-box-header">
                        <h3>Danh sách coupon giới thiệu</h3>
                    </div> <!-- End .content-box-header -->
                    <div class="content-box-content">
                        <div class="tab-content default-tab" style="display: block;">
                                <?php
                                require_once '../models/coupon_third_used.php';
                                require_once '../models/helper.php';
                                require_once '../models/donhang.php';
                                
                                $third_used = new coupon_third_used();
                                $array = $third_used->third_used_list();
                                ?>
                                <div>
                                    <div id="dt_example">
                                        <div id="container">
                                            <div id="demo">
                                                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                                    <thead>
                                                        <tr>
                                                            <th>Mã coupon</th>
                                                            <th>Khách hàng được assign</th>
                                                            <th>Khách hàng sử dụng</th>
                                                            <th>Hóa đơn</th>
                                                            <th>Ngày sử dụng</th>
                                                            <th>Assign</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        if(is_array($array)):
                                                            $i = 0;
                                                            foreach ($array as $row):
                                                                $i++;
                                                        ?>
                                                        <tr>
                                                            <td class="blue-text"><?php echo $row['coupon_code']; ?></td>
                                                            <td><?php echo $row['assign_name']; ?></td>
                                                            <td class="orange"><?php echo $row['used_name']; ?></td>
                                                            <td>
                                                                <a class="tooltip" data-tooltip="#tooltip<?php echo $i; ?>" href="../orders/orderdetail.php?item=HD2909001"><?php echo $row['bill_code']; ?></a>
                                                            </td>
                                                            <td>
                                                                <?php echo $row['used_date']; ?>
                                                            </td>
                                                            <td>
                                                                <a title="Assign coupon" href="../coupon/third-used-assign.php?assign_to=<?php echo $row['assign_to']; ?>&bill_code=<?php echo $row['bill_code']; ?>&coupon_code=<?php echo $row['coupon_code']; ?>">
                                                                    <img alt="add" src="../resources/images/icons/add.png">Assign
                                                                </a>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <?php
                                                if(is_array($array)):
                                                    $i = 0;
                                                    $donhang = new donhang();
                                                    foreach ($array as $row):
                                                        $i++;
                                                ?>
                                                <div id="tooltip-items" style="display: none;">
                                                    <div id="tooltip<?php echo $i; ?>">
                                                        <?php echo $donhang->danh_sach_ma_so_tranh_dat_mua($row['bill_code']); ?>
                                                    </div>
                                                </div>
                                                <?php
                                                    endforeach;
                                                endif;
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div> <!-- End .content-box -->

                <?php require_once '../part/footer.php'; ?>

            </div> <!-- End #main-content -->

        </div>       
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>