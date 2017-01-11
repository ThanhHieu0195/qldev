<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_EMPLOYEES, F_EMPLOYEES_EMPLOYEE_GROUP, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thông tin nhóm nhân viên</title>
        <?php require_once '../part/cssjs.php'; ?>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <style type="text/css">
            .name { color: blue; font-weight: bolder; }
            .ui-autocomplete-loading {
                background: white url('../resources/images/loading.gif') right center no-repeat !important;
            }
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #main-content tbody tr.alt-row { background: none; }
            .fixed-dialog{ top: 8% !important; left: 20% !important; }
            table.dataTable { margin: 0 auto; clear: both; width: 100% !important;}
            .ui-dialog-titlebar-close { visibility: hidden; }
            #dt_example span { font-weight: normal !important; }
            img { vertical-align: middle; }
            #notification_msg span { font-size: 13px; }
            td p label { color: blue; }
            #example_wrapper { vertical-align: middle; }
        </style>
        <link rel="stylesheet" href="../resources/chosen/chosen.css">
        <style type="text/css" media="all">
          /* fix rtl for demo */
          .chosen-rtl .chosen-drop { left: -9000px; }
        </style>
        <script type="text/javascript" src="../resources/scripts/utility/employees/employee-group.js"></script>
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
                    <?php if (verify_access_right(current_account(), F_EMPLOYEES_EMPLOYEE_GROUP)) : ?>
                        <li>
                            <a class="shortcut-button employee" href="../employees/employee_group_list.php">
                                <span class="png_bg">Danh sách nhóm</span>
                            </a>
                        </li>
                        <li>
                            <a class="shortcut-button add-freelancer" href="../employees/employee_group_add.php">
                                <span class="png_bg">Thêm nhóm mới</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%"><!-- Start Content Box -->
                    <div class="content-box-header">
                        <h3>Thông tin nhóm nhân viên</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <?php 
                            require_once '../models/employee_group.php';
                            require_once '../models/employee_group_members.php';
                            
                            $group_model = new employee_group();
                            $members_model = new employee_group_members();
                            
                            $g = $group_model->detail(isset($_GET['i']) ? $_GET['i'] : '');
                            ?>
                            <?php if ($g != NULL): ?>
                                <form id="update_group" action="" method="post">
                                    <?php
                                    $submited = FALSE;
                                    $message = '';
                                    
                                    if (isset($_POST['update_group'])) {
                                        $submited = TRUE;
                                        
                                        // Get form input
                                        if (empty($_POST['group_name']) || empty($_POST ['members_list'])) {
                                            $done = FALSE;
                                            $message = "Invalid data";
                                        } else {
                                            $done = TRUE;
                                        }
                                        if ($done) {
                                            $group_id = $_POST['group_id'];
                                            $group_name = $_POST['group_name'];
                                            $members = $_POST ['members_list'];
                                            $enable = isset($_POST['enable']);
                                            
                                            // Group detail
                                            $g = $group_model->detail($group_id);
                                            $g->group_name = $group_name;
                                            $g->enable = $enable;
                                            $done = $group_model->update($g);
                                            if ($done) {
                                                // Delete old members
                                                $done = $members_model->delete_by_group($g->group_id);
                                                if ($done) {
                                                    // Insert new members
                                                    foreach ($members as $e) {
                                                        $m = new employee_group_members_entity();
                                                        $m->group_id = $g->group_id;
                                                        $m->employee_id = $e;
                                                        $done = $members_model->insert($m);
                                                        if (!$done) {
                                                            $message = $members_model->getMessage();
                                                            break;
                                                        }
                                                    }
                                                } else {
                                                    $message = $members_model->getMessage();
                                                }
                                            } else {
                                                $message = $group_model->getMessage();
                                            }
                                        }
                                    } 
                                    ?>
                                    <?php if($submited && $done): ?>
                                    <div class="notification success png_bg">
                                        <a class="close" href="#">
                                            <img alt="close" title="Close this notification" src="../resources/images/icons/cross_grey_small.png" />
                                        </a>
                                        <div>
                                           <?php echo 'Thực hiện thao tác thành công.'; ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <?php if($submited && ( ! $done)): ?>
                                    <div class="notification error png_bg">
                                        <a class="close" href="#">
                                            <img alt="close" title="Close this notification" src="../resources/images/icons/cross_grey_small.png" >
                                        </a>
                                        <div>
                                           <?php echo(sprintf('Lỗi thao tác: %s.', $message)); ?>
                                        </div>
                                    </div>
                                    <?php endif; ?>
                                    <table>
                                        <tbody>
                                            <tr>
                                                <td width="25%">
                                                    <label for="group_name">Tên nhóm (*)</label>
                                                </td>
                                                <td>
                                                    <input type="hidden" name="group_id" value="<?php echo $g->group_id; ?>" />
                                                    <input type="text" name="group_name" id="group_name" class="text-input medium-input" maxlength="50" value="<?php echo $g->group_name; ?>" />
                                                    <span class="error_icon input-notification error png_bg" id="error_group_name" title="Nhập dữ liệu"></span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label for="role_name">Trạng thái</label>
                                                </td>
                                                <td>
                                                    <?php $enable = ($g->enable == BIT_TRUE) ? "checked='checked'" : ""; ?>
                                                    <input type="checkbox" name="enable" <?php echo $enable; ?>" /> Enable
                                                </td>
                                            </tr>
                                            <tr>
                                                <td><label>Danh sách nhân viên:</label></td>
                                                <td>
                                                    <select name="members_list[]" id="members_list" data-placeholder=" " class="chosen-select" multiple style="width:350px;" tabindex="4">
                                                        <option value=""></option>
                                                        <?php 
                                                        require_once '../models/nhanvien.php';
                                                        
                                                        //List members of group
                                                        $members = $members_model->list_members_of_group($g->group_id, FALSE);
                                                        // Employees list
                                                        $nhanvien = new nhanvien();
                                                        $arr = $nhanvien->employee_list();
                                                        if(is_array($arr)):
                                                            foreach ($arr as $item):
                                                                $selected = '';
                                                                if (in_array($item['manv'], $members['employee_id']) === TRUE) {
                                                                    $selected = 'selected';
                                                                }
                                                        ?>
                                                            <option <?php echo $selected; ?> value="<?php echo $item['manv']; ?>"><?php echo $item['hoten']; ?></option>;
                                                        <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                    <span class="error_icon input-notification error png_bg" id="error_members_list" title="Nhập dữ liệu"></span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="2">
                                                    <div class="bulk-actions align-left"></div>
                                                    <div class="clear"></div>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                    <div class="clear"></div>
                                    <fieldset id="control_panel">
                                        <p>
                                            <input type="submit" class="button" value="Cập nhật nhóm" name="update_group">
                                            <span id="attention" style="color: red;">Có một số trường dữ liệu chưa đúng. Vui lòng kiểm tra lại!</span>
                                        </p>
                                    </fieldset>
                                    <div class="clear"></div>
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
                                </form>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>