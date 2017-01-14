<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ORDERS, F_ORDERS_UNCHECKED_LIST, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Đánh giá đơn hàng</title>
        <?php require_once '../part/cssjs.php'; ?>
        <style type="text/css" title="currentStyle">
            @import "../resources/css/practical.css3.tables.css";
            img { vertical-align: middle; }
        </style>
        
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder !important; }
            img { vertical-align: middle; }
            #swapping_table tbody tr.alt-row { background: none; }
            #dt_example span { font-weight: normal !important; }
            form select { -moz-border-radius: 0px; -webkit-border-radius: 0px; border-radius: 0px; }
            #example_processing { padding-top: 30px; padding-bottom: 30px; }
        </style>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <!-- jQuery.bPopup -->
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
        <script type="text/javascript" src="../resources/scripts/utility/guest/statistic.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function(){
                $('.error_icon').hide();
                $("#submit_check").click(function() {
                // Ngay lien he tiep theo
                    if (($('#next_schedule').val().trim() == "") || ($('#note_next_schedule').val().trim() == "")) {
                        $('#next_schedule').parent().find('.error_icon').show();
                        return false;
                    } else {
                        $('#next_schedule').parent().find('.error_icon').hide();
                        return confirm("Bạn có chắc không?");
                    }

                });
                $("#sms_checking").click(function() {
                // Ngay lien he tiep theo
                    if (($('#next_schedule').val().trim() == "") || ($('#note_next_schedule').val().trim() == "")) {
                        $('#next_schedule').parent().find('.error_icon').show();
                        return false;
                    } else {
                        $('#next_schedule').parent().find('.error_icon').hide();
                        return confirm("Bạn có chắc không?");
                    }

                });

                disableAutocomplete();

                $('#attention').hide();
   
                $(".date-picker").datepicker({
                    minDate: +0,
                    changeMonth : true,
                    changeYear : true
                });


            });
        </script>

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
                    <?php if (verify_access_right(current_account(), F_ORDERS_UNCHECKED_LIST)): ?>
                        <li>
                            <a class="shortcut-button add-event" href="unchecked_list.php">
                                <span class="png_bg">Đơn hàng chờ kiểm tra</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_ORDERS_CHECKED_LIST)): ?>
                        <li>
                            <a class="shortcut-button new-page" href="checked_list.php">
                                <span class="png_bg">Đơn hàng đã kiểm tra</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Đánh giá đơn hàng <span class="blue"><?php if (isset($_GET['item'])) echo $_GET['item']; ?></span></h3>
                    </div>
                    <div class="content-box-content">
                            <?php
                            require_once '../models/donhang.php';
                            require_once '../models/orders_question.php';
                            require_once '../models/orders_question_option.php';
                            require_once '../models/orders_question_result.php';
                            require_once '../models/khach.php';


                            // DB model
                            $model = new donhang();
                            
                            // Get data and display
                            $order_id = (isset($_GET['item'])) ? $_GET['item'] : '';
                            $item = $model->chi_tiet_don_hang($order_id);
                            //debug($item);
                            
                            // Check access right
                            $access = false;
                            if (is_array($item)) {
                                $access = ($item['trangthai'] == donhang::$DA_GIAO) 
                                          //&& ($item['checked'] == 0) // -1: Invalid, 0: Unchecked, 1: Checked, 2: Skipped
                                          && ($item['approved'] == donhang::$APPROVED);
                                $guest_id = $item['makhach'];
                            }
                            $khach_model = new khach ();
                            $guest = $khach_model->detail_by_id ( $guest_id );
                            $doanhso = $khach_model->get_doanhthu($guest_id);
                            $khachsi = array(42, 45, 56);
                            if (in_array($guest->manhom, $khachsi)) {
                                $khachsi = TRUE;
                            } else {
                                $khachsi = FALSE;
                            }
                            ?>
                            <?php if ($access): 
                                if (isset($_POST['submit']) || isset($_POST['sms_checking'])) 
                                {
                                    $questions = $_POST['question'];
                                    $options = $_POST['option'];
                                    $notes = $_POST['note'];
                                    require_once '../models/guest_events.php';
                                    require_once '../entities/guest_events_entity.php';
                                    require_once '../models/guest_responsibility.php';
                                    require_once '../models/guest_development_history.php';
                                    if (! ($khachsi)) {
                                    $next_schedule = $_POST ['next_schedule'];
                                    $note_next_schedule = $_POST ['note_next_schedule'];
                                    $khach_model = new khach ();
                                    $history_model = new guest_development_history();
                                    $responsibility_model = new guest_responsibility ();
                                    $events_model = new guest_events ();
                                    $event = new guest_events_entity ();
                                    $guest = $khach_model->detail_by_id ( $guest_id );
                                    $guest->development = GUEST_DEVELOPMENT_ONGOING;
                                    if ($khach_model->update ( $guest )) {
                                        $date = current_timestamp('Y-m-d');
                                        $khach_model->set_development_date($guest->makhach, $date);
                                        $continue = TRUE;
                                        $res = new guest_responsibility_entity ();
                                        $res->employee_id = current_account ();
                                        $res->guest_id = $guest_id;
                                        if ($responsibility_model->check_res_exists($guest_id)){
                                            error_log ('Responsibility exists', 3, '/var/log/phpdebug.log');
                                            $responsibility_model->re_assign($guest_id, current_account ());
                                        } else {
                                        if ($responsibility_model->insert ( $res )) {
                                            $continue = TRUE;
                                            $h = new guest_development_history_entity ();
                                            $h->guest_id = $guest_id;
                                            $h->employee_id = current_account ();
                                            $h->note = $note_next_schedule;
                                            $h->is_history = BIT_FALSE;
                                            if ($continue = $history_model->insert ( $h )) {
                                                $event = new guest_events_entity ();
                                                $event->guest_id = $guest_id;
                                                $event->event_date = $next_schedule;
                                                $event->note = "Hẹn lịch liên he hau mai"; // Default note
                                                $event->is_event = BIT_FALSE;
                                                $event->enable = BIT_TRUE;
                                                $continue = $events_model->insert ( $event ); // DB insert
                                                if (! ($continue)) {
                                                    error_log ('Can not insert event model', 3, '/var/log/phpdebug.log');
                                                }
                                            } else {
                                                error_log ('Can not insert history model', 3, '/var/log/phpdebug.log');
                                            }    
                                                                                       
                                        } else {
                                            error_log ('Can not insert responsibility model', 3, '/var/log/phpdebug.log');
                                        }
                                        }
                                    } 
                                    } 
                                    //debug($questions);
                                    //debug($options);
                                    //debug($notes);
                                    
                                    $success = false;
                                    $message = "";
                                    $result_model = new orders_question_result();
                                    $valid = true;

                                    foreach ($options as $o)
                                    {
                                        if ($o == "") {
                                            $valid = false;
                                            break;
                                        }                                        
                                    }

                                    if (!$valid)
                                    {
                                        $message = "Vui lòng chọn giá trị đánh giá hợp lệ";
                                    }
                                    else
                                    {
                                        if ($model->set_checked($order_id))
                                        {
                                            $success = true;
                                            for ($i = 0; $i < count($questions); $i++)
                                            {
                                                $entity = new orders_question_result_entity();
                                                $entity->order_id = $order_id;
                                                $entity->question_id = $questions[$i];
                                                $entity->option = $options[$i];
                                                $entity->note = $notes[$i];
                                                $entity->date = current_timestamp('Y-m-d');

                                                if (!$result_model->insert($entity))
                                                {
                                                    $message = $result_model->getMessage();
                                                    $success = false;
                                                    break;
                                                }
                                            }
                                        }
                                        else 
                                        {
                                            $message = $model->getMessage();
                                        }
                                    }
                                }
                                // Skip checking
                                if (isset($_POST['skip_checking']))
                                {
                                    $success = false;
                                    $message = "";
                                    
                                    if ($model->set_checked($order_id, 2))
                                    {
                                        $success = true;
                                        $item = $model->chi_tiet_don_hang($order_id);
                                    }
                                    else
                                    {
                                        $message = $model->getMessage();
                                    }
                                }
                            ?>           

                                <table id="swapping_table">
                                    <tbody>
                                        <tr>
                                            <td width="20%">
                                                <span class="bold">Ngày giao</span>
                                            </td>
                                            <td>
                                                <input type="hidden" id="order_id" name="order_id" value="<?php echo $order_id; ?>" />
                                                <span class=""><?php echo dbtime_2_systime($item['ngaygiao'], 'd/m/Y'); ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Khách hàng</span>
                                            </td>
                                            <td>
                                                <span class="price"><?php echo $item['khachhang'] ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Nhóm khách</span>
                                            </td>
                                            <td>
                                                <span class="price"><?php echo $item['nhomkhach'] ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Địa chỉ</span>
                                            </td>
                                            <td>
                                                <span class=""><?php echo $item['diachi'] . ", " . $item['quan'] . ", " . $item['tp'] ?></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Điện thoại</span>
                                            </td>
                                            <td>
                                                <span class="blue">
                                                <?php
                                                    if ($guest->dienthoai1){
                                                        echo '<input type="submit" value="'. $guest->dienthoai1. '" onclick="f1(this)"/>';}
                                                    if ($guest->dienthoai2){
                                                        echo '<input type="submit" value="'. $guest->dienthoai2. '" onclick="f1(this)"/>';}
                                                    if ($guest->dienthoai3){
                                                        echo '<input type="submit" value="'. $guest->dienthoai3. '" onclick="f1(this)"/>';}              
                                                ?>
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Thành tiền</span>
                                            </td>
                                            <td>
                                                <span class="bold"><?php echo number_2_string($item['thanhtien']); ?>                            
                                                </span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="bold">Doanh số</span>
                                            </td>
                                            <td>
                                                <span class="bold">
                                                <a class='orange' title='Danh sách hóa đơn' id='orders_{0}' href='javascript:showOrdersByGuest("<?php echo $guest_id; ?>")'><?php echo number_2_string($doanhso); ?></a> <button type="button" onclick='window.location = "../coupon/coupon-assign.php?bill_code=<?php echo $order_id; ?>";'> Assign Coupon </button> 
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
                                            <td>
                                                <span class="bold">Trạng thái kiểm tra</span>
                                            </td>
                                            <td>
                                                <?php 
                                                $css = "";
                                                $text = "";
                                                
                                                switch ($item['checked']) {
                                                    case '0':
                                                        $css = "tag turquoise";
                                                        $text = "CHỜ KIỂM TRA";
                                                        break;
                                                    case '1':
                                                        $css = "tag belize";
                                                        $text = "ĐÃ KIỂM TRA";
                                                        break;
                                                    case '2':
                                                        $css = "tag pomegranate";
                                                        $text = "BỎ QUA KIỂM TRA";
                                                        break;                                    
                                                    default:
                                                        $css = "tag pomegranate";
                                                        $text = "INVALID";
                                                        break;
                                                } ?>
                                                <div class="box_content_player"><span class="<?php echo $css; ?>"><?php echo $text; ?></span></div>                                
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                    </tfoot>
                                </table>
                                <div class="clear" style="padding: 15px;"></div>
                                <?php if (isset($success)): ?>
                                    <?php if ($success): ?>
                                        <div id="notification_msg">
                                            <div class="notification success png_bg">
                                                <div>Thực hiện thao tác thành công!</div>
                                            </div>
                                        </div>  
                                    <?php else: ?>
                                        <div id="notification_msg">
                                            <div class="notification error png_bg">
                                                <div><?php echo $message; ?></div>
                                            </div>
                                        </div>  
                                    <?php endif; ?>
                                <?php endif; ?>

                                <?php
                                    function createSelectCtrl($name, $options, $selected = "") {
                                        $html = "<select name='{$name}'>%s</select>";
                                        $fmt = "<option %s value='%s'>%s</option>";
                                        $opt = sprintf($fmt, "", "", "--- Chọn ---");
                                        foreach ($options as $v) {
                                            $opt .= sprintf($fmt, ($selected == $v['value']) ? "selected" : "", $v['value'], $v['text']);
                                        }

                                        return sprintf($html, $opt);
                                    } 
                                ?>
                        <form id="checking-detail" action="" method="post">
                                <table class="bordered" id="items">
                                    <thead>
                                        <tr id="items_head">
                                            <th>STT</th>
                                            <th>Tiêu chí/Nội dung</th>
                                            <th>Đánh giá</th>
                                            <th>Ghi chú</th>                                            
                                    </thead>
                                    <tbody>
                                        <?php 
                                        $question_model = new orders_question();
                                        $option_model = new orders_question_option();
                                        $result_model = new orders_question_result();

                                        $questions = $question_model->get_all();
                                        $i = 0;
                                        foreach ($questions as $q):
                                            $o_list = $option_model->option_list($q->question_id);
                                            $r = $result_model->result($order_id, $q->question_id);

                                            $options = array();
                                            foreach ($o_list as $o) {
                                                $options[] = array('value' => $o->uid, 'text' => $o->content);
                                            }
                                            $selected = $r->option;
                                        ?>
                                            <tr>
                                                <td><?php echo ++$i; ?></td>
                                                <td>
                                                    <input name="question[]" type="hidden" value="<?php echo $q->question_id; ?>" />
                                                    <?php echo $q->content; ?>
                                                </td>
                                                <td><?php echo createSelectCtrl("option[]", $options, $selected); ?></td>
                                                <td><textarea name="note[]"><?php echo $r->note; ?></textarea></td>
                                            </tr>
                                        <?php endforeach; ?>
                                   </tbody>
                               </table> 
                               <?php if (! ($khachsi)) { ?>
                               <br>
                               <label>
                                 Ghi chú 
                               </label>
                               <textarea type="text" style="width: 200px; height: 50px;"  name="note_next_schedule" id="note_next_schedule" value="" ></textarea>
                               <br>   
                               <label>
                                  Ngày liên hệ tiếp theo (*)
                               </label>
                               <img title="Ngày liên hệ" src="../resources/images/icons/calendar_16.png" alt="calendar">
                               <input type="text" class="text-input small-input date-picker" name="next_schedule" id="next_schedule" readonly="readonly" value="" />
                               <span class="error_icon input-notification error png_bg" title="">Vui lòng chọn ngày và điền thông tin ghi chú</span>
                               <br> <br>
                               <?php } ?>
                               <label>
                                  Số Điện thoại SMS
                               </label>
                               <?php 
                                   $mobile = array("090", "091", "092", "093", "094", "095", "096", "097", "098", "099", "089", "088", "012", "016");
                                   
if (($guest->dienthoai1) && in_array(substr($guest->dienthoai1, 0, 3), $mobile)) {
                                   echo '<input type="radio" name="dienthoaisms" id="dienthoaisms" value="' . $guest->dienthoai1 . '" checked>' . $guest->dienthoai1; }
                                   if (($guest->dienthoai2) && in_array(substr($guest->dienthoai2, 0, 3), $mobile))  {
                                   echo '<input type="radio" name="dienthoaisms" id="dienthoaisms" value="' . $guest->dienthoai2 . '" checked>' . $guest->dienthoai2;}
                                   if (($guest->dienthoai3) && in_array(substr($guest->dienthoai3, 0, 3), $mobile))  {
                                   echo '<input type="radio" name="dienthoaisms" id="dienthoaisms" value="' . $guest->dienthoai3 . '" checked>' . $guest->dienthoai3 . '<br>';}
                                   require_once '../models/sms_model.php';
                                   require_once '../models/coupon_assign.php';
                                   $smsmodel = new sms_model();
                                   $couponmodel = new coupon_assign();
                                   $coupon = $couponmodel->assign_list_for_bill($order_id, FALSE);
                                   $coupon_code = '';
                                   foreach ($coupon as $cp) {
                                       $coupon_code .= $cp['coupon_code'];
                                   }
                                   if ($coupon_code) {
                                       $smsmessage = $smsmodel->get_template('Hậu mãi đơn hàng có coupon');
                                   } else {
                                       $smsmessage = $smsmodel->get_template('Hậu mãi đơn hàng');
                                   }
                                   $smss = $smsmessage[0];
                                   $smss = str_replace('%Mahoadon%',$order_id,$smss);
                                   $smss = str_replace('%Tenkhachhang%',$guest->hoten,$smss);
                                   $smss = str_replace('%Macoupon%',$coupon_code,$smss);
                                   echo '<p><label>Mẫu SMS: </label>';
                                   echo "<textarea maxlength='160' name='smstemplate' value='".$smss."'>". $smss ."</textarea>";
                                   if ((isset($_POST['sms_checking'])) || (isset($_POST['sms_checking_only']))) {
                                       $smsnumber = $_POST['dienthoaisms'];
                                       $smsMessage = $_POST['smstemplate'];
                                       if ($smsnumber) {
                                           $url = $smsnumber;
                                           $ch = curl_init();
                                           $smsMessage=curl_escape($ch,$smsMessage);
                                           $url .= "&smsMessage=" . $smsMessage . "&smsGUID=1&serviceType=4929";
                                           curl_setopt($ch, CURLOPT_URL, $url);
                                           curl_setopt($ch, CURLOPT_HEADER, 0);
                                           curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                           curl_setopt($ch, CURLOPT_TIMEOUT, '15');
                                           curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
                                           curl_setopt($ch, CURLOPT_VERBOSE, true);
                                           $output = curl_exec($ch);       
                                           if ($output === false) {
                                               echo "  Gui tin nhan that bai: " . curl_error($ch);
                                           } else {
                                               if (strpos($output, "Sending") > 0){ 
                                                   echo "  Tin nhan gui thanh cong den so may " . $smsnumber;
                                               } else {
                                                   echo "  Gui tin nhan that bai " . $output;
                                               }
                                           }
                                           curl_close($ch);
                                       }
                                   }
 
                               if ($model->is_unchecked($order_id)): ?>
                                    <div id="swap_actions" class="clear" style="padding: 20px; display: block;">
                                        <input type="submit" name="submit" id="submit_check" value="Đã kiểm tra" class="button" />
                                        <input type="submit" name="skip_checking" id="skip_checking" value="Bỏ qua đánh giá" class="button" />
                                        <input type="submit" name="sms_checking" id="sms_checking" value="Kiểm tra và gửi SMS" class="button" />

                                        <span id="attention" style="color: red;">Có một số trường dữ liệu chưa đúng. Vui lòng kiểm tra lại!</span>
                                    </div>
                                <?php else: ?>
                                     <p><input type="submit" name="sms_checking_only"  value="Gửi lại SMS" class="button" />
                                <?php endif; ?>
                            <?php endif; ?>
                        </form>
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
