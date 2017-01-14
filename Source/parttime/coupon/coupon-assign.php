<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ORDERS, F_ORDERS_ASSIGN_DELIVERED, TRUE);

if ( ! isset($_GET['bill_code']))
    exit();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Assign coupon theo đơn hàng</title>
        <?php require_once '../part/cssjs.php'; ?>

        <script type="text/javascript" src="../resources/stickytooltip/stickytooltip.js"></script>
        <script type="text/javascript" src="../resources/scripts/jquery.alphanumeric.js"></script>
        <script type="text/javascript" charset="utf-8">
            // DOM load
            $(function() {
                // Numeric
                $('.numeric').numeric();
                
                $("#assign_coupon").submit(function() {
                    if($("#group_id").val() == "" || $("#amount").val() == "")
                        return false;
                    return true;
                });
            });
        </script>
        <link rel="stylesheet" type="text/css" href="../resources/stickytooltip/stickytooltip.css" />
        <style type="text/css">
            img {
                vertical-align: middle;
            }
        </style>
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
                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), F_ORDERS_ORDER_DELIVERED)): ?>
                        <li>
                            <a class="shortcut-button upload-image" href="../orders/orderdelivered.php">
                                <span class="png_bg">Đơn hàng đã giao</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Assign coupon theo đơn hàng</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="assign_coupon" action="" method="post">
                                <?php
                                require_once '../config/constants.php';
                                require_once '../models/coupon.php';
                                require_once '../models/coupon_group.php';
                                require_once '../models/helper.php';
                                require_once '../models/donhang.php';
                                require_once '../models/khach.php';
                                
                                $bill_code = $_GET['bill_code'];
                                
                                if (isset($_POST["assign"]))
                                {
                                    $bill_code = $_POST['bill_code'];
                                    $assign_to = $_POST['assign_to'];
                                    $group_id = $_POST['group_id'];
                                    $amount = $_POST['amount'];
                                    $done = FALSE;
                                    
                                    $coupon = new coupon();
                                    $done = $coupon->assign_new($assign_to, $bill_code, $group_id, COUPON_ASSIGN_GUEST_NEW, $amount);
                                }
                                ?>
                                <?php if(isset($done) && $done): ?>
                                <div class="notification success png_bg">
                                    <a class="close" href="#"><img alt="close" title="Close this notification" src="../resources/images/icons/cross_grey_small.png" /></a>
                                    <div>
                                        Thực hiện thao tác assign thành công!
                                        <script>history.go(-2);</script>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php if(isset($done) && ! $done): ?>
                                <div class="notification error png_bg">
                                    <a class="close" href="#"><img alt="close" title="Close this notification" src="../resources/images/icons/cross_grey_small.png" /></a>
                                    <div>
                                        Lỗi thực hiện thao tác assign:
                                        <?php 
                                        if($coupon->getMessage() != '')
                                            echo $coupon->getMessage() . '<br />';
                                        ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <div id="coupon_info" class="notification information png_bg">
                                    <?php
                                    $db = new donhang();
                                    $row = $db->chi_tiet_don_hang($bill_code);
                                    
                                    $khach = new khach();
                                    $guest = $khach->detail($row['makhach']);
                                    ?>
                                    <div>
                                        <label>Mã hóa đơn</label>
                                        <span class="blue"><?php echo $bill_code; ?></span>
                                        <input type="hidden" id="bill_code" name="bill_code" value="<?php echo $bill_code; ?>" />
                                    </div>
                                    <div>
                                        <label>Thành tiền</label>
                                        <span class="price"><?php echo number_2_string($row['thanhtien']); ?></span>
                                    </div>
                                    <div>
                                        <label>Khách hàng</label>
                                        <span class="price"><?php echo $guest['hoten']; ?></span>
                                        <input type="hidden" id="assign_to" name="assign_to" value="<?php echo $guest['makhach']; ?>" />
                                    </div>
                                    <div>
                                        <label>Nhóm khách hàng</label>
                                        <span class="blue"><u><?php echo $guest['tennhom']; ?></u></span>
                                    </div>
                                    <div>
                                        <label>Địa chỉ</label>
                                        <span class="price"><?php echo $guest['diachi']; ?></span>
                                    </div>
                                </div>
                                <fieldset>
                                    <p>
                                        <label for="group_id">Nhóm coupon (*)</label>
                                        <select id="group_id" name="group_id">
                                            <option value=""></option>
                                            <?php
                                            $coupon_group = new coupon_group();
                                            $list = $coupon_group->general_list();
                                            
                                            foreach ($list as $item)
                                            {
                                                if($item['amount'] > 0)
                                                {
                                                    echo sprintf('<option value="%s">%s (%d coupon)</option>', $item['group_id'], $item['content'], $item['amount']);
                                                }
                                            }
                                            ?>
                                        </select>
                                    </p>
                                    <p>
                                        <label for="amount">Số lượng coupon (*)</label>
                                        <input type="text" maxlength="10" class="text-input small-input numeric" id="amount" name="amount" value="1" />
                                    </p>
                                    <p>
                                        <input type="submit" class="button" id="assign" name="assign" value="Assign" />
                                    </p>
                               </fieldset>
                            </form>
                            <div style="padding-bottom: 10px;"></div>
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
