<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ORDERS, F_ORDERS_DIFFERENCE, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thống kê số lượng chênh lệch</title>
        <?php require_once '../part/cssjs.php'; ?>

        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
        </style>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <style type="text/css">
            img { vertical-align: middle; }
        </style>

        <script type="text/javascript" src="../resources/scripts/jquery.alphanumeric.js"></script>
        <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                // datatable
                var oTable = $('#example').dataTable();

                // tooltip
                $('a[class="tooltip"]').tooltip({
                    delay: 50,
                    showURL: false,
                    bodyHandler: function() {
                        return $("<img />").attr("src", $(this).attr('src'));
                    }
                });
            } );
        </script>
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
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Thống kê số lượng chênh lệch</h3>
                    </div>
                    <div id="dt_example">
                        <div id="container">
                            <div id="demo">
                                <?php
                                require_once '../models/tonkho.php';
                                
                                $ton_kho = new tonkho();
                                $array = $ton_kho->thong_ke_so_luong_chenh_lech();                                
                                ?>
                                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                    <thead>
                                        <tr>
                                            <th>Mã sản phẩm</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Loại sản phẩm</th>
                                            <th>Tổng số lượng trong kho</th>
                                            <th>Tổng số lượng cần cung cấp</th>
                                            <th>Số lượng cần sản xuất thêm</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if(is_array($array)):
                                        foreach ($array as $row):
                                    ?>
                                        <tr>
                                            <td><a class="tooltip" src="<?php echo '../' . $row['hinhanh']; ?>" href="./items/itemdetail.php?item=<?php echo $row['masotranh']; ?>"><?php echo $row['masotranh']; ?></a></td>
                                            <td><?php echo $row['tentranh']; ?></td>
                                            <td><?php echo $row['loaitranh']; ?></td>
                                            <td><?php echo $row['soluongton']; ?></td>
                                            <td><?php echo $row['soluongmua']; ?></td>
                                            <td><span class="price"><?php echo $row['soluongcan']; ?></span></td>
                                        </tr>
                                    <?php    
                                        endforeach;
                                    endif;
                                    ?>
                                    </tbody>
                                </table>
                                <div style="margin: 10px;"></div><br />
                                <div class="bulk-actions align-left">
                                    <a class="button" href="../phpexcel/export2exel.php?do=export&table=chenhlech">Xuất ra dạng Excel 2003</a>
                                    <div style="margin: 30px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>