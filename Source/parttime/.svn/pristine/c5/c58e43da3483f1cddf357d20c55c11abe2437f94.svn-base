<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ITEMS, F_ITEMS_LIST, TRUE);

//Kiểm tra id của sản phẩm
if (!isset($_GET['item']))
    exit();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thông tin sản phẩm</title>
        <?php require_once '../part/cssjs.php'; ?>
        <style type="text/css">
            #main-content tbody tr.alt-row { background: none; }
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
                        <h3>Thông tin sản phẩm</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form action="" method="post" enctype="multipart/form-data">
                                <?php
                                include_once '../models/tranh.php';

                                //++ REQ20120508_BinhLV_M
                                if (isset($_POST["submit"]))
                                {
                                    $masotranh = $_POST["masp"];
                                    $maloai = $_POST["loaisp"];
                                    $tentranh = $_POST["tensp"];
                                    $dai = $_POST["dai"];
                                    $rong = $_POST["rong"];
                                    $giaban = $_POST["giaban"];
                                    $ghichu = $_POST["ghichu"];
                                    $matho = $_POST["tho"];
                                    $hinhanh = $_POST["image"];
                                    $tongmau = $_POST["tongmau"];
                                    $hoavan = $_POST["hoavan"];

                                    if ($_FILES["hinhanh"]["error"] > 0)
                                    {
                                        //echo "Lỗi của file: " . $_FILES["hinhanh"]["error"] . "<br />";
                                        //exit();
                                    }
                                    else
                                    {
                                        if (!empty($_FILES["hinhanh"]["name"]))
                                            $hinhanh = "pic_images/" . $_FILES["hinhanh"]["name"];
                                        if (file_exists("../pic_images/" . $_FILES["hinhanh"]["name"])) {
                                            //echo $_FILES["hinhanh"]["name"] . " đã tồn tại. <br />";
                                        } else {
                                            //dùng hàm move_uploaded_file để di chuyển file upload vào thư mục định sẵn là thư mục upload
                                            //echo $hinhanh;
                                            move_uploaded_file($_FILES["hinhanh"]["tmp_name"], "../pic_images/" . $_FILES["hinhanh"]["name"]);
                                        }
                                    }

                                    $tranh = new tranh();
                                    $cap_nhat_tranh = $tranh->cap_nhat_tranh($masotranh, $maloai, $tentranh, $dai, $rong, $giaban, $ghichu, $matho, $hinhanh, $tongmau, $hoavan);
                                    if ($cap_nhat_tranh)
                                        echo '<center><span class="input-notification success png_bg">Cập nhật thông tin sản phẩm thành công.</span></center><br /><br />';
                                    else
                                        echo '<center><span class="input-notification error png_bg">Lỗi: ' . $tranh->_error . '</span></center><br /><br />';
                                }
                                //-- REQ20120508_BinhLV_M
                                ?>
                                <table>                                                       
                                    <tbody>
                                        <?php
                                        //require_once '../models/helper.php';

                                        $id = $_GET['item'];
                                        $tranh = new tranh();
                                        $row = $tranh->chi_tiet_tranh($id);
                                        //debug($row);
                                        ?>
                                        <tr>
                                            <td>
                                                <span class="bold">Mã sản phẩm</span>
                                            </td>
                                            <td>
                                                <span id="sprytextfield1">
                                                    <input class="text-input small-input" type="text" name="masp" id="masp" readonly="readonly"
                                                           value="<?php echo $row['masotranh'] ?>" />
                                                    <span class="textfieldRequiredMsg">Nhập mã sản phẩm.</span>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="20%">
                                                <span class="bold">Loại sản phẩm</span>
                                            </td>
                                            <td width="80%">
                                                <input type="hidden" name="item" value="<?php echo $id ?>" />
                                                <select name="loaisp" id="loaisp">
                                                    <?php
                                                    include_once '../models/database.php';
                                                    $db = new database();
                                                    $db->setQuery("SELECT * FROM loaitranh");
                                                    $array = $db->loadAllRow();
                                                    foreach ($array as $value)
                                                    {
                                                        if ($value['maloai'] === $row['maloai'])
                                                            echo "<option value='" . $value['maloai'] . "' selected>" . $value['tenloai'] . "</option>";
                                                        else
                                                            echo "<option value='" . $value['maloai'] . "'>" . $value['tenloai'] . "</option>";
                                                    }
                                                    ?>
                                                </select>                                                
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Tên sản phẩm</span>
                                            </td>
                                            <td> 
                                                <input maxlength="100" class="text-input medium-input" type="text" id="tensp" name="tensp"
                                                       value="<?php echo $row['tentranh']; ?>" />                                            
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Chiều dài</span>
                                            </td>
                                            <td>
                                                <span id="sprytextfield2">
                                                    <input class="text-input small-input" type="text" id="dai" name="dai" value="<?php echo $row['dai'] ?>" />
                                                    <span class="textfieldRequiredMsg">Nhập chiều dài.</span>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Chiều rộng</span>
                                            </td>
                                            <td>
                                                <span id="sprytextfield3">
                                                    <input class="text-input small-input" type="text" name="rong" id="rong" value="<?php echo $row['rong'] ?>" />
                                                    <span class="textfieldRequiredMsg">Nhập chiều rộng.</span>
                                                </span>
                                            </td>
                                        </tr>   
                                        <tr>
                                            <td>
                                                <span class="bold">Giá bán</span>
                                            </td>
                                            <td>
                                                <?
                                                    $giaban = number_format($row['giaban'], 0);
                                                    $giaban = str_replace(",", "", $giaban);
                                                ?>
                                                <span id="sprytextfield4">
                                                    <input class="text-input small-input" type="text" name="giaban" id="giaban" value="<?php echo $giaban ?>" />
                                                    <span class="textfieldRequiredMsg">Giá bán phải là số nguyên dương.</span>
                                                </span>
                                            </td>
                                        </tr>  
                                        <tr>
                                            <td>
                                                <span class="bold">Ghi chú</span>
                                            </td>
                                            <td>
                                                <textarea id="ghichu" name="ghichu" cols="5" rows="3"><?php echo $row['ghichu'] ?></textarea>
                                            </td>
                                        </tr>                                                                       
                                        <tr>
                                            <td>
                                                <span class="bold">Thợ làm</span>
                                            </td>
                                            <td>
                                                <select id="tho" name="tho">
                                                    <?php
                                                    $db = new database();
                                                    $db->setQuery("SELECT * FROM tho");
                                                    $array = $db->loadAllRow();
                                                    foreach ($array as $value)
                                                    {
                                                        if ($value['matho'] === $row['matho'])
                                                            echo "<option value='" . $value['matho'] . "' selected>" . $value['hoten'] . "</option>";
                                                        else
                                                            echo "<option value='" . $value['matho'] . "'>" . $value['hoten'] . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Hình ảnh</span>
                                            </td>
                                            <td>
                                                <input type="hidden" name="image" value="<?php echo $row['hinhanh'] ?>" />
                                                <img alt='<?php echo $row['masotranh'] ?>' width=150 height=185 title='<?php echo $row['masotranh'] ?>' src='<?php echo "../" . $row['hinhanh'] ?>' />
                                                <br />
                                                <input class="small-input" name="hinhanh" type="file" lang="en" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Tông màu</span>
                                            </td>
                                            <td>
                                                <input class="small-input" id="tongmau" name="tongmau" value="<?php echo $row['tongmau'] ?>"/>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Hoa văn</span>
                                            </td>
                                            <td>
                                                <input class="small-input" id="hoavan" name="hoavan" value="<?php echo $row['hoavan'] ?>"/>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">
                                                <div class="bulk-actions align-left">
                                                    <input class="button" type="submit" name="submit" value="Cập nhật" />
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </form>
                            <br />
                            <br />
                        </div>
                    </div>
                </div>
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
        <script type="text/javascript">
            <!--
            //var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
            //var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
            //var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
            var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4", "integer");
            //-->
        </script>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
