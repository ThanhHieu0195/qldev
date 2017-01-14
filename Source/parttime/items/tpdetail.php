<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ORDERS, F_ORDERS_TP, TRUE);

//Kiểm tra id của sản phẩm
if (!isset($_GET['item']))
    exit();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thông tin sản phẩm cần sản xuất</title>
        <?php require_once '../part/cssjs.php'; ?>
        <style type="text/css">
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
                    <?php if (verify_access_right(current_account(), F_ORDERS_TP)): ?>
                        <li>
                            <a class="shortcut-button upload-image" href="tp.php">
                                <span class="png_bg">Danh sách sản phẩm cần sản xuất</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Thông tin sản phẩm cần sản xuất</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="tp-detail" action="" method="post" enctype="multipart/form-data">
                                <?php
                                include_once '../models/tranh.php';
                                include_once '../models/dathang.php';
                                include_once '../models/loaitranh.php';
                                include_once '../models/khohang.php';
                                include_once '../models/chitietdonhang.php';
                                include_once '../models/helper.php';
                                
                                $submited = FALSE;
                                
                                if (isset($_POST["update"]))
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
                                    $makho     = $_POST['makho'];
                                    $matho     = $_POST['matho'];
                                    $ghichu    = $_POST['ghichu'];
                                    $hinhanh   = $_POST['hinhanhcu'];
                                    $madon     = $_POST['madon'];
                                    $nguoidat  = $_POST['nguoidat'];
                                    $trangthai = $_POST['trangthai'];

                                    if ($_FILES["hinhanh"]["error"] > 0)
                                    {
                                        //echo "Lỗi của file: " . $_FILES["hinhanh"]["error"] . "<br />";
                                        //exit();
                                    }
                                    else
                                    {
                                        if ( ! empty($_FILES["hinhanh"]["name"]))
                                            $hinhanh = "pic_images/" . $_FILES["hinhanh"]["name"];
                                        if (file_exists("../pic_images/" . $_FILES["hinhanh"]["name"]))
                                        {
                                            //echo $_FILES["hinhanh"]["name"] . " đã tồn tại. <br />";
                                        }
                                        else
                                        {
                                            //dùng hàm move_uploaded_file để di chuyển file upload vào thư mục định sẵn là thư mục upload
                                            //echo $hinhanh;
                                            move_uploaded_file($_FILES["hinhanh"]["tmp_name"], "../pic_images/" . $_FILES["hinhanh"]["name"]);
                                        }
                                    }
                                    
                                    /*$result = array();
                                    $result['masotranh'] = $masotranh;
                                    $result['tentranh'] = $tentranh;
                                    $result['maloai'] = $maloai;
                                    $result['dai'] = $dai;
                                    $result['rong'] = $rong;
                                    $result['soluong'] = $soluong;
                                    $result['giaban'] = $giaban;
                                    $result['makho'] = $makho;
                                    $result['matho'] = $matho;
                                    $result['ghichu'] = $ghichu;
                                    $result['hinhanh'] = $hinhanh;
                                    $result['madon'] = $madon;
                                    $result['nguoidat'] = $nguoidat;
                                    $result['trangthai'] = $trangthai;
                                    debug($result);*/
                                    
                                    $dathang = new dathang();
                                    $dathang->cap_nhat($masotranh, $tentranh, $maloai, $dai, $rong, $soluong, $giaban, $makho,
                                                       $matho, $ghichu, $hinhanh, $madon, $nguoidat, $ngaygiodat, $trangthai);
                                }
                                ?>
                                <?php if($submited): ?>
                                <div class="notification success png_bg">
                                    <a class="close" href="#">
                                        <img alt="close" title="Close this notification" src="../resources/images/icons/cross_grey_small.png" />
                                    </a>
                                    <div>
                                       <?php echo(sprintf('Cập nhật sản phẩm <b>%s</b> thành công.', $masotranh)); ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php
                                if(isset($_GET['item'])):
                                    $dathang = new dathang();
                                    $row = $dathang->chi_tiet($_GET['item']);
                                    
                                    if(is_array($row))
                                    {
                                ?>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <span class="bold">Mã sản phẩm</span>
                                                </td>
                                                <td>
                                                    <input type="text" id="masotranh" name="masotranh" class="text-input small-input" readonly="readonly"
                                                           value="<?php echo $row['masotranh']; ?>" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="bold">Tên sản phẩm</span>
                                                    <span class="require">*</span>
                                                </td>
                                                <td>
                                                    <input maxlength="100" class="text-input medium-input" type="text" id="tentranh" name="tentranh"
                                                           value="<?php echo $row['tentranh']; ?>" />
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
                                                        $format = "<option value='%s'%s>%s</option>";
                                                        
                                                        foreach ($array as $value)
                                                        {
                                                            if ($value['maloai'] == $row['maloai'])
                                                                echo sprintf($format, $value['maloai'], " selected='selected'", $value['tenloai']);
                                                            else
                                                                echo sprintf($format, $value['maloai'], "", $value['tenloai']);
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
                                                    <input maxlength="10" class="text-input small-input" type="text" id="dai" name="dai"
                                                           value="<?php echo $row['dai']; ?>" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="bold">Chiều rộng</span>
                                                    <i>(nếu có)</i>
                                                </td>
                                                <td>
                                                    <input maxlength="10" class="text-input small-input" type="text" id="rong" name="rong"
                                                           value="<?php echo $row['rong']; ?>" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="bold">Số lượng</span>
                                                    <span class="require">*</span>
                                                </td>
                                                <td>
                                                    <input maxlength="5" class="text-input small-input numeric" type="text" id="soluong" name="soluong"
                                                           value="<?php echo $row['soluong']; ?>" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="bold">Giá bán(VNĐ)</span>
                                                    <span class="require">*</span>
                                                </td>
                                                <td>
                                                    <input maxlength="10" class="text-input small-input numeric" type="text" id="giaban" name="giaban"
                                                           value="<?php echo number_2_string($row['giaban'], ''); ?>" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="20%">
                                                    <span class="bold">Showroom</span>
                                                    <span class="require">*</span>
                                                </td>
                                                <td width="80%">
                                                    <select name="makho" id="makho">
                                                        <option value=""></option>
                                                        <?php
                                                        $khohang = new khohang();
                                                        $array = $khohang->danh_sach();
                                                        $format = "<option value='%s'%s>%s</option>";
                                                        
                                                        foreach ($array as $value)
                                                        {
                                                            if ($value['makho'] == $row['makho'])
                                                                echo sprintf($format, $value['makho'], " selected='selected'", $value['tenkho']);
                                                            else
                                                                echo sprintf($format, $value['makho'], "", $value['tenkho']);
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="20%">
                                                    <span class="bold">Thợ</span>
                                                    <span class="require">*</span>
                                                </td>
                                                <td width="80%">
                                                    <select name="matho" id="matho">
                                                        <option value=""></option>
                                                        <?php
                                                        $db = new database();
                                                        $db->setQuery("SELECT matho, hoten FROM tho");
                                                        $array = $db->loadAllRow();
                                                        $format = "<option value='%s'%s>%s</option>";
                                                        
                                                        foreach ($array as $value)
                                                        {
                                                            if ($value['matho'] == $row['matho'])
                                                                echo sprintf($format, $value['matho'], " selected='selected'", $value['hoten']);
                                                            else
                                                                echo sprintf($format, $value['matho'], "", $value['hoten']);
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="bold">Ghi chú</span>
                                                </td>
                                                <td>
                                                    <textarea class="text-input medium-input" id="ghichu" name="ghichu" cols="20" rows="5"><?php echo $row['ghichu']; ?></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="bold">Hình ảnh</span>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="hinhanhcu" value="<?php echo $row['hinhanh'] ?>" />
                                                    <img alt="<?php echo $row['masotranh'] ?>" width="150px" height="185px"
                                                         title="<?php echo $row['masotranh'] ?>" src="<?php echo '../' . $row['hinhanh'] ?>" />
                                                    <br />
                                                    <input class="text-input small-input" name="hinhanh" type="file" lang="en" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="bold">Mã hóa đơn</span>
                                                </td>
                                                <td>
                                                    <input type="text" id="madon" name="madon" class="text-input small-input" readonly="readonly"
                                                           value="<?php echo $row['madon']; ?>" />
                                                    <input type="hidden" name="nguoidat" value="<?php echo $row['nguoidat'] ?>" />
                                                    <input type="hidden" name="ngaygiodat" value="<?php echo $row['ngaygiodat'] ?>" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <span class="bold">Trạng thái</span>
                                                    <span class="require">*</span>
                                                </td>
                                                <td>
                                                    <select id="trangthai" name="trangthai">
                                                        <?php
                                                        $html = "<option value='%s'%s>Cần sản xuất</option>
                                                                 <option value='%s'%s>Đang sản xuất</option>
                                                                 <option value='%s'%s>Sản xuất xong</option>";
                                                        
                                                        switch($row['trangthai'])
                                                        {
                                                            case chitietdonhang::$CAN_SAN_XUAT:
                                                                echo sprintf($html, chitietdonhang::$CAN_SAN_XUAT, " selected='selected'",
                                                                                    chitietdonhang::$DANG_SAN_XUAT, "",
                                                                                    chitietdonhang::$CHO_GIAO, "");
                                                                break;
                                                            case chitietdonhang::$DANG_SAN_XUAT:
                                                                echo sprintf($html, chitietdonhang::$CAN_SAN_XUAT, "",
                                                                                    chitietdonhang::$DANG_SAN_XUAT, " selected='selected'",
                                                                                    chitietdonhang::$CHO_GIAO, "");
                                                                break;
                                                            case chitietdonhang::$CHO_GIAO:
                                                                echo sprintf($html, chitietdonhang::$CAN_SAN_XUAT, "",
                                                                                    chitietdonhang::$DANG_SAN_XUAT, "",
                                                                                    chitietdonhang::$CHO_GIAO, " selected='selected'");
                                                                break;
                                                            default:
                                                                echo "<option value=''></option>";
                                                        }
                                                        ?>
                                                    </select>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2">
                                                    <div class="bulk-actions align-left">
                                                        <input class="button" type="submit" name="update" value="Cập nhật" />
                                                        <span id="error" style="padding-left: 20px" class="require"></span>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                <?php
                                    }
                                    else
                                    {
                                        header("location: ../items/tp.php");
                                        //exit();
                                    }
                                endif;
                                ?>
                            </form>
                            <br />
                            <br />
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