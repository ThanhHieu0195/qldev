<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_GUEST, F_GUEST_GUEST_GROUP, TRUE);

//Kiểm tra id của sản phẩm
if (!isset($_GET['item']))
    exit();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thông tin nhóm khách</title>
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

                    <li><a class="shortcut-button upload-image" href="group.php"><span class="png_bg">
                    Danh sách nhóm khách
                            </span></a></li>

                </ul><!-- End .shortcut-buttons-set -->

                <div class="content-box column-left" style="width:100%"><!-- Start Content Box -->

                    <div class="content-box-header">

                        <h3>Thông tin nhóm khách</h3>

                    </div> <!-- End .content-box-header -->

                    <div class="content-box-content">

                        <div class="tab-content default-tab">
                            <form action="" method="post">
                                <?php
                                include_once '../models/nhomkhach.php';
                                if (isset($_POST["submit"])) {

                                    $manhom = $_POST["manhom"];
                                    $tennhom = $_POST["tennhom"];

                                    $t = new nhomkhach();
                                    $result = $t->cap_nhat_nhom_khach($manhom, $tennhom);
                                    if ($result)
                                        echo '<center><span class="input-notification success png_bg">Cập nhật thông tin nhóm khách hàng thành công.</span></center><br /><br />';
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
                                        $manhom = $_GET['item'];
                                        $t = new nhomkhach();
                                        $row = $t->chi_tiet_nhom_khach($manhom);
                                        ?>
                                        <tr>
                                            <td width="20%">
                                                <span class="bold">Mã nhóm</span>                                            </td>
                                            <td width="80%">
                                                <input class="text-input small-input" readonly type="text" name="manhom" id="manhom" value="<?php echo $row['manhom'] ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Tên nhóm</span>                                            </td>
                                            <td>                                          <span id="sprytextfield2">
                                                    <input class="text-input small-input" type="text" name="tennhom" id="tennhom" value="<?php echo $row['tennhom'] ?>" />
                                                    <span class="textfieldRequiredMsg">Nhập tên loại.</span></span></td>
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