<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ITEMS, F_ITEMS_TYPE, TRUE);

//Kiểm tra id của sản phẩm
if (!isset($_GET['item']))
    exit();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thông tin loại sản phẩm</title>
        <?php require_once '../part/cssjs.php'; ?>
        <style type="text/css">
            #main-content tbody tr.alt-row { background: none; }
        </style>
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

                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), F_ITEMS_TYPE)): ?>
                        <li>
                            <a class="shortcut-button upload-image" href="type.php">
                                <span class="png_bg">Danh sách loại tranh</span>
                            </a>
                        </li>
                    <?php endif; ?>

                </ul><!-- End .shortcut-buttons-set -->

                <div class="content-box column-left" style="width:100%"><!-- Start Content Box -->

                    <div class="content-box-header">

                        <h3>Thông tin loại sản phẩm</h3>

                    </div> <!-- End .content-box-header -->

                    <div class="content-box-content">

                        <div class="tab-content default-tab">
                            <form action="" method="post">
                                <?php
                                include_once '../models/loaitranh.php';
                                if (isset($_POST["submit"])) {

                                    $maloai = $_POST["maloai"];
                                    $tenloai = $_POST["tenloai"];
                                    $donvi = $_POST["donvi"];
                                    $giasi = $_POST["giasi"];
                                    $giale = $_POST["giale"];

                                    $t = new loaitranh();
                                    $result = $t->cap_nhat_loai_tranh($maloai, $tenloai, $donvi, $giasi, $giale);
                                    if ($result)
                                        echo '<center><span class="input-notification success png_bg">Cập nhật thông tin loại tranh thành công.</span></center><br /><br />';
                                    else
                                        echo '<center><span class="input-notification error png_bg">Lỗi: ' . $t->_error . '</span></center><br /><br />';
                                }
                                ?>
                                <table>                                                       
                                    <tfoot>                                        
                                        <tr>
                                            <td colspan="2">
                                                <div class="bulk-actions align-left">
                                                    <input class="button" type="submit" name="submit" value="Cập nhật" />
                                                </div>                                            </td>
                                        </tr>
                                    </tfoot>
                                    <tbody>
                                        <?php
                                        $maloai = $_GET['item'];
                                        $t = new loaitranh();
                                        $row = $t->chi_tiet_loai_tranh($maloai);
                                        ?>
                                        <tr>
                                            <td width="20%">
                                                <span class="bold">Mã loại</span>                                            </td>
                                            <td width="80%">
                                                <input class="text-input small-input" readonly type="text" name="maloai" id="maloai" value="<?php echo $row['maloai'] ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Tên loại</span>
                                            </td>
                                            <td>
                                                <span id="sprytextfield2">
                                                    <input class="text-input small-input" type="text" name="tenloai" id="tenloai" value="<?php echo $row['tenloai'] ?>" />
                                                    <span class="textfieldRequiredMsg">Nhập tên loại.</span>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Đơn vị tính</span>
                                            </td>
                                            <td>
                                                <span id="sprytextfield3">
                                                    <input class="text-input small-input" type="text" name="donvi" id="donvi" value="<?php echo $row['donvi'] ?>" />
                                                    <span class="textfieldRequiredMsg">Nhập đơn vị tính.</span>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">% Giá sĩ</span>
                                            </td>
                                            <td>
                                                <span id="sprytextfield3">
                                                    <input class="text-input small-input" type="text" name="giasi" id="giasi" value="<?php echo $row['giasi'] ?>" />
                                                    <span class="textfieldRequiredMsg">Nhập % Giá sĩ</span>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">% Giá lẻ</span>
                                            </td>
                                            <td>
                                                <span id="sprytextfield3">
                                                    <input class="text-input small-input" type="text" name="giale" id="giale" value="<?php echo $row['giale'] ?>" />
                                                    <span class="textfieldRequiredMsg">Nhập % Giá lẻ</span>
                                                </span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </form>
                            <br />
                            <br />
                        </div> <!-- End #tab3 -->

                    </div> <!-- End .content-box-content -->

                </div> <!-- End .content-box -->

                <?php require_once '../part/footer.php'; ?>

            </div> <!-- End #main-content -->

        </div>
        <script type="text/javascript">
            <!--
            var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
            //-->
        </script>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
