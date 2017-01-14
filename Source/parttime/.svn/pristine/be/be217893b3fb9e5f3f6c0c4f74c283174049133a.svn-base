<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_GUEST_DEVELOPMENT, '', TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Liên hệ khách hàng cần phát triển</title>
        <?php require_once '../part/cssjs.php'; ?>
        <style type="text/css" title="currentStyle">
            @import "../resources/css/practical.css3.tables.css";
            img { vertical-align: middle; }
        </style>
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #main-content tbody tr.alt-row { background: none; }
            .bordered tbody tr.alt-row { background: #f3f3f3 !important; }
            /* Scroll bar */
            div#detail_dialog_content { max-height: 450px; }
            div#detail_dialog_content { overflow: auto; scrollbar-base-color:#ffeaff; }
            .highlight-red{
                background-color: red;
                color: red;
            }
            .highlight-yellow{
                background-color: yellow;
                color: yellow;
            }
            .highlight-green{
                background-color: green;
                color: green;
            }
            .none{
                display: none;
            }
            #f_coupon, #f_sms{
                background-color: #fafafa;
                padding: 20px;
                width: 50%;
                height: 250px;
            }
            #f_coupon th, #f_sms th {
                padding: 20px 5px;
            }
            #f_coupon > input, #f_sms > input {
                margin: 10px;
                width: 50px;
                text-align: center;
            }

        </style>
        <script type="text/javascript" src="../resources/scripts/utility/guest_development/contact.js"></script>
        <!-- jQuery.bPopup -->
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />

        <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/fnReloadAjax.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/guest/statistic.js"></script>


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
                    <!--<li>
                        <a class="shortcut-button add" href="../guest_development/add-new.php">
                            <span class="png_bg">Thêm khách hàng cần phát triển</span>
                        </a>
                    </li>
                    <li>
                        <a class="shortcut-button list" href="../guest_development/add-from-db.php">
                            <span class="png_bg">Thêm khách hàng cần phát triển từ hệ thống</span>
                        </a>
                    </li>-->
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Liên hệ khách hàng cần phát triển</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab" style="display: block;">
                        <?php 
                        require_once '../models/khach.php';
                        require_once '../models/guest_events.php';
                        require_once '../models/guest_responsibility.php';
                        require_once '../models/guest_development_history.php';
                        require_once '../models/marketing.php';
                        
                        // Get input data
                        $guest_id = (isset($_GET['i'])) ? $_GET['i'] : '';
                        // DB models
                        $khach_model = new khach();
                        $responsibility_model = new guest_responsibility();
                        
                        // Get guest's detail
                        $guest = $khach_model->detail_by_id($guest_id);
                        $doanhso = $khach_model->get_doanhthu($guest_id);
                        ?>
                        <?php if ($guest != NULL): ?>
                            <form id="contact" action="../ajaxserver/guest_development.php" method="post" target="hidden_upload">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td width="20%">
                                                <label>Họ tên</label>
                                            </td>
                                            <td>
                                                <input type="hidden" id="guest_id" name="guest_id" value="<?php echo $guest->makhach; ?>" />
                                                <span class="blue"><?php echo $guest->hoten; ?></span>
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
                                                <label>Công ty/Địa chỉ</label>
                                            </td>
                                            <td>
                                                <span class=""><i><?php echo $guest->diachi; ?></i></span>
                                            </td>
                                        </tr>
                                        <?php if ($guest->dienthoai1)  { ?>
                                        <tr>
                                            <td>
                                                <label>Điện thoại 1</label>
                                            </td>
                                            <td>
                                                 <button type="button" onclick='f1(this);' value="<?php echo $guest->dienthoai1; ?>"> <?php echo $guest->dienthoai1; ?> </button>
                                            </td>
                                        </tr>
                                        <?php } 
                                        if ($guest->dienthoai2)  { ?>
                                        <tr>
                                            <td>
                                                <label>Điện thoại 2</label>
                                            </td>
                                            <td>
                                                 <button type="button" onclick='f1(this);' value="<?php echo $guest->dienthoai2; ?>"> <?php echo $guest->dienthoai2; ?> </button>
                                            </td>
                                        </tr>
                                        <?php }
                                        if ($guest->dienthoai3)  { ?>
                                        <tr>
                                            <td>
                                                <label>Điện thoại 3</label>
                                            </td>
                                            <td>
                                                 <button type="button" onclick='f1(this);' value="<?php echo $guest->dienthoai3; ?>"> <?php echo $guest->dienthoai3; ?> </button>
                                            </td>
                                        </tr>
                                        <?php } ?>
                                        <tr>
                                            <td>
                                                <label>Email</label>
                                            </td>
                                            <td>
                                                <span class=""><i><?php echo $guest->email; ?></i></span>
                                            </td>
                                        </tr>
                                        <tr>
                                        <tr>
                                            <td>
                                                <label>Doanh số</label>
                                            </td>
                                            <td>
                                                <span class="bold">
                                                <a class='orange' title='Danh sách hóa đơn' id='orders_{0}' href='javascript:showOrdersByGuest("<?php echo $guest_id; ?>")'><?php echo number_2_string($doanhso); ?></a>
                                                </i></span>
                <div id="detail_dialog" class="bMulti2" style="display: none">
                    <span class="button_popup b-close"><span>X</span></span>
                    <div id="detail_dialog_content">
                        <table class="bordered" id="detail_items">
                            <thead>
                                <tr id="detail_items_head">
                                </tr>
                            </thead>
                            <tbody id="detail_items_body">
                            </tbody>
                        </table>
                    </div>
                 </div>
                 <div id="popup" style="display: none">
                    <div id="popup_msg"></div>
                </div>

                                            </td>
                                        </tr>
                                        <tr>

                                            <td><label>Danh sách các ngày cần ghi nhớ</label></td>
                                            <td>
                                                <?php 
                                                $events_model = new guest_events();
                                                $arr = $events_model->list_by_guest($guest_id);
                                                ?>
                                                <table class="bordered">
                                                    <thead>
                                                        <tr>
                                                            <th>STT</th>
                                                            <th>Ngày</th>
                                                            <th>Ghi chú</th>
                                                            <th>Cần hành động</th>
                                                    </thead>
                                                    <tbody>
                                                        <?php 
                                                        if ($arr != NULL):
                                                            $i = 0;
                                                            $css = array('0' => 'alt-row', '1' => '');
                                                            
                                                            foreach ($arr as $t):
                                                        ?>
                                                            <tr class="<?php echo $css[(++$i) % 2]  ?>">
                                                                <td><?php echo $i; ?></td>
                                                                <td>
                                                                    <span class="orange"><?php echo dbtime_2_systime($t->event_date, 'd/m/Y'); ?></span>
                                                                </td>
                                                                <td>
                                                                    <?php echo $t->note; ?>
                                                                </td>
                                                                <td>
                                                                    <?php if ($t->enable == BIT_TRUE): ?>
                                                                        <img title="Yes" alt="yes" src="../resources/images/icons/tick.png">
                                                                    <?php else: ?>
                                                                        <!-- <img title="No" alt="no" src="../resources/images/icons/publish_x.png"> -->
                                                                    <?php endif; ?>
                                                                </td>
                                                            </tr>
                                                        <?php
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <div class="clear"></div>
                                            </td>
                                        </tr>
                                        <?php 
                                            $next_schedule = $note = $event_id = "";
                                            $is_developping = FALSE;
                                            $has_came = TRUE;

                                                $is_developping = TRUE;

                                                $history_model = new guest_development_history();
                                                $events_model = new guest_events();

                                                $tmp = $events_model->next_schedule($guest_id);                                            
                                                if ($tmp != NULL)
                                                {
                                                    $date = $tmp->event_date;
                                                    //$date = dbtime_2_systime($tmp->event_date, 'Y-m-d');
                                                //    if (!$history_model->check_updating(current_account(), $guest_id, $date))
                                                 //   {
                                                        $next_schedule = $date;
                                                        $note = $tmp->note;
                                                        $event_id = $tmp->uid;

                                                        // Check if current day is contact day
                                                        $current = current_timestamp('Y-m-d');
                                                        //$has_came = (custom_day_diff($date, $current) == 0);
                                                 //   }
                                                }
                                        ?>
                                        <tr>
                                            <td>
                                                <label>Nội dung liên hệ/Ghi chú</label>
                                            </td>
                                            <td>
                                                <div id="history">
                                                </div>
                                                
                                                <?php if ($is_developping): ?>
                                                    <textarea id="contact_content" name="contact_content" row="10" style="margin-top: 2px; margin-bottom: 2px; height: 74px;" <?php echo (!$has_came) ? 'readonly' : ''; ?>></textarea>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                        <?php if ($is_developping): ?>
                                            <tr>
                                                <td>
                                                    <label>Lịch hẹn liên hệ gần nhất trong hệ thống</label>
                                                </td>
                                                <td>
                                                    <span class="price" id="old_schedule"><?php echo dbtime_2_systime($next_schedule, 'd/m/Y'); ?></span>
                                                    <input type="hidden" id="last_schedule_date" name="last_schedule_date" value="<?php echo $next_schedule; ?>" />
                                                    <input type="hidden" id="last_schedule_id" name="last_schedule_id" value="<?php echo $event_id; ?>" />
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    | &nbsp;&nbsp;&nbsp;&nbsp;Đổi ngày hẹn: <input type="text" class="text-input small-input date-picker" name="change_schedule" id="change_schedule" readonly="readonly" value="<?php //echo $next_schedule; ?>" />
                                                    <a id="save_new_schedule" href="javascript:saveNewSchedule();" title="Lưu ngày hẹn mới">
                                                        <img height="20px" width="20px" src="../resources/images/icon_save.jpg" alt="save">
                                                    </a>
                                                    <img id="save_loading" style="display: none" src="../resources/images/loading2.gif" alt="loading">
                                                </td>
                                            </tr>

                                            <?php
                                                if ($has_came):
                                                    $next_schedule = $note = $event_id = "";
                                            ?>
                                                <tr id="schedule_control">
                                                    <td>
                                                        <label>
                                                            Ngày liên hệ tiếp theo
                                                        </label>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <input name="event_id" type="hidden" value="<?php echo $event_id; ?>" />
                                                            <img title="Ngày liên hệ" src="../resources/images/icons/calendar_16.png" alt="calendar">
                                                            <input type="text" class="text-input small-input date-picker" name="next_schedule" id="next_schedule" readonly="readonly" value="<?php echo $next_schedule; ?>" />
                                                            &nbsp;&nbsp;&nbsp;&nbsp;
                                                            <img title="Ghi chú" src="../resources/images/icons/note-edit.png" alt="note">
                                                            <input name="note" id="note" class="text-input medium-input" type="text" value="<?php echo $note; ?>" />
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label>Không theo dõi nữa</label>
                                                    </td>
                                                    <td>
                                                        <input type="checkbox" name="cancelled" id="cancelled" alt="" />
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                        <label id="listRegisterLabel">Đăng ký Email marketing </label>
                                                    </td>
                                                    <td>
                                                        <select name="listid" id="listid" data-placeholder=" " class="chosen-select" style="width:350px;" tabindex="4">
                                                            <option value="-1">-- Chon mail group--</option>
                                                        </select> <button type="button" id="listRegister" onclick="registerGuestEmail(<?php echo chr(39).$guest->email.chr(39).chr(44).chr(39).$guest->hoten.chr(39); ?>);" value="Dang ky" hidden> Dang ky </button> 
                                                    </td>
                                                </tr>
                                            
                                            <?php endif; ?>
                                        <?php endif; ?>
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
                                <div id="notification_msg"></div>
                                <?php if ($is_developping && $has_came): ?>
                                    <fieldset>
                                        <p>
                                            <input type="submit" class="button" onclick="validateRegister();" value="Cập nhật liên hệ" name="contact" />
                                            <span id="attention" style="color: red; display: none;">Có một số trường dữ liệu chưa đúng. Vui lòng kiểm tra lại!</span>
                                           
                                    <input type="hidden" id="list_all_action" name="list_all_action" value="" />
                                     <input type="hidden" id="guest_0" name="guest[]" value="<?php echo $guest_id ?>" />
                                    <!-- Them khach hang vao danh sach quan tam -->
                                    <?php if (verify_access_right(current_account(), F_GUEST_DEVELOPMENT_LIST_FAVOURITE)): ?>
                                        <a class="blue-text" title="Đưa vào danh sách quan tâm" href="javascript:addFavourites();">
                                            <img alt="bookmark" src="../resources/images/icons/bookmark-32.png" />
                                            Đưa vào danh sách quan tâm
                                        </a>
                                        &nbsp;&nbsp;<span style="margin-left: 50px;"></span>
                                    <?php endif; ?>
                                    <!-- Them vao pool reassign -->
                                    <?php if (verify_access_right(current_account(), F_GUEST_DEVELOPMENT_ADD_NEW)): ?>
                                        <a class="blue-text" title="Trả khách về pool không theo dõi nữa" href="javascript:unFollow();">
                                            <img alt="bookmark" src="../resources/images/icons/bookmark-32.png" />
                                            Trả khách về pool không theo dõi nữa 
                                        </a>
                                        &nbsp;&nbsp;<span style="margin-left: 50px;"></span>
                                    <?php endif; ?>
                                    </fieldset>
                                <?php endif; ?>
                              
                                <input class="button" onclick="window.location.href='delguest_new.php?item=<?php echo $guest_id; ?>'" value="Xóa khỏi pool"/>
                                </p>
                                
                                <?php 
                                    require_once "../models/coupon_group.php";
                                    $model_maketing = new marketing();
                                    require_once "../models/sms_model.php";

                                    $guest_maketing = $model_maketing->get_guest_by_id($guest_id);
                                    $guest_sent = $model_maketing->get_guest_send_sms($guest_id);

                                    $sms_model = new sms_model();
                                    $guest_smstemplate = $sms_model->get_template(LOSERS_NEW_GUEST);
                                    $list_template = $sms_model->results_list();

                                    $coupon_group = new coupon_group();
                                    $list_coupon_group = $coupon_group->get_list();
                                ?>
                                <?php if (count($guest_maketing) >= 1): ?>
                                <input type="button" class="button" value="Gửi coupon" id="coupon" />
                                <?php endif; ?>
                                <input type="button" class="button" value="Gửi SMS" id="sms" />

                                <iframe id="hidden_upload" name="hidden_upload" src="" onload="uploadDone('hidden_upload');"
                                        style="width:0;height:0;border:0px solid #fff">
                                </iframe>
                                <div class="clear"></div>
                            </form>
                            <?php else: ?>
                                <div class="notification attention png_bg">
                                    <div>
                                        Thông tin khách hàng '<?php echo $guest_id; ?>' không tồn tại hoặc khách hàng này không thuộc quyền quản lý của bạn. Vui lòng liên hệ admin để được hỗ trợ!
                                    </div>
                                </div>
                            <?php endif; ?>

                            <form id="f_coupon" class="none">
                                <table>
                                    <tr>
                                        <th>Số điện thoại</th>
                                        <td>
                                            <select name="telephone_coupon" id="telephone_coupon">
                                            <?php 
                                                 echo "<option value=''>----</option>";
                                               if (isset($guest->dienthoai1)) {
                                                    echo "<option value='{$guest->dienthoai1}'>{$guest->dienthoai1}</option>";
                                               }
                                               if (isset($guest->dienthoai2)) {
                                                    echo "<option value='{$guest->dienthoai2}'>{$guest->dienthoai2}</option>";
                                               }
                                               if (isset($guest->dienthoai3)) {
                                                    echo "<option value='{$guest->dienthoai3}'>{$guest->dienthoai3}</option>";
                                               }
                                             ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Loại coupon: </th>
                                        <td>
                                            <select name="group_couppon" id="group_couppon">
                                            <?php 
                                                echo "<option value=''>----</option>";
                                                for ($i=0; $i < count($list_coupon_group); $i++) { 
                                                    $obj = $list_coupon_group[$i];
                                                    echo "<option value='{$obj['group_id']}'>{$obj['content']}</option>";
                                                }
                                             ?>
                                            </select>
                                        </td>
                                    </tr>

                                    <tr>
                                        <th>Mã coupon</th>
                                        <td>
                                            <select name="id_coupon" id="id_coupon" style="width: 100px;">
                                            <option value=''>----</option>
                                            </select>
                                        </td>
                                    </tr>
                                    
                                    <tr>
                                        <th>Mẫu tin nhắn</th>
                                        <td>
                                            <textarea id="smstemplate" cols="10" rows="5" maxlength="160">
                                                
                                            </textarea>
                                        </td>
                                    </tr>
                                </table>
                                <input type="buton" class="button" id="sendcoupon" value="Gửi" />
                                <input type="buton" class="button" id="closecouponform" value="Đóng" />
                            </form>
                            <form id="f_sms" class="none">
                                <table>
                                    <tr>
                                        <th>Số điện thoại</th>
                                        <td>
                                            <select name="telephone_coupon" id="telephone_coupon">
                                            <?php
                                                 echo "<option value=''>----</option>";
                                               if (isset($guest->dienthoai1)) {
                                                    echo "<option value='{$guest->dienthoai1}'>{$guest->dienthoai1}</option>";
                                               }
                                               if (isset($guest->dienthoai2)) {
                                                    echo "<option value='{$guest->dienthoai2}'>{$guest->dienthoai2}</option>";
                                               }
                                               if (isset($guest->dienthoai3)) {
                                                    echo "<option value='{$guest->dienthoai3}'>{$guest->dienthoai3}</option>";
                                               }
                                             ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Loại SMS: </th>
                                        <td>
                                            <select name="group_sms" id="group_sms">
                                            <?php
                                                echo "<option value=''>----</option>";
                                                foreach ($list_template as $template) {
                                                    echo "<option value='".$template['id']."'>".$template['smstype']."</option>";
                                                }
                                             ?>
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Mẫu tin nhắn</th>
                                        <td>
                                            <textarea id="smstemplate2" cols="10" rows="5" maxlength="160">

                                            </textarea>
                                        </td>
                                    </tr>
                                </table>
                                <input type="buton" class="button" id="sendsms" value="Gửi" />
                                <input type="buton" class="button" id="closesmsform" value="Đóng" />
                            </form>
                        </div>
                    </div>
                </div>
                <?php include_once '../part/footer.php'; ?>
                <script type="text/javascript">
                    guest_maketing = <?php echo json_encode($guest_maketing); ?>;
                    guest_id = <?php echo json_encode($guest_id); ?>;
                    guest_smstemplate = <?php echo json_encode($guest_smstemplate); ?>;
                    guest = <?php echo json_encode($guest); ?>;
                    list_template_json = <?php echo json_encode($list_template); ?>;

                </script>
                <script type="text/javascript" src="../resources/scripts/utility/guest/coupon.js"></script>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
