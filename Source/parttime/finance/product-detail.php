<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_SYSTEM_ADMIN, F_SYSTEM_ADMIN_FINANCE, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Cập nhật sản phẩm</title>
        <?php require_once '../part/cssjs.php'; ?>

        <style type="text/css">
            #main-content tbody tr.alt-row { background: none; }
            .error_icon { display: none; }
        </style>
        
        <script type="text/javascript" src="../resources/scripts/utility/finance/product.js"></script>
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
                <div class="clear"></div>
                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), F_SYSTEM_ADMIN_FINANCE)): ?>
                        <li>
                            <a class="shortcut-button on-going" href="../finance/reference-list.php">
                                <span class="png_bg">Quản lý số tham chiếu</span>
                            </a>
                        </li>
                        <li>
                            <a class="shortcut-button list" href="../finance/product-list.php">
                                <span class="png_bg">Quản lý sản phẩm</span>
                            </a>
                        </li>
                        <li>
                            <a class="shortcut-button switch" href="../finance/category-list.php">
                                <span class="png_bg">Quản lý loại chi phí</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Cập nhật sản phẩm</h3>
                    </div>
                    <div class="content-box-content">
                        <?php require_once '../models/finance_product.php'; ?>
                        
                        <div class="tab-content default-tab">
                            <?php 
                                $product_id = (isset($_GET['i'])) ? $_GET['i'] : '';
                                
                                // Get detail of role group
                                $model = new finance_product();
                                $product = $model->detail($product_id);
                            ?>
                            <?php if ($product != NULL): ?>
                                <form id="edit-product" action="" method="post">
                                    <?php
                                        if (isset($_POST["save"])) {
                                            $product_id = $_POST['product_id'];
                                            $name = $_POST["name"];
                                            $enable = (isset($_POST['enable']));
                                            $used_type = $_POST["used_type"];
                                            
                                            $item = $model->detail($product_id);
                                            if ($item != NULL) {
                                                $item->name = $name;
                                                $item->enable = $enable;
                                                $item->used_type = $used_type;
                                                
                                                // Insert to database
                                                if ($model->update($item)) {
                                                    $result = TRUE;
                                                    $message = "Thực hiện thao tác thành công.";
                                                }
                                                else {
                                                    $result = FALSE;
                                                    $message = "Lỗi: '{$model->getMessage()}'";
                                                }
                                            } else {
                                                $result = FALSE;
                                                $message = "Không tìm thấy thông tin chi tiết sản phẩm '{$product_id}'";
                                            }
                                            
                                            if ($result) {
                                                $product = $model->detail($product_id);
                                            }
                                        }
                                    ?>
                                    <?php if(isset($result) && $result): ?>
                                        <div class="notification information png_bg">
                                            <a href="#" class="close"><img src="../resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close"></a>
                                            <div><?php echo $message; ?></div>
                                        </div>
                                    <?php endif; ?>
                                    <?php if(isset($result) && ! $result): ?>
                                        <div class="notification error png_bg">
                                            <a href="#" class="close"><img src="../resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close"></a>
                                            <div><?php echo $message; ?></div>
                                        </div>
                                    <?php endif; ?>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td width="20%">
                                                    <label>Mã sản phẩm (*)</label>
                                                </td>
                                                <td>
                                                    <input id="product_id" name="product_id" class="text-input small-input" maxlength="50" type="text" readonly="readonly" value="<?php echo $product->product_id; ?>" />
                                                    <img class="error_icon" src="../resources/images/icons/cross_circle.png" alt="" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Tên sản phẩm (*)</label>
                                                </td>
                                                <td>
                                                    <input id="name" name="name" class="text-input medium-input" type="text" value="<?php echo $product->name; ?>" />
                                                    <img class="error_icon" src="../resources/images/icons/cross_circle.png" alt="" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Loại phiếu sử dụng (*)</label>
                                                </td>
                                                <td>
                                                    <select name="used_type" id="used_type">
                                                        <?php 
                                                            $types = array(FINANCE_BOTH, FINANCE_RECEIPT, FINANCE_PAYMENT);
                                                            foreach ($types as $t):
                                                        ?>
                                                                <option value="<?php echo $t; ?>" <?php echo ($t == $product->used_type) ? "selected='selected'" : ""; ?> ><?php echo get_finance_type_name($t); ?></option>
                                                        <?php
                                                            endforeach;
                                                        ?>
                                                    </select>
                                                    <img class="error_icon" src="../resources/images/icons/cross_circle.png" alt="" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="enable">Enable</label>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="enable" <?php echo ($product->enable == BIT_TRUE) ? "checked='checked'" : "" ?> alt=""> Yes
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <fieldset>
                                        <p>
                                            <input class="button" type="submit" name="save" value="Cập nhật sản phẩm" />
                                        </p>
                                    </fieldset>
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