<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_STORES, F_STORES_ADD_STORE, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thêm kho hàng</title>
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
                    <?php if (verify_access_right(current_account(), F_STORES_STORE_LIST)): ?>
                        <li>
                            <a class="shortcut-button upload-image" href="storelist.php">
                                <span class="png_bg">Danh sách kho hàng</span>
                            </a>
                        </li>
                    <?php endif; ?>

                </ul><!-- End .shortcut-buttons-set -->            

                <div class="content-box column-left" style="width:100%">

                    <div class="content-box-header">

                        <h3>Thêm kho hàng mới</h3>

                    </div>

                    <div class="content-box-content">

                        <div class="tab-content default-tab">
                            <form action="" method="post">
                                <?php
                                if (isset($_POST['submit'])) {
                                    $ok = 1;  //bien kiem tra tinh hop le cua du lieu

                                    $tenkho = $_POST['tenkho'];
                                    $diachi = $_POST['diachi'];
                                    $dienthoai = $_POST['dienthoai'];

                                    include_once '../models/khohang.php';
                                    $kho = new khohang();
                                    $them_kho = $kho->them_kho($tenkho, $diachi, $dienthoai);
                                    //them khach hang thanh cong
                                    if ($them_kho) {
                                        echo '<center><span class="input-notification success png_bg">Thêm kho hàng thành công</span><br /><br /></center>';
                                    } else {
                                        echo '<center><span class="input-notification error png_bg">' . $kho->getMessage() . '</span></center>';
                                    }
                                }
                                ?>
                                <table>                                                       
                                    <tfoot>                                        
                                        <tr>
                                            <td colspan="2">
                                                <div class="bulk-actions align-left">
                                                    <input class="button" type="submit" name="submit" value="Thêm kho hàng" />
                                                </div>                                            </td>
                                        </tr>
                                    </tfoot>

                                    <tbody>                                        
                                        <tr>
                                            <td width="20%">
                                                <span class="bold">Tên kho</span>                                            </td>
                                            <td width="80%">
                                                <span id="sprytextfield1">
                                                    <input class="text-input small-input" type="text" id="tenkho" name="tenkho" />
                                                    <span class="textfieldRequiredMsg">Nhập tên kho.</span></span> </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <span class="bold">Địa chỉ</span>                                            </td>
                                            <td>
                                                <span id="sprytextfield2">
                                                    <input class="text-input medium-input" type="text" id="diachi" name="diachi" />
                                                    <span class="textfieldRequiredMsg">Nhập địa chỉ.</span></span> </td>
                                        </tr>

                                        <tr>
                                            <td>
                                                <span class="bold">Điện thoại</span>                                            </td>
                                            <td><span id="sprytextfield3">
                                              <input class="text-input small-input" type="text" id="dienthoai" name="dienthoai" />
                                            <span class="textfieldRequiredMsg">Nhập số điện thoại.</span></span></td>
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