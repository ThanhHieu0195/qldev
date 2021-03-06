<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ITEMS, F_ITEMS_ADD, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>        
        <title>Thêm sản phẩm mới</title>      
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
                <noscript>
                    <div class="notification error png_bg">
                        <div>
                            Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
                        </div>
                    </div>
                </noscript>
                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), F_ITEMS_LIST)): ?>
                        <li>
                            <a class="shortcut-button upload-image" href="list.php">
                                <span class="png_bg">Danh sách sản phẩm</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_STORES_STORE_LIST)): ?>
                        <li>
                            <a class="shortcut-button add-event" href="../stores/storelist.php">
                                <span class="png_bg">Danh sách kho hàng</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Thêm sản phẩm mới</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form action="" method="post" id="add-product" enctype="multipart/form-data">
                                <?php
                                include_once '../models/database.php';
                                include_once '../models/khohang.php';
                                include_once '../models/tranh.php';
                                include_once '../models/tonkho.php';
                                include_once '../models/helper.php';
                                include_once '../models/import_export_history.php';
                                
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
                                    $cao       = $_POST['cao'];
                                    $loai      = $_POST['loai'];
                                    $soluong   = $_POST['soluong'];
                                    $giavon    = $_POST['giavon'];
                                    $giaban    = $_POST['giaban'];
                                    $makho     = $_POST['makho'];
                                    $matho     = $_POST['matho'];
                                    $ghichu    = $_POST['ghichu'];
                                    $hinhanh   = '';
                                    $tongmau     = $_POST['tongmau'];
                                    $hoavan    = $_POST['hoavan'];
                                    $loai = $_POST['loai'];
                                    // Xu ly hinh anh upload
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
                                            move_uploaded_file($_FILES["hinhanh"]["tmp_name"], "../pic_images/" . $_FILES["hinhanh"]["name"]);
                                        }
                                    }
                                    /*$result['masotranh'] = $masotranh;
                                    $result['tentranh'] = $tentranh;
                                    $result['maloai'] = $maloai;
                                    $result['loai'] = $loai;
                                    $result['dai'] = $dai;
                                    $result['rong'] = $rong;
                                    $result['cao'] = $cao;
                                    $result['soluong'] = $soluong;
                                    $result['giaban'] = $giaban;
                                    $result['makho'] = $makho;
                                    $result['matho'] = $matho;
                                    $result['ghichu'] = $ghichu;
                                    $result['hinhanh'] = $hinhanh;
                                    $result['tongmau'] = $tongmau;
                                    $result['hoavan'] = $hoavan;
                                    debug($result);*/
                                    // Them vao bang tranh
                                    $tranh = new tranh();
                                    $tranh->them($masotranh, $tentranh, $maloai, $cao, $dai, $rong, $giavon, $giaban, $matho, $ghichu, $hinhanh, $tongmau, $hoavan, $loai);
                                    // Them vao bang ton kho
                                    $tonkho = new tonkho();
                                    $result = $tonkho->them($masotranh, $makho, $soluong);
                                    $message = $tonkho->getMessage();
                                    if( ! $result)
                                    {
                                        $result = $tonkho->cap_nhat_so_luong($masotranh, $makho, $soluong);
                                        $message = $tonkho->getMessage();
                                    }
                                    
                                    // Them lich su nhap hang
                                    $history = new import_export_history();
                                    $history->add_new(current_account(), $masotranh, $makho, $soluong, 
                                                      NULL, import_export_history::$TYPE_IMPORT, 
                                                      import_export_history::$MSG_ADD_ITEM, TRUE);
                                }
                                ?>
                                <?php if($submited && $result): ?>
                                <div class="notification success png_bg">
                                    <a class="close" href="#">
                                        <img alt="close" title="Close this notification" src="../resources/images/icons/cross_grey_small.png" />
                                    </a>
                                    <div>
                                       <?php echo(sprintf('Thêm sản phẩm <b>%s</b> thành công.', $masotranh)); ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php if($submited && ( ! $result)): ?>
                                <div class="notification error png_bg">
                                    <a class="close" href="#">
                                        <img alt="close" title="Close this notification" src="../resources/images/icons/cross_grey_small.png" >
                                    </a>
                                    <div>
                                       <?php echo(sprintf('Lỗi thêm sản phẩm <b>%s</b>: %s.', $masotranh, $message)); ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <table>                                                       
                                    <tfoot>                                        
                                        <tr>
                                            <td colspan="2">
                                                <div class="bulk-actions align-left">
                                                    <input class="button" type="submit" name="add" value="Thêm" />
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
                                                <input maxlength="50" class="text-input small-input uid" type="text" id="masotranh" name="masotranh" value="" pattern="[A-Za-z0-9_]{10,50}" required/>
                                                <i>(tối đa 50 ký tự và chỉ cho phép nhập các ký tự: <?php echo VALIDATE_UID; ?>)</i>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Tên sản phẩm</span>
                                                <span class="require">*</span>
                                            </td>
                                            <td>     
                                                <input maxlength="100" class="text-input medium-input" type="text" id="tentranh" name="tentranh"  value="<?php echo $row['tentranh']; ?>" required/>                                          
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
                                                <span class="bold">Chiều dài (cm)</span>
                                                <i>(nếu có)</i>
                                            </td>
                                            <td>
                                                <input maxlength="10" class="text-input small-input" type="text" id="dai" name="dai" value="" pattern="[0-9]{1,3}" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Chiều rộng (cm)</span>
                                                <i>(nếu có)</i>
                                            </td>
                                            <td>
                                                <input maxlength="10" class="text-input small-input" type="text" id="rong" name="rong" value="" pattern="[0-9]{1,3}" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Chiều cao (cm)</span>
                                                <i>(nếu có)</i>
                                            </td>
                                            <td>
                                                <input maxlength="10" class="text-input small-input" type="text" id="cao" name="cao" value="" pattern="[0-9]{1,3}" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Hình ảnh</span>
                                                <span class="require">*</span>
                                            </td>
                                            <td>
                                                <input class="small-input" id="hinhanh" name="hinhanh" type="file" lang="en" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Màu</span>
                                            </td>
                                            <td>
                                                <input class="small-input" id="tongmau" name="tongmau"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Hoa văn</span>
                                            </td>
                                            <td>
                                                <input class="small-input" id="hoavan" name="hoavan" />
                                            </td>
                                        </tr>
                                        <!-- HT 2016-12-17 -->

                                         <tr>
                                            <td>
                                                <span class="bold">Loại</span>
                                            </td>
                                            <td>
                                               <select name="loai" required>
                                                   <option></option>
                                                   <option value="<?php echo TYPE_ITEM_PRODUCE ?>" selected>Sản phẩm</option>
                                                   <option value="<?php echo TYPE_ITEM_ASSEMBLY ?>">Lắp ghép</option>
                                               </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Số lượng</span>
                                                <span class="require">*</span>
                                            </td>
                                            <td>
                                                <input maxlength="5" class="text-input small-input numeric" type="text" id="soluong" name="soluong" value="" pattern="[0-9]{1,10}" required/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Giá vốn (VNĐ)</span>
                                                <span class="require">*</span>
                                            </td>
                                            <td>
                                                <input maxlength="10" class="text-input small-input numeric" type="text" id="giavon" name="giavon" value="" pattern="[0-9]{4,12}" required/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Giá bán(VNĐ)</span>
                                                <span class="require">*</span>
                                            </td>
                                            <td>
                                                <input maxlength="10" class="text-input small-input numeric" type="text" id="giaban" name="giaban" value="" pattern="[0-9]{4,12}" required/>
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

                                                    //Duyet ket qua
                                                    foreach ($array as $value)
                                                    {
                                                        echo "<option value='" . $value['makho'] . "'>" . $value['tenkho'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="20%" >
                                                <span class="bold" style="display: none;">Thợ</span>
                                                <span class="require" style="display: none;">*</span>
                                            </td>
                                            <td width="80%">
                                                <select name="matho" id="matho" hidden>
                                                    <option value="amit" selected></option>
                                                    <?php
                                                    $db = new database();
                                                    $db->setQuery("SELECT matho, hoten FROM tho");
                                                    $array = $db->loadAllRow();

                                                    //Duyet ket qua
                                                    foreach ($array as $value)
                                                    {
                                                        echo "<option value='" . $value['matho'] . "'>" . $value['hoten'] . "</option>";
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
