<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate('', '', FALSE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Đổi mật khẩu</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css">
            #main-content tbody tr.alt-row { background: none; }
        </style>
    </head>

    <body>
        <div id="body-wrapper"> <!-- Wrapper for the radial gradient background -->

            <?php require_once '../part/menu.php'; ?>

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
                <div class="clear"></div>
                <ul class="shortcut-buttons-set">
                    <li>
                        <a class="shortcut-button personal-information" href="../user/info.php">
                            <span class="png_bg">Thông tin</span>
                        </a>
                    </li>
                    <li>
                        <a class="shortcut-button password current" href="../user/changepassword.php">
                            <span class="png_bg">Đổi mật khẩu</span>
                        </a>
                    </li>
                </ul>
                
                <div class="content-box column-left" style="width:100%"><!-- Start Content Box -->

                    <div class="content-box-header">

                        <h3>Đổi mật khẩu</h3>

                    </div> <!-- End .content-box-header -->

                    <div class="content-box-content">

                        <div class="tab-content default-tab">
                            <form action="" method="post">
                                <?php
                                if (isset($_POST["submit"])) {

                                    $pwd = $_POST["oldpwd"];
                                    $oldpwd = md5($pwd);
                                    $newpwd1 = $_POST["newpwd1"];
                                    $newpwd2 = $_POST["newpwd2"];

                                    $ok = 1;

                                    if ($oldpwd != current_account(PASSWORD)) {
                                        $ok = 0;
                                        echo '<center><span class="input-notification error png_bg">Mật khẩu nhập vào không đúng</span></center><br /><br />';
                                    } elseif ($newpwd1 != $newpwd2) {
                                        $ok = 0;
                                        echo '<center><span class="input-notification error png_bg">Mật khẩu xác nhận không đúng</span></center><br /><br />';
                                    }
                                    if ($ok == 1) {
                                        require_once '../models/nhanvien.php';
                                        require_once '../config/constants.php';
                                        $nv = new nhanvien();
                                        $newpassword = md5($newpwd1);
                                        $doi_mat_khau = $nv->doi_mat_khau(current_account(), $newpassword);
                                        if ($doi_mat_khau) {
                                            set_current_account(PASSWORD, $newpassword);
                                            echo '<center><span class="input-notification success png_bg">Đổi mật khẩu thành công.</span></center><br /><br />';
                                        }
                                        else
                                            echo '<center><span class="input-notification error png_bg">Lỗi: ' . $nv->_error . '</span></center><br /><br />';
                                    }
                                }
                                ?>
                                <table>                                                       
                                    <tfoot>                                        
                                        <tr>
                                            <td colspan="2">
                                                <div class="bulk-actions align-left">
                                                    <input class="button" type="reset" value="Nhập lại" />
                                                    <input class="button" type="submit" name="submit" value="Đổi mật khẩu" />
                                                </div>                                            </td>
                                        </tr>
                                    </tfoot>

                                    <tbody>                                        

                                        <tr>
                                            <td width="30%">
                                                <span class="bold">Mật khẩu cũ</span>                                            </td>
                                            <td width="80%">
                                                <span id="sprytextfield1">
                                                    <input class="text-input small-input" type="password" name="oldpwd" id="masp" value="<?php echo $pwd ?>" />
                                                    <span class="textfieldRequiredMsg">Nhập mật khẩu.</span>                                                </span>                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Mật khẩu mới</span>                                            </td>
                                            <td>
                                                <span id="sprytextfield2">
                                                    <input class="text-input small-input" type="password" id="newpwd1" name="newpwd1" value="<?php echo $newpwd1 ?>" />
                                                    <span class="textfieldRequiredMsg">Nhập mật khẩu mới.</span>                                                </span>                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Xác nhận mật khẩu mới</span>                                            </td>
                                            <td>
                                                <span id="sprytextfield3">
                                                    <input class="text-input small-input" type="password" name="newpwd2" id="newpwd2" value="<?php echo $newpwd2 ?>" />
                                                    <span class="textfieldRequiredMsg">Nhập mật khẩu xác nhận.</span>                                                </span>                                            </td>
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