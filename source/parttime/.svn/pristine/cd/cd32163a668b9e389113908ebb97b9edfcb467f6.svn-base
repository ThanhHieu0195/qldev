<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_VIEW, F_VIEW_ORDER, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>        
        <title>Đặt hàng theo yêu cầu</title>      
        <?php require_once '../part/cssjs.php'; ?>
        <style type="text/css">
            .text {
                font-size: 13px !important;
                padding: 5px !important;
            }
            #main-content tbody tr.alt-row { background: none; }
        </style>
        <script type="text/javascript" src="../resources/scripts/jquery.alphanumeric.js"></script>
        <script type="text/javascript" charset="utf-8" src="../resources/scripts/utility/order.js"></script>
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
                <?php //include_once '../part/divcart.php'; ?>
                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), F_VIEW_STORE)): ?>
                        <li>
                            <a class="shortcut-button upload-image" href="store.php">
                                <span class="png_bg">Hàng có sẵn</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="clear"></div> 
                <div class="notification attention png_bg">
                    <div>Đề nghị điền đầy đủ thông tin sản phẩm đặt hàng theo yêu cầu.</div>
                </div>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Thông tin đặt hàng</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form action="" method="post" id="order-product">
                                <?php
                                include_once '../models/database.php';
                                include_once '../models/khohang.php';
                                include_once '../models/dathang.php';
                                include_once '../models/chitietdonhang.php';
                                include_once '../models/helper.php';
                                include_once '../models/cart.php';
                                include_once '../models/config.php';
                                include_once '../config/constants.php';
                                
                                $submited = FALSE;
                                
                                if (isset($_POST['add'])) 
                                {
                                    $submited = TRUE;
                                    // Lay cac thong tin san pham dat hang
                                    $masotranh = $_POST['masotranh'];
                                    $tentranh  = $_POST['tentranh'];
                                    $maloai    = $_POST['maloai'];
                                    $dai       = $_POST['dai'];
                                    $rong      = $_POST['rong'];
                                    $soluong   = $_POST['soluong'];
                                    $giaban    = $_POST['giaban'];
                                    $config = new Config();
                                    $makho     = $config->get(DEFAULT_SHOWROOM); // $_POST['makho'];
                                    $matho     = $config->get(DEFAULT_THO);      // $_POST['matho'];
                                    $ghichu    = $_POST['ghichu'];
                                    $nguoidat  = current_account();
                                    $trangthai = chitietdonhang::$DAT_HANG;
                                    /*$result = array();
                                    $result[] = $masotranh;
                                    $result[] = $tentranh;
                                    $result[] = $maloai;
                                    $result[] = $dai;
                                    $result[] = $rong;
                                    $result[] = $soluong;
                                    $result[] = $giaban;
                                    $result[] = $makho;
                                    $result[] = $matho;
                                    $result[] = $ghichu;
                                    $result[] = $nguoidat;
                                    $result[] = $trangthai;
                                    debug($result);*/
                                    // Them vao bang dathang va bang tranh
                                    $dathang = new dathang();
                                    $result = $dathang->them($masotranh, $tentranh, $maloai, $dai, $rong, $soluong, $giaban, $makho,
                                                             $matho, $ghichu, $nguoidat, $trangthai);
                                    // Them vao gio hang
                                    if($result)
                                    {
                                        $cart = new Cart(CART_NAME);
                                        $cart->register();
                                        $cart->add($masotranh, $makho, $soluong, $trangthai);
                                    }
                                    
                                }
                                ?>
                                <?php if($submited && $result): ?>
                                <div class="notification success png_bg">
                                    <a class="close" href="#">
                                        <img alt="close" title="Close this notification" src="../resources/images/icons/cross_grey_small.png" />
                                    </a>
                                    <div>
                                       <?php echo(sprintf('Đặt hàng sản phẩm <b>%s</b> thành công.', $masotranh)); ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php if($submited && ( ! $result)): ?>
                                <div class="notification error png_bg">
                                    <a class="close" href="#">
                                        <img alt="close" title="Close this notification" src="../resources/images/icons/cross_grey_small.png" >
                                    </a>
                                    <div>
                                       <?php echo(sprintf('Lỗi dặt hàng sản phẩm <b>%s</b>: %s.', $masotranh, $dathang->getMessage())); ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <table>                                                       
                                    <tfoot>                                        
                                        <tr>
                                            <td colspan="2">
                                                <div class="bulk-actions align-left">
                                                    <input class="button" type="submit" name="add" value="Đặt hàng" />
                                                    <span id="error" style="padding-left: 20px" class="require"></span>
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <span class="bold">Mã sản phẩm</span>
                                                <span class="require">*</span>
                                            </td>
                                            <td>
                                                <input maxlength="50" class="text ui-widget-content ui-corner-all uid" type="text" id="masotranh" name="masotranh" value="" />
                                                <i>(tối đa 50 ký tự và chỉ cho phép nhập các ký tự: <?php echo VALIDATE_UID; ?>)</i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Tên sản phẩm</span>
                                                <span class="require">*</span>
                                            </td>
                                            <td>
                                                <input maxlength="100" class="text-input medium-input" type="text" id="tentranh" name="tentranh" value="" />                                              
                                            </td>
                                        </tr>                                    
                                        <tr>
                                            <td width="20%">
                                                <span class="bold">Loại sản phẩm</span>
                                                <span class="require">*</span>
                                            </td>
                                            <td width="80%">
                                                <select name="maloai" id="maloai">
                                                    <option value=""></option>
                                                    <?php
                                                    $db = new database();
                                                    $db->setQuery("SELECT * FROM loaitranh");
                                                    $array = $db->loadAllRow();

                                                    //Duyet ket qua
                                                    foreach ($array as $value)
                                                    {
                                                        echo "<option value='" . $value['maloai'] . "'>" . $value['tenloai'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Chiều dài</span>
                                                <i>(nếu có)</i>
                                            </td>
                                            <td>
                                                <input maxlength="10" class="text-input small-input" type="text" id="dai" name="dai" value="" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Chiều rộng</span>
                                                <i>(nếu có)</i>
                                            </td>
                                            <td>
                                                <input maxlength="10" class="text-input small-input" type="text" id="rong" name="rong" value="" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Số lượng</span>
                                                <span class="require">*</span>
                                            </td>
                                            <td>
                                                <input maxlength="5" class="text ui-widget-content ui-corner-all numeric" type="text" id="soluong" name="soluong" value="" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Giá bán(VNĐ)</span>
                                                <span class="require">*</span>
                                            </td>
                                            <td>
                                                <input maxlength="10" class="text ui-widget-content ui-corner-all numeric" type="text" id="giaban" name="giaban" value="" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Ghi chú</span>
                                            </td>
                                            <td>
                                                <textarea class="text-input medium-input" id="ghichu" name="ghichu" cols="20" rows="5"></textarea>
                                            </td>
                                        </tr>                                       
                                    </tbody>
                                </table>
                            </form>
                            <br />
                            <br />
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