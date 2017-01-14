<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate('', '', FALSE);

require_once '../models/account_role_group.php';
require_once '../models/account_role_of_employee.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thông tin cá nhân</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #main-content tbody tr.alt-row { background: none; }
        </style>
        <script type="text/javascript" src="../resources/scripts/utility/employee.js"></script>
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
                    <li>
                        <a class="shortcut-button personal-information current" href="../user/info.php">
                            <span class="png_bg">Thông tin</span>
                        </a>
                    </li>
                    <li>
                        <a class="shortcut-button password" href="../user/changepassword.php">
                            <span class="png_bg">Đổi mật khẩu</span>
                        </a>
                    </li>
                </ul>
                <?php
                require_once '../models/khohang.php';
                ?>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Thông tin cá nhân</h3>
                    </div>
                    <div class="content-box-content">
                        <?php 
                        // Get employee detail
                        $manv = current_account();

                        $nv = new nhanvien();
                        $obj = $nv->detail($manv);
                        
                        if ($obj != NULL):
                        ?>
                        <div class="tab-content default-tab">
                            <form action="" method="post">
                                <?php
                                if (isset($_POST["submit"])) {
                                    // Get input data
                                    $manv = $_POST["manv"];
                                    $macn = $_POST["macn"];
                                    $hoten = $_POST["hoten"];
                                    $ngaysinh = $_POST["ngaysinh"];
                                    $diachi = $_POST["diachi"];
                                    $dienthoai = $_POST["dienthoai"];
                                    $level = $_POST["level"];
                                    $email = $_POST["email"];

                                    // DB models
                                    $nv = new nhanvien ();
                                    
                                    // Get information from database
                                    $item = $nv->detail ( $manv );
                                    if ($item != NULL) {
                                        // Update information
                                        $item->ngaysinh = $ngaysinh;
                                        $item->diachi = $diachi;
                                        $item->dienthoai = $dienthoai;
                                        $item->email = $email;
                                        
                                        if ($nv->update ( $item )) {
                                            $result = TRUE;
                                            $message = "Thực hiện thao tác thành công.";
                                        } else {
                                            $result = FALSE;
                                            $message = $nv->getMessage ();
                                        }
                                    } else {
                                        $result = FALSE;
                                        $message = "Không tìm thấy thông tin chi tiết tài khoản '{$manv}'";
                                    }
                                    
                                    if ($result) {
                                        $obj = $nv->detail($manv);
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
                                        <input type="hidden" name="manv" value="<?php echo $obj->manv; ?>" />
                                        <tr>
                                            <td width="25%">
                                                <span class="bold">Chi nhánh/Showroom</span>
                                            </td>
                                            <?php 
                                            $model = new khohang();
                                            $tenkho = $model->ten_kho($obj->macn);
                                            ?>
                                            <td>
                                                <input type="hidden" name="macn" value="<?php echo $obj->macn; ?>" />
                                                <span class="orange bold"><?php echo $tenkho; ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Họ tên</span>
                                            </td>
                                            <td>
                                                <input type="hidden" name="hoten" value="<?php echo $obj->hoten; ?>" />
                                                <span class="blue-text bold"><?php echo $obj->hoten; ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Ngày sinh(yyyy-mm-dd)</span>
                                            </td>
                                            <td>
                                                <span id="sprytextfield2">
                                                    <input class="text-input small-input" type="text" name="ngaysinh" id="ngaysinh" readonly="readonly"
                                                           value="<?php echo $obj->ngaysinh; ?>" />
                                                    <span class="textfieldRequiredMsg">Nhập ngày sinh.</span>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Địa chỉ</span>
                                            </td>
                                            <td>
                                                <input class="text-input medium-input" type="text" name="diachi" id="diachi" value="<?php echo $obj->diachi; ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Điện thoại</span>
                                            </td>
                                            <td>
                                                <input class="text-input small-input" type="text" name="dienthoai" id="dienthoai" value="<?php echo $obj->dienthoai; ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Email</span>
                                            </td>
                                            <td>
                                                <input class="text-input small-input" type="text" name="email" id="email" value="<?php echo $obj->email; ?>" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Quyền đăng nhập</span>
                                            </td>
                                            <td>
                                                <?php
                                                // Get list role in system
                                                $role_model = new account_role_group();
                                                $list = $role_model->list_role();
                                                
                                                // Get list role (id) by account
                                                $role_of_employee_model = new account_role_of_employee();
                                                $tmp = $role_of_employee_model->list_role_of_account($obj->manv);
                                                $arr = array();
                                                foreach ($tmp as $i) {
                                                    $arr[] = $i->role_id;
                                                }
                                                
                                                $role_names = array();
                                                foreach ($list as $r) {
                                                    if (in_array($r->role_id, $arr) === TRUE) {
                                                        $role_names[] = $r->role_name;
                                                    }
                                                }
                                                
                                                // Get role(s) string
                                                $str = implode('; ', $role_names);
                                                ?>
                                                <span class="blue-violet bold"><?php echo $str; ?></span>
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
                        <?php endif; ?>
                    </div>
                </div>
                <?php require_once '../part/footer.php'; ?>
            </div>
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