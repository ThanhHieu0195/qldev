<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_GUEST_DEVELOPMENT, '', TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Cập nhật thông tin khách hàng cần phát triển</title>
        <?php require_once '../part/cssjs.php'; ?>
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #main-content tbody tr.alt-row { background: none; }
        </style>
        <script type="text/javascript" src="../resources/scripts/utility/guest_development/add-new.js"></script>
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
                    <li>
                        <a class="shortcut-button add" href="../guest_development/add-new.php">
                            <span class="png_bg">Thêm khách hàng cần phát triển</span>
                        </a>
                    </li>
                    <li>
                        <a class="shortcut-button list" href="../guest_development/add-from-db.php">
                            <span class="png_bg">Thêm khách hàng cần phát triển từ hệ thống</span>
                        </a>
                    </li>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Cập nhật thông tin khách hàng cần phát triển</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab" style="display: block;">
                        <?php 
                        require_once '../models/khach.php';
                        require_once '../models/guest_events.php';
                        require_once '../models/guest_responsibility.php';
                        
                        // Get input data
                        $guest_id = (isset($_GET['i'])) ? $_GET['i'] : '';
                        // DB models
                        $khach_model = new khach();
                        
                        // Get guest's detail
                        $guest = $khach_model->detail_by_id($guest_id);
                        ?>
                        <?php if ($guest != NULL && $guest->development == GUEST_DEVELOPMENT_ONGOING): ?>
                            <form id="edit" action="../ajaxserver/guest_development.php" method="post" target="hidden_upload">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td width="20%">
                                                <label>Họ tên (*)</label>
                                            </td>
                                            <td>
                                                <input type="hidden" name="guest_id" value="<?php echo $guest->makhach; ?>" />
                                                <input type="text" name="hoten" id="hoten" class="text-input medium-input" maxlength="100"
                                                       value="<?php echo $guest->hoten; ?>" />
                                                <span class="error_icon input-notification error png_bg" title="Dữ liệu không hợp lệ"></span>
                                            </td>
                                        </tr>
<!--                                         <tr> -->
<!--                                             <td> -->
<!--                                                 <label>Nhóm khách (*)</label> -->
<!--                                             </td> -->
<!--                                             <td> -->
<!--                                                 <input type="text" class="text-input small-input" name="search_guest_type" id="search_guest_type" value="" /> -->
<!--                                                 <span class="error_icon input-notification error png_bg" title="Dữ liệu không hợp lệ"></span> -->
<!--                                                 <input type="hidden" name="nhomkhach" id="nhomkhach" value="" /> -->
<!--                                             </td> -->
<!--                                         </tr> -->
                                        <tr>
                                            <td>
                                                <label>Công ty/Địa chỉ (*)</label>
                                            </td>
                                            <td>
                                                <input type="text" class="text-input medium-input" name="diachi" id="diachi" value="<?php echo $guest->diachi; ?>" />
                                                <span class="error_icon input-notification error png_bg" title="Dữ liệu không hợp lệ"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label>Quận</label>
                                            </td>
                                            <td>
                                                <input type="text" class="text-input medium-input" name="quan" id="quan" value="<?php echo $guest->quan; ?>" />
                                                <span class="error_icon input-notification error png_bg" title="Dữ liệu không hợp lệ"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label>Thành phố</label>
                                            </td>
                                            <td>
                                                <input type="text" class="text-input medium-input" name="tp" id="tp" value="<?php echo $guest->tp; ?>" />
                                                <span class="error_icon input-notification error png_bg" title="Dữ liệu không hợp lệ"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label>Điện thoại 1</label>
                                            </td>
                                            <td>
                                                <input type="text" class="text-input small-input" name="dienthoai" id="dienthoai" value="<?php echo $guest->dienthoai1; ?>" />
                                                <span class="error_icon input-notification error png_bg" title="Dữ liệu không hợp lệ"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label>Điện thoại 2</label>
                                            </td>
                                            <td>
                                                <input type="text" class="text-input small-input" name="didong" id="didong" value="<?php echo $guest->dienthoai2; ?>" />
                                                <span class="error_icon input-notification error png_bg" title="Dữ liệu không hợp lệ"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label>Điện thoại 3</label>
                                            </td>
                                            <td>
                                                <input type="text" class="text-input small-input" name="dienthoai3" id="dienthoai3" value="<?php echo $guest->dienthoai3; ?>" />
                                                <span class="error_icon input-notification error png_bg" title="Dữ liệu không hợp lệ"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label>Email</label>
                                            </td>
                                            <td>
                                                <input type="text" class="text-input small-input" name="email" id="email" value="<?php echo $guest->email; ?>" />
                                                <span class="error_icon input-notification error png_bg" title="Dữ liệu không hợp lệ"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label>Email phụ</label>
                                            </td>
                                            <td>
                                                <input type="text" class="text-input small-input" name="emailphu" id="emailphu" value="<?php echo $guest->emailphu; ?>" />
                                                <span class="error_icon input-notification error png_bg" title="Dữ liệu không hợp lệ"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td><label>Danh sách các ngày cần ghi nhớ (nếu có):</label></td>
                                            <td>
                                                <?php 
                                                $events_model = new guest_events();
                                                $arr = $events_model->list_by_guest($guest_id);
                                                ?>
                                                <?php if ($arr == NULL): ?>
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th width="25%"><label>Ngày</label></th>
                                                                <th><label>Ghi chú</label></th>
                                                                <th width="20%">Cần hành động</th>
                                                                <th width="10%"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="events_days">
                                                            <tr>
                                                                <td>
                                                                    <input name="day[]" class="text-input small-input date-picker" style="width: 150px !important" readonly type="text" value="">
                                                                </td>
                                                                <td>
                                                                    <input name="note[]" class="text-input medium-input" style="width: 95% !important" type="text" value="">
                                                                </td>
                                                                <td style="text-align: center;">
                                                                    <input id="check_event_0" type="checkbox" onclick="check_event('check_event_0');" /><input name="is_event[]" type="hidden" value="0" />
                                                                </td>
                                                                <td>
                                                                     <a href="javascript:addRow()" title="Thêm dòng mới"><img src="../resources/images/icons/add.png" alt="Add"></a>
                                                                     <a id="clear_0" href="javascript:clearRow('clear_0')" title="Clear dòng này"><img src="../resources/images/icons/clear.png" alt="Clear"></a>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                    <script type="text/javascript" charset="utf-8">
                                                        var countId = 0;
                                                    </script>
                                                <?php else: ?>
                                                    <table>
                                                        <thead>
                                                            <tr>
                                                                <th width="25%"><label>Ngày</label></th>
                                                                <th><label>Ghi chú</label></th>
                                                                <th width="20%">Cần hành động</th>
                                                                <th width="10%"></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="events_days">
                                                            <?php 
                                                            $i = 0;
                                                            
                                                            foreach ($arr as $t):
                                                            ?>
                                                                <tr>
                                                                    <td>
                                                                        <input name="day[]" class="text-input small-input date-picker" style="width: 150px !important" readonly type="text" value="<?php echo $t->event_date; ?>">
                                                                    </td>
                                                                    <td>
                                                                        <input name="note[]" class="text-input medium-input" style="width: 95% !important" type="text" value="<?php echo $t->note; ?>">
                                                                    </td>
                                                                    <td style="text-align: center;">
                                                                        <input id="check_event_<?php echo $i; ?>" type="checkbox" onclick="check_event('check_event_<?php echo $i; ?>');" <?php echo ($t->enable == BIT_TRUE) ? "checked='checked'" : ""; ?> /><input name="is_event[]" type="hidden" value="<?php echo ($t->enable == BIT_TRUE) ? 1 : 0; ?>" />
                                                                    </td>
                                                                    <?php if ($i == 0): ?>
                                                                        <td>
                                                                             <a href="javascript:addRow()" title="Thêm dòng mới"><img src="../resources/images/icons/add.png" alt="Add"></a>
                                                                             <a id="clear_0" href="javascript:clearRow('clear_0')" title="Clear dòng này"><img src="../resources/images/icons/clear.png" alt="Clear"></a>
                                                                        </td>
                                                                    <?php else: ?>
                                                                        <td>
                                                                             <a href="javascript:addRow()" title="Thêm dòng mới"><img src="../resources/images/icons/add.png" alt="Add"></a>
                                                                             <a id="remove_<?php echo $i; ?>" href="javascript:removeRow('remove_<?php echo $i; ?>')" title="Xóa dòng này"><img src="../resources/images/icons/cross.png" alt="Delete"></a>
                                                                        </td>
                                                                    <?php endif; ?>
                                                                </tr>
                                                            <?php 
                                                                $i++;
                                                            endforeach; 
                                                            ?>
                                                        </tbody>
                                                    </table>
                                                    <script type="text/javascript" charset="utf-8">
                                                        var countId = <?php echo (count($arr) - 1); ?>;
                                                    </script>
                                                <?php endif; ?>
                                                <div class="clear"></div>
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
                                <?php 
                                $responsibility_model = new guest_responsibility();
                                
                                if ($guest->development == GUEST_DEVELOPMENT_ONGOING && $responsibility_model->check_responsibility(current_account(), $guest_id)):
                                ?>
                                    <fieldset>
                                        <p>
                                            <input type="submit" class="button" value="Cập nhật khách hàng" name="edit" />
    <!--                                         <input type="reset" class="button" value="Làm lại" id="reset" name="reset"> -->
                                            <span id="attention" style="color: red;">Có một số trường dữ liệu chưa đúng. Vui lòng kiểm tra lại!</span>
                                        </p>
                                    </fieldset>
                                <?php endif; ?>
                                <div id="notification_msg">
                                </div>
                                <iframe id="hidden_upload" name="hidden_upload" src="" onload="uploadDone('hidden_upload');" 
                                        style="width:0;height:0;border:0px solid #fff">
                                </iframe>
                                <div class="clear"></div>
                            </form>
                            <?php endif; ?>
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
