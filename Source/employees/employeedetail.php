<?php
require_once '../part/common_start_page.php';

// Get input data
$type = (isset($_GET['type'])) ? $_GET['type'] : 'employee';
if($type != 'freelancer') {
    $type = 'employee';
}

// Authenticate
if ($type == 'employee') { // Employee
    do_authenticate(G_EMPLOYEES, F_EMPLOYEES_EMPLOYEE_LIST, TRUE);
} else { // Freelancer
    do_authenticate(G_EMPLOYEES, F_EMPLOYEES_FREELANCER_LIST, TRUE);
}

require_once '../models/account_role_group.php';
require_once '../models/account_role_of_employee.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php if($type === 'freelancer') : ?>
            <title>Thông tin cộng tác viên</title>
        <?php else: ?>
            <title>Thông tin nhân viên</title>
        <?php endif; ?>
        
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
        </style>
        
        <link rel="stylesheet" href="../resources/chosen/chosen.css">
        <style type="text/css" media="all">
          /* fix rtl for demo */
          .chosen-rtl .chosen-drop { left: -9000px; }
        </style>
        
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #dt_example span { font-weight: normal !important; }
            #main-content tbody tr.alt-row { background: none; }
        </style>
        
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
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
                            <a class="shortcut-button add-employee" href="addemployee.php">
                                <span class="png_bg">Thêm nhân viên mới</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_EMPLOYEES_ADD_FREELANCER)) : ?>
                        <li>
                            <a class="shortcut-button add-freelancer" href="addemployee.php?t=freelancer">
                                <span class="png_bg">Thêm cộng tác viên</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <?php if($type === 'freelancer') : ?>
                            <h3>Thông tin cộng tác viên</h3>
                        <?php else: ?>
                            <h3>Thông tin nhân viên</h3>
                        <?php endif; ?>
                    </div>
                    <div class="content-box-content">
                        <?php 
                        // Get employee detail
                        $manv = (isset($_GET['item'])) ? $_GET['item'] : '';
                        $obj =  NULL;
                        
                        // Kiem tra neu account la 'admin'
                        if (strtoupper($manv) != ACCOUNT_ADMIN) {
                            $nv = new nhanvien();
                            
                            $obj = $nv->detail($manv);
                        }
                        
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
                                    $dienthoaiban = $_POST["dienthoaiban"];
                                    $level = $_POST["level"];
                                    $email = $_POST["email"];
                                    $assign_to = $_POST["assign_to"];
                                    $password = md5($_POST["mkmoi"]);
                                    $doimatkhau = (isset($_POST['checkboxdoimatkhau'])) ? TRUE : FALSE;
                                    $bophan = $_POST['bophan'];
                                    // DB models
                                    $nv = new nhanvien ();
                                    require_once '../models/guest_responsibility.php';
                                    $responsibility_model = new guest_responsibility ();
                                    if ((isset($assign_to))&&($assign_to != NULL)) {
                                        if (! ($responsibility_model->re_assign_all($manv, $assign_to))) {
                                            $result = FALSE;
                                            $message = "Lỗi bàn giao khách hàng";
                                        } 
                                    }
                                    
                                    // Get information from database
                                    $item = $nv->detail ( $manv );
                                    if ($item != NULL) {
                                        // Update information
                                        $item->macn = $macn;
                                        if ($doimatkhau) {
                                            $item->password = $password;
                                        }
                                        $item->hoten = $hoten;
                                        $item->ngaysinh = $ngaysinh;
                                        $item->diachi = $diachi;
                                        $item->dienthoai = $dienthoai;
                                        $item->dienthoaiban = $dienthoaiban;
                                        $item->email = $email;
                                        $item->bophan = $bophan;
                                        
                                        if ($nv->update ( $item )) {
                                            $message = "";
                                            // DB model
                                            $role_of_employee_model = new account_role_of_employee ();
                                            
                                            // Remove old level(s)
                                            if ($role_of_employee_model->delete_by_account($item->manv)) {
                                                // Add new level(s)
                                                if (is_array ( $level ) && count ( $level ) > 0) {
                                                    $message_format = "<br />• Nhóm quyền <span class='orange bold'>%s</span>: %s";
                                                    
                                                    // Entity
                                                    $z = new account_role_of_employee_entity ();
                                                    $z->employee_id = $item->manv;
                                                    
                                                    foreach ( $level as $l ) {
                                                        $z->role_id = $l;
                                                        if ($role_of_employee_model->insert ( $z )) {
                                                            // Do nothing
                                                        } else {
                                                            $them_nhan_vien = FALSE;
                                                            $message .= sprintf ( $message_format, $z->role_id, $role_of_employee_model->getMessage () );
                                                        }
                                                    }
                                                } else {
                                                    // Do nothing
                                                }
                                                
                                                if ($message === "") {
                                                    $result = TRUE;
                                                    $message = "Thực hiện thao tác thành công.";
                                                } else {
                                                    $result = FALSE;
                                                    $message = "Lỗi khi thêm các nhóm quyền: " . $message;
                                                }
                                            } else {
                                                $result = FALSE;
                                                $message = $role_of_employee_model->getMessage ();
                                            }
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
                                                    <input class="text-input small-input" type="text" name="manv" id="manv" readonly value="<?php echo $obj->manv; ?>" />
                                                    <span class="textfieldRequiredMsg">Nhập mã nhân viên.</span>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Chi nhánh/Showroom</span>
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
                                                            <option <?php echo ($z['makho'] == $obj->macn) ? 'selected' : ''; ?> value="<?php echo $z['makho']; ?>"><?php echo $z['tenkho']; ?></option>
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
                                                <span class="bold">Họ tên</span>
                                            </td>
                                            <td>
                                                <span id="sprytextfield3">
                                                    <input class="text-input small-input" type="text" name="hoten" id="hoten" value="<?php echo $obj->hoten; ?>" />
                                                    <span class="textfieldRequiredMsg">Nhập họ tên.</span>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Ngày sinh(yyyy-mm-dd)</span>
                                            </td>
                                            <td>
                                                <span id="sprytextfield2">
                                                    <input class="text-input small-input" type="text" name="ngaysinh" id="ngaysinh" 
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
                                                <span class="bold">Điện thoại bàn</span>
                                            </td>
                                            <td>
                                                <input class="text-input small-input" type="text" name="dienthoaiban" id="dienthoaiban" value="<?php echo $obj->dienthoaiban; ?>" />
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
                                                            
                                                            // Get list role by account
                                                            $role_of_employee_model = new account_role_of_employee();
                                                            $tmp = $role_of_employee_model->list_role_of_account($obj->manv);
                                                            $arr = array();
                                                            foreach ($tmp as $i) {
                                                                $arr[] = $i->role_id;
                                                            }
                                                            
                                                            foreach ($list as $r):
                                                                $selected = '';
                                                                if (in_array($r->role_id, $arr) === TRUE) {
                                                                    $selected = 'selected';
                                                                }
                                                                if ($r->role_id == ROLE_FREELANCER) {
                                                                    $selected = 'disabled';
                                                                }
                                                            ?>
                                                                <option <?php echo $selected; ?> value="<?php echo $r->role_id; ?>"><?php echo $r->role_name; ?></option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                        <span class="selectRequiredMsg">Chọn nhóm quyền.</span>
                                                    </span>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                        <tr>
                                            <td>
                                                <input type="checkbox" name="checkboxdoimatkhau" id="checkboxdoimatkhau" title="Click chọn nếu muốn đổi mật khẩu" />
                                                <span class="bold">Mật khẩu mới</span>
                                            </td>
                                            <td>
                                                <input name="mkmoi" id="mkmoi" type="text" class="text-input small-input" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Bàn giao khách hàng: </span>
                                            </td>
                                            <td>
                                                <select name="assign_to" id="assign_to">
                                                    <option value="">Chọn nhân viên theo dõi...</option>
                                                    <?php
                                                        require_once '../models/nhanvien.php';

                                                        $nhanvien = new nhanvien();
                                                        $arr = $nhanvien->employee_list();
                                                        if(is_array($arr)):
                                                            foreach ($arr as $item):
                                                                echo "<option value=\"{$item['manv']}\">{$item['hoten']}</option>";
                                                            endforeach;
                                                        endif;
                                                    ?>
                                                </select>
                                            </td>
                                        </tr>
                                        <!-- bộ phận -->
                                        <tr> 
                                                
                                            <td><span class="bold">Bộ phận: </span> </td>

                                             <td>
                                                <select name="bophan" id="bophan">
                                                    <option value="">Chọn bộ phận...</option>
                                                <?php if ($obj->bophan == 0): ?>
                                                    <option value="0" selected="">sĩ</option>>
                                                <?php else: ?>
                                                    <option value="0" >sĩ</option>>
                                                 <?php endif; ?>

                                                 <?php if ($obj->bophan == 1): ?>
                                                    <option value="1" selected="">lẻ</option>>
                                                <?php else: ?>
                                                    <option value="1" >lẻ</option>>
                                                 <?php endif; ?>
                                                </select>
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
                        <?php endif; ?>
                    </div>
                </div>
                
                <?php if ($obj != NULL && is_freelancer($obj->manv)): ?>
                    <script type="text/javascript" charset="utf-8">
                            $(function() {
                                var oTable = $('#example').dataTable( {
                                    "bProcessing": true,
                                    "bServerSide": true,
                                    "bPaginate": false,
                                    "sAjaxSource": "../ajaxserver/assign_freelancer_list_server.php?id=<?php echo $obj->uid; ?>",
                                    "aoColumnDefs": [
                                        { "sClass": "center", "aTargets": [ 4 ] }
                                    ],
                                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                                        $('td:eq(0)', nRow).html("<span class='blue-text'>" + aData[0] + "</span>");
                                        $('td:eq(1)', nRow).html(aData[1]);
                                        $('td:eq(2)', nRow).html("<span class='blue-violet'>" + aData[2] + "</span>");
                                        $('td:eq(3)', nRow).html(aData[3]);
                                        $('td:eq(4)', nRow).html("<span class='blue-text'>" + aData[4] + "</span>");
                                    }
                                });
                            });
                    </script>
                    <div class="content-box column-left" style="width:100%">
                        <div class="content-box-header">
                            <h3>Danh sách coupon assign cho cộng tác viên</h3>
                        </div>
                        <div class="content-box-content tab-content default-tab" id="dt_example">
                            <div id="container">
                                <div id="demo">
                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                        <thead>
                                            <tr>
                                                <th>Mã coupon</th>
                                                <th>Nhóm coupon</th>
                                                <th>Hạn sử dụng</th>
                                                <th>Loại</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
        <script type="text/javascript">
            <!--
            var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
            var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
            var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1");
            var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
            //-->
        </script>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
