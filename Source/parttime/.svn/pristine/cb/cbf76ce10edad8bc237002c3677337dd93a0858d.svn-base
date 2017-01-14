<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_COUPON, F_COUPON_ASSIGN_LIST, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thống kê coupon assign hàng ngày</title>
        <?php 
        require_once '../part/cssjs.php';
        ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
        </style>
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            div#demo { overflow: auto; scrollbar-base-color:#ffeaff; }
        </style>
        
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript">
            $(function() {
                $("#ngay").datepicker({
                        changeMonth: true,
                        changeYear: true
                });

                var oTable = $('#example').dataTable( {
                    "bProcessing": true,
                    "bPaginate": false,
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [ 5 ] }
                    ]
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
                        <h3>Thống kê coupon assign hàng ngày</h3>
                    </div> <!-- End .content-box-header -->
                    <div class="content-box-content">
                        <div class="tab-content default-tab" style="display: block;">
                            <form action="" method="post">
                                <?php
                                require_once '../models/coupon_assign.php';
                                require_once '../models/coupon_group.php';
                                require_once '../models/helper.php';
                                                                        
                                date_default_timezone_set('Asia/Ho_Chi_Minh');
                                $ngay =  date("Y-m-d");
                                if(isset($_POST['view']))
                                {
                                    if (isset($_POST['ngay']))
                                        $ngay = $_POST['ngay'];
                                }
                                
                                $coupon_assign = new coupon_assign();
                                ?>
                                <div>
                                    <label>Ngày (yyyy-mm-dd):</label>
                                    <input id="ngay" name="ngay"
                                           class="text-input small-input" style="width: 150px !important" 
                                           type="text" readonly="readonly" value="<?php echo $ngay ?>" />
                                    <div style="height: 20px"></div>
                                </div>
                                <div>
                                      <input class="button" type="submit" id="view" name="view" value="Tổng hợp" />
                                      <div style="height: 20px"></div>
                                </div>
                                <?php if(isset($_POST['view'])): ?>
                                <div>
                                    <span><?php echo(sprintf("Ngày <b>%s</b> có tất cả <span class='bold blue-text'>%s</span> được assign", $ngay, $coupon_assign->assign_count($ngay))) ?></span>
                                    
                                    <div id="dt_example">
                                        <div id="container">
                                            <div id="demo">
                                                <!-- <div role="grid" class="dataTables_wrapper" id="example_wrapper"> -->
                                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                                        <thead>
                                                            <tr>
                                                                <th>Mã coupon</th>
                                                                <th>Nhóm coupon</th>
                                                                <th>Hạn sử dụng</th>
                                                                <th>Họ tên</th>
                                                                <th>Nhóm khách</th>
                                                                <th>Địa chỉ</th>
                                                                <th>Điện thoại</th>
                                                                <th>Mã hóa đơn</th>
                                                                <th>Thành tiền</th>
                                                                <th>Loại</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        $array = $coupon_assign->assign_list($ngay);
                                                        
                                                        if(is_array($array)):
                                                                            //debug($array);
                                                            $i = 0;
                                                            foreach ($array as $row):
                                                                $i++;
                                                        ?>
                                                            <tr>
                                                                <td class=" blue-text"><?php echo $row['coupon_code']; ?></td>
                                                                <td class=" "><?php echo $row['content']; ?></td>
                                                                <td class=" "><?php echo $row['expire_date']; ?></td>
                                                                <td class=" blue-violet"><?php echo $row['hoten']; ?></td>
                                                                <td class=" "><?php echo $row['tennhom']; ?></td>
                                                                <td class=" "><?php echo $row['diachi']; ?></td>
                                                                <td class=" "><?php echo $row['dienthoai']; ?></td>
                                                                <td class=" "><?php echo $row['bill_code']; ?></td>
                                                                <td class=" orange"><?php echo $row['money']; ?></td>
                                                                <td class=" blue-text" title="<?php echo $row['assign_type']; ?>"><?php echo $row['assign_type']; ?></td>
                                                            </tr>
                                                        <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                    <div style="padding: 10px"></div>
                                                <!-- </div> -->
                                            </div>
                                            <div style="padding: 10px"></div>
                                            <div class="bulk-actions align-left">
                                                <a class="button" href="../phpexcel/export2exel.php?do=export&table=couponassign&date=<?php echo $ngay; ?>">Export file Excel 2003</a>
                                            </div>
                                            <div style="padding: 10px"></div>
                                        </div>
                                    </div>                                    
                                </div>
                                <?php endif; ?>
                             </form>                         
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