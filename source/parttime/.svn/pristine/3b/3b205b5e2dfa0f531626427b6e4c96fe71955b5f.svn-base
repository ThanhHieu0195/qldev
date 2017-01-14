<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_COUPON, F_COUPON_GROUP, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Nhóm coupon</title>
        <?php require_once '../part/cssjs.php'; ?>

        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            
            #example a {
                text-decoration: none !important;
            }
        </style>

        <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                var oTable = $('#example').dataTable( {
                    "bProcessing": true,
                    "bSort": true,
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [ 3 ] }
                    ]
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
                <ul class="shortcut-buttons-set">
                    <li><a class="shortcut-button upload-image current" href="coupon-group-list.php"><span class="png_bg">
                                Nhóm coupon
                            </span></a></li>
                    <li><a class="shortcut-button new-page" href="coupon-group.php"><span class="png_bg">
                                Thêm nhóm mới
                            </span></a></li>
                </ul>
                <div class="clear"></div>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Nhóm coupon</h3>
                    </div>
                    <div id="dt_example">
                        <div id="container">
                            <div id="demo">
                                <?php
                                require_once '../models/coupon_group.php';
                                require_once '../models/helper.php';
                                
                                $coupon_group = new coupon_group();
                                $array = $coupon_group->get_list();
                                ?>
                                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                    <thead>
                                        <tr>
                                            <th>Mã nhóm</th>
                                            <th>Nội dung</th>
                                            <th>Ghi chú</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php if(is_array($array)): ?>
                                    <?php foreach ($array as $row): ?>
                                        <tr>
                                            <td>
                                                <a href="../coupon/coupon-group.php?action=update&groupid=<?php echo $row['group_id']; ?>" title="Chi tiết"><?php echo $row['group_id']; ?></a>
                                            </td>
                                            <td><?php echo $row['content']; ?></td>
                                            <td><?php echo $row['description']; ?></td>
                                            <td>
                                                <a href="../coupon/coupon-group.php?action=update&groupid=<?php echo $row['group_id']; ?>" title="Sửa">
                                                    <img width="16px" height="16px" src="../resources/images/icons/pencil.png" alt="Edit" />
                                                </a>
                                                <a href="../coupon/coupon-group.php?action=delete&groupid=<?php echo $row['group_id']; ?>" title="Xóa">
                                                    <img width="16px" height="16px" src="../resources/images/icons/cross.png" alt="Delete" />
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>    
                                    <?php endif; ?>
                                    </tbody>
                                </table>
                                <div style="padding-bottom: 10px;"></div>
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