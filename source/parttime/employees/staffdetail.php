<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_EMPLOYEES, F_EMPLOYEES_STAFF_LIST, TRUE);

//Kiểm tra id của sản phẩm
if (!isset($_GET['item']))
    exit();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thông tin thợ làm tranh</title>
        <?php require_once '../part/cssjs.php'; ?>
        <style type="text/css">
            #main-content tbody tr.alt-row { background: none; }
        </style>
        
        <script type="text/javascript" src="../resources/scripts/utility/employee.js"></script>
    </head>

    <body>
        <div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->

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
                    <?php if (verify_access_right(current_account(), F_EMPLOYEES_STAFF_LIST)): ?>
                        <li>
                            <a class="shortcut-button upload-image" href="staff.php">
                                <span class="png_bg">Danh sách thợ</span>
                            </a>
                        </li>
                    <?php endif; ?>

                </ul><!-- End .shortcut-buttons-set -->

                <div class="content-box column-left" style="width:100%"><!-- Start Content Box -->

                    <div class="content-box-header">

                        <h3>Thông tin thợ</h3>

                    </div> <!-- End .content-box-header -->

                    <div class="content-box-content">

                        <div class="tab-content default-tab">
                            <form action="" method="post">
                                <?php
                                include_once '../models/tho.php';
                                if (isset($_POST["submit"])) {

                                    $id = $_POST["item"];
                                    $matho = $_POST["matho"];
                                    $hoten = $_POST["hoten"];
                                    $ngaysinh = $_POST["ngaysinh"];
                                    $diachi = $_POST["diachi"];
                                    $dienthoai = $_POST["dienthoai"];

                                    $db = new tho();
                                    $cap_nhat_tho = $db->cap_nhat_tho($id, $matho, $hoten, $ngaysinh, $diachi, $dienthoai);

                                    if ($cap_nhat_tho)
                                        echo '<center><span class="input-notification success png_bg">Cập nhật thông tin thợ thành công.</span></center><br /><br />';
                                    else
                                        echo '<center><span class="input-notification error png_bg">Lỗi: ' . $db->_error . '</span></center><br /><br />';
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
                                        $matho = $_GET['item'];
                                        $db = new tho();
                                        $row = $db->thong_tin_tho($matho);
                                        ?>

                                        <tr>
                                            <td width="20%">
                                                <span class="bold">Mã thợ</span>                                            </td>
                                            <td width="80%">
                                                <span id="sprytextfield1">
                                                    <input type="hidden" name="item" value="<?php echo $row['matho'] ?>" />
                                                    <input class="text-input small-input" type="text" name="matho" id="matho" value="<?php echo $row['matho'] ?>" />
                                                    <span class="textfieldRequiredMsg">Nhập mã nhân viên.</span>                                                </span>                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Họ tên</span>                                            </td>
                                            <td>                                    <span id="sprytextfield3">
                                                    <input class="text-input small-input" type="text" name="hoten" id="hoten" value="<?php echo $row['hoten'] ?>" />
                                                    <span class="textfieldRequiredMsg">Nhập họ tên.</span></span> </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Ngày sinh(yyyy-mm-dd)</span>                                            </td>
                                            <td>
                                                <span id="sprytextfield2">
                                                    <input class="text-input small-input" type="text" name="ngaysinh" id="ngaysinh" value="<?php echo $row['ngaysinh'] ?>" />
                                                    <span class="textfieldRequiredMsg">Nhập ngày sinh.</span>
                                                </span>
                                            </td>
                                        </tr> 
                                        <tr>
                                            <td>
                                                <span class="bold">Địa chỉ</span>                                            </td>
                                            <td>
                                                <input class="text-input medium-input" type="text" name="diachi" id="diachi" value="<?php echo $row['diachi'] ?>" /> </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Điện thoại</span>                                            </td>
                                            <td>
                                                <input class="text-input small-input" type="text" name="dienthoai" id="dienthoai" value="<?php echo $row['dienthoai'] ?>" /> </td>
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
            var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
            var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
            var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
            //-->
        </script>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>