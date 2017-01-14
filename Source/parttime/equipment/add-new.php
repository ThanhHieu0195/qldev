<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_EQUIPMENT, F_EQUIPMENT_ADD_NEW, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Tạo bàn giao dụng cụ</title>
        <?php require_once '../part/cssjs.php'; ?>
        <link rel="stylesheet" href="../resources/chosen/chosen.css">
        <style type="text/css" media="all">
          /* fix rtl for demo */
          .chosen-rtl .chosen-drop { left: -9000px; }
        </style>
        <style type="text/css">
            .name { color: blue; font-weight: bolder; }
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
        </style>
        <script type="text/javascript" src="../resources/scripts/utility/equipment/add-new.js"></script>
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
                <div class="clear"></div>
                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), F_EQUIPMENT_ADD_NEW)): ?>
                        <li>
                            <a class="shortcut-button add current" href="add-new.php">
                                <span class="png_bg">Tạo mới</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_EQUIPMENT_IMPORT_EXCEL)): ?>
                        <li>
                            <a class="shortcut-button excel" href="import-excel.php">
                                <span class="png_bg">Thêm từ Excel</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Thông tin dụng cụ</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab" style="display: block;">
                            <form id="add-new" method="post" action="">
                                <?php
                                require_once '../models/equipment.php';
                                
                                if(isset($_POST['submit'])) {
                                    $item = new equipment_entity();
                                    $item->equipment_id = trim($_POST['equipment_id']);
                                    $item->name = trim($_POST['name']);
                                    $item->status = trim($_POST['status']);
                                    $item->stored_in = $_POST['stored_in'];
                                    $item->assign_to = $_POST['assign_to'];
                                    $item->assign_date = trim($_POST['assign_date']);
                                    
                                    //debug($item);
                                    $model = new equipment();
                                    if ($model->insert($item)) {
                                    	$done = TRUE;
                                    } else {
                                        $done = FALSE;
                                        $message = $model->getMessage();
                                    }
                                }
                                ?>
                                <?php if(isset($done) && $done): ?>
                                <div class="notification success png_bg">
                                    <a class="close" href="#"><img alt="close" title="Close this notification" src="../resources/images/icons/cross_grey_small.png" /></a>
                                    <div>
                                        Thực hiện thao tác thành công!
                                    </div>
                                </div>
                                <?php endif; ?>
                                <?php if(isset($done) && ! $done): ?>
                                <div class="notification error png_bg">
                                    <a class="close" href="#"><img alt="close" title="Close this notification" src="../resources/images/icons/cross_grey_small.png" /></a>
                                    <div>
                                        Lỗi: <?php echo $message; ?>
                                    </div>
                                </div>
                                <?php endif; ?>
                                <fieldset>
                                    <p>
                                        <label for="equipment_id">Mã dụng cụ</label>
                                        <input maxlength="50" class="text-input small-input uid" type="text" id="equipment_id" name="equipment_id" value="" />
                                        <span class="error_icon input-notification error png_bg" id="error_equipment_id" title="Giá trị không hợp lệ"></span>
                                        <br /><small>Tối đa 50 ký tự và chỉ cho phép nhập các ký tự: 0-9, a-z, A-Z, _</small>
                                    </p>
                                    <p>
                                        <label>Tên dụng cụ</label>
                                        <input maxlength="255" class="text-input medium-input" type="text" id="name" name="name" value="" />
                                        <span class="error_icon input-notification error png_bg" id="error_name" title="Giá trị không hợp lệ"></span>
                                    </p>
                                    <p>
                                        <label>Tình trạng</label>
                                        <input maxlength="50" class="text-input small-input" type="text" id="status" name="status" value="" />
                                        <span class="error_icon input-notification error png_bg" id="error_status" title="Giá trị không hợp lệ"></span>
                                    </p>
                                    <p>
                                        <label>Nơi để (kho hàng/chi nhánh)</label>
                                        <select name="stored_in" id="stored_in" data-placeholder=" " class="chosen-select" style="width:350px;" tabindex="4">
                                            <option value=""></option>
                                            <?php 
                                            require_once '../models/khohang.php';
                                            
                                            $khohang = new khohang();
                                            $arr = $khohang->danh_sach();
                                            if(is_array($arr)):
                                                foreach ($arr as $item):
                                                    echo "<option value=\"{$item['makho']}\">{$item['tenkho']}</option>";
                                                endforeach;
                                            endif;
                                            ?>
                                        </select>
                                        <span class="error_icon input-notification error png_bg" id="error_stored_in" title="Giá trị không hợp lệ"></span>
                                    </p>
                                    <p>
                                        <label for="assign_to">Người chịu trách nhiệm</label>
                                        <select name="assign_to" id="assign_to" data-placeholder=" " class="chosen-select" style="width:350px;" tabindex="5">
                                            <option value=""></option>
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
                                        <span class="error_icon input-notification error png_bg" id="error_assign_to" title="Giá trị không hợp lệ"></span>
                                    </p>
                                    <p>
                                        <label>Ngày giao (yyyy-mm-dd)</label>
                                        <input style="max-width: 150px !important;" class="text-input small-input" type="text" name="assign_date" id="assign_date" readonly="readonly">
                                        <span class="error_icon input-notification error png_bg" id="error_assign_date" title="Giá trị không hợp lệ"></span>
                                    <p>
                                    <p>
                                        <input type="submit" class="button" value="Tạo"
                                               name="submit">
                                        <span id="attention" style="color: red; display: none">Có một số trường dữ liệu chưa đúng. Vui lòng kiểm tra lại!</span>
                                    </p>
                                </fieldset>
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
                                <div class="clear"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php include_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>