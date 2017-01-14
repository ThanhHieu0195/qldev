<?php
require_once '../part/common_start_page.php';

// Get input data
$type = (isset($_GET['t'])) ? $_GET['t'] : 'employee';
if($type != 'freelancer') {
    $type = 'employee';
}

// Authenticate
if ($type == 'employee') { // Employee
    do_authenticate(G_EMPLOYEES, F_EMPLOYEES_ADD_EMPLOYEE, TRUE);
} else { // Freelancer
    do_authenticate(G_EMPLOYEES, F_EMPLOYEES_ADD_FREELANCER, TRUE);
}

require_once '../models/account_role_group.php';
require_once '../models/account_role_of_employee.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php if($type === 'freelancer') : ?>
            <title>Thêm cộng tác viên</title>
        <?php else: ?>
            <title>Thêm nhân viên</title>
        <?php endif; ?>
        
        <?php require_once '../part/cssjs.php'; ?>
        <link rel="stylesheet" href="../resources/chosen/chosen.css">
        <style type="text/css" media="all">
          /* fix rtl for demo */
          .chosen-rtl .chosen-drop { left: -9000px; }
        </style>
        <style type="text/css">
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
                <noscript>
                    <div class="notification error png_bg">
                        <div>
                            Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
                        </div>
                    </div>
                </noscript>
                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), F_EMPLOYEES_EMPLOYEE_LIST)) : ?>
                        <li>
                            <a class="shortcut-button employee" href="employee.php?type=employee">
                                <span class="png_bg">Danh sách nhân viên</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_EMPLOYEES_FREELANCER_LIST)) : ?>
                        <li>
                            <a class="shortcut-button freelancer" href="employee.php?type=freelancer">
                                <span class="png_bg">Danh sách cộng tác viên</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_EMPLOYEES_ADD_EMPLOYEE)) : ?>
                        <li>
                            <a class="shortcut-button add-employee <?php echo ($type == 'employee') ? "current" : "" ?>" href="addemployee.php">
                                <span class="png_bg">Thêm nhân viên mới</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_EMPLOYEES_ADD_FREELANCER)) : ?>
                        <li>
                            <a class="shortcut-button add-freelancer <?php echo ($type == 'freelancer') ? "current" : "" ?>" href="addemployee.php?t=freelancer">
                                <span class="png_bg">Thêm cộng tác viên</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <?php 
                if ($type == 'employee' || $type == 'freelancer'):
                ?>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <?php if($type === 'freelancer') : ?>
                            <h3>Thêm cộng tác viên</h3>
                        <?php else: ?>
                            <h3>Thêm nhân viên</h3>
                        <?php endif; ?>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form action="" method="post">
                                <?php
                                if (isset ( $_POST ["submit"] )) {
                                    // Get input data
                                    $manv = $_POST ["manv"];
                                    $macn = $_POST ["macn"];
                                    $password = md5 ( $_POST ["password"] );
                                    $hoten = $_POST ["hoten"];
                                    $ngaysinh = $_POST ["ngaysinh"];
                                    $diachi = $_POST ["diachi"];
                                    $dienthoai = $_POST ["dienthoai"];
                                    $level = $_POST ["level"];
                                    $email = $_POST ["email"];
                                    $bophan = $_POST ["bophan"];
                                    
                                    // DB models
                                    $nv = new nhanvien ();
                                    
                                    // Insert employee to database
                                    $item = new nhanvien_entity();
                                    $item->manv = $manv;
                                    $item->macn = $macn;
                                    $item->password = $password;
                                    $item->hoten = $hoten;
                                    $item->ngaysinh = $ngaysinh;
                                    $item->diachi = $diachi;
                                    $item->dienthoai = $dienthoai;
                                    $item->email = $email;
                                    $item->bophan = $bophan;
                                    
                                    $them_nhan_vien = $nv->insert($item);
                                    if ($them_nhan_vien) {
                                        $message = "";
                                        
                                        if (is_array($level) && count($level) > 0) {
                                            // DB model
                                            $role_of_employee_model = new account_role_of_employee();
                                            
                                            $message_format = "<br />• Nhóm quyền <span class='orange bold'>%s</span>: %s";
                                            
                                            // Entity
                                            $z = new account_role_of_employee_entity();
                                            $z->employee_id = $item->manv;
                                            
                                            foreach ($level as $l) {
                                                $z->role_id = $l;
                                                if ($role_of_employee_model->insert($z)) {
                                                    // Do nothing
                                                } else {
                                                    $them_nhan_vien = FALSE;
                                                    $message .= sprintf($message_format, $z->role_id, $role_of_employee_model->getMessage());
                                                }
                                            }

                                        } else {
                                            // Do nothing
                                        }
                                        
                                        if ($message === "") {
                                            $message = "Thực hiện thao tác thêm thành công.";
                                        } else {
                                            $message = "Lỗi khi thêm các nhóm quyền: " . $message;
                                        }
                                    } else {
                                        $message = $nv->getMessage();
                                    }
                                }
                                ?>
                                <?php if(isset($them_nhan_vien) && $them_nhan_vien): ?>
                                    <div class="notification information png_bg">
                                        <a href="#" class="close"><img src="../resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close"></a>
                                        <div><?php echo $message; ?></div>
                                    </div>
                                <?php endif; ?>
                                <?php if(isset($them_nhan_vien) && ! $them_nhan_vien): ?>
                                    <div class="notification error png_bg">
                                        <a href="#" class="close"><img src="../resources/images/icons/cross_grey_small.png" title="Close this notification" alt="close"></a>
                                        <div><?php echo $message; ?></div>
                                    </div>
                                <?php endif; ?>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td width="20%">
                                                <?php if($type === 'freelancer') : ?>
                                                    <span class="bold">Mã cộng tác viên</span>
                                                <?php else: ?>
                                                    <span class="bold">Mã nhân viên</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span id="sprytextfield1">
                                                    <input maxlength="50" class="text-input small-input uid" type="text" name="manv" id="manv" />
                                                    <i>(tối đa 50 ký tự và chỉ cho phép nhập các ký tự: <?php echo VALIDATE_UID; ?>)</i>
                                                    <span class="textfieldRequiredMsg">Nhập mã nhân viên.</span>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Họ tên</span>
                                            </td>
                                            <td>
                                                <span id="sprytextfield2">
                                                    <input class="text-input small-input" type="text" name="hoten" id="hoten" />
                                                    <span class="textfieldRequiredMsg">Nhập họ tên nhân viên.</span>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Ngày sinh(yyyy-mm-dd)</span>
                                            </td>
                                            <td>
                                                <span id="sprytextfield3">
                                                    <input class="text-input small-input" type="text" name="ngaysinh" id="ngaysinh" />
                                                    <span class="textfieldRequiredMsg">Nhập ngày sinh.</span>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Địa chỉ</span>
                                            </td>
                                            <td>
                                                <input class="text-input medium-input" type="text" name="diachi" id="diachi" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Điện thoại</span>
                                            </td>
                                            <td>
                                                <input class="text-input small-input" type="text" name="dienthoai" id="dienthoai" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Email</span>
                                            </td>
                                            <td>
                                                <input class="text-input small-input" type="text" name="email" id="email" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Chi nhánh</span>
                                            </td>
                                            <td>
                                                <span id="spryselect1">
                                                    <select id="macn" name="macn">
                                                        <option value=""></option>
                                                        <?php 
                                                            require_once '../models/khohang.php';
                                                            
                                                            $model = new khohang();
                                                            $arr = $model->danh_sach();
                                                            
                                                            if (is_array($arr)) {
                                                                foreach ($arr as $z):
                                                            ?>
                                                                <option value="<?php echo $z['makho']; ?>"><?php echo $z['tenkho']; ?></option>
                                                            <?php 
                                                                endforeach;
                                                            }
                                                        ?>
                                                    </select>
                                                    <span class="selectRequiredMsg">Chọn chi nhánh.</span>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Mật khẩu</span>
                                            </td>
                                            <td>
                                                <span id="sprytextfield4">
                                                    <input class="text-input small-input" type="text" name="password" id="password" />
                                                    <span class="textfieldRequiredMsg">Nhập mật khẩu.</span>
                                                </span>
                                            </td>
                                        </tr>
                                        <?php if($type === 'freelancer') : ?>
                                            <span id="spryselect2">
                                                <input type="hidden" id="level" name="level[]" value="<?php echo ROLE_FREELANCER; ?>" />
                                            </span>
                                        <?php else : ?>
                                            <tr>
                                                <td>
                                                    <span class="bold">Quyền đăng nhập</span>
                                                </td>
                                                <td>
                                                    <span id="spryselect2">
                                                        <select id="level" name="level[]" data-placeholder=" " class="chosen-select" multiple style="width:350px;">
                                                            <option value=""></option>
                                                            <?php 
                                                            $role_model = new account_role_group();
                                                            $list = $role_model->list_role();
                                                            
                                                            foreach ($list as $r):
                                                                if ($r->role_id != ROLE_FREELANCER):
                                                            ?>
                                                                <option value="<?php echo $r->role_id; ?>"><?php echo $r->role_name; ?></option>
                                                            <?php else: ?>
                                                                <option disabled="disabled" value="<?php echo $r->role_id; ?>"><?php echo $r->role_name; ?></option>
                                                            <?php 
                                                                endif;
                                                            endforeach; 
                                                            ?>
                                                        </select>
                                                        <span class="selectRequiredMsg">Chọn nhóm quyền.</span>
                                                    </span>
                                                </td>
                                            </tr>
                                            <!-- bộ phận -->
                                            <tr>
                                                <td><span class="bold">Bộ phận</span></td>
                                                <td>
                                                    <select name="bophan" id="bophan" style="width: 200px;">
                                                        <option value="">Chọn bộ phận ... </option>
                                                        <option value="0">sĩ</option>
                                                        <option value="1">lẻ</option>
                                                    </select>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2">
                                                <div class="bulk-actions align-left">
                                                    <input class="button" type="submit" name="submit" value="Thêm" />
                                                </div>
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </form>
                            <script src="../resources/chosen/chosen.jquery.js" type="text/javascript"></script>
                            <script src="../resources/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
                            <script type="text/javascript">
                                    var config = {
                                      '.chosen-select'           : {},
                                      '.chosen-select-deselect'  : {allow_single_deselect:true},
                                      '.chosen-select-no-single' : {disable_search_threshold:10},
                                      '.chosen-select-no-results': {no_results_text:'Oops, nothing found!'},
                                      '.chosen-select-width'     : {width:"95%"}
                                    };
                                    for (var selector in config) {
                                      $(selector).chosen(config[selector]);
                                    }
                            </script>
                            <br />
                            <br />
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
        <script type="text/javascript">
            <!--
            var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
            var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
            var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
            var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
            var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
            var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
            //-->
        </script>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>