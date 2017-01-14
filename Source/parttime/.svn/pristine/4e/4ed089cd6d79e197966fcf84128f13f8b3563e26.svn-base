<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_WORKING_CALENDAR, F_LEAVE_ADD, TRUE);

require_once "../models/phanquyen.php";
$model_pq = new phanquyen();
$employee_id = current_account();
$list_manager = $model_pq->loadManager($employee_id );
    
require_once "../models/danhsachsongaynghi.php";
$model_leave_number = new leave_number();
$info_leave_number = $model_leave_number->getInfoByEmployeeId($employee_id);
require_once "../models/danhsachnghi.php";
require_once "../models/danhsachlamthem.php";
$mode_leave = new list_leave();
$mode_request = new list_request();
$list_leave = $mode_leave->getLeave($employee_id);
$list_request = $mode_request->getRequest($employee_id);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Lập đơn nghỉ phép</title>
        <?php require_once '../part/cssjs.php'; ?>
       
        <style type="text/css">
            .name { color: blue; font-weight: bolder; }
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #main-content tbody tr.alt-row { background: none; }
            #upload_message span { font-size: 13px; }
            .none {
                display: none;
            }
        </style>
        
        <link rel="stylesheet" href="../resources/chosen/chosen.css">
        <script src="../resources/chosen/chosen.jquery.js" type="text/javascript"></script>
        <script src="../resources/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript">

            $(document).ready(function() {
                listManager = <?php echo json_encode($list_manager); ?>;
                list_leave = <?php echo json_encode($list_leave); ?>;
                list_request = <?php echo json_encode($list_request); ?>;
                //console.log(JSON.stringify(list_leave) + JSON.stringify(list_request));
                info_leave_number = <?php echo json_encode($info_leave_number); ?>;
                $("#leave_day").datepicker({
                    minDate: +0,
                    changeMonth: true,
                    changeYear: true
                });

                // 
                for (var i = 0; i < listManager.length; i++) {
                    var obj = listManager[i];
                    var html = String.format('<option value="{0}">{0}</option>', obj.manv, obj.manv);
                    $('#leave_manager').append(html);   
                }
                 $('#ngayconlai').text(info_leave_number.songaynghi);
                for (var i = 1; i <= info_leave_number.songaynghi; i++) {
                    html = "";
                     html = String.format('<option value="{0}">{1}</option>', i-0.5, i-0.5);
                     html += String.format('<option value="{0}">{0}</option>', i);
                    $('#leave_day_number').append(html); 
                }

                $('#leave_manager, #leave_day_number').chosen({disable_search_threshold: 2});
                $('#addleave').click(function(event) {
                    return checkValue();
                });
                loaddatatable();
            });
            function loaddatatable() {
                // list_leave
                var html = "";
                var fm = "<tr> <td>{0}</td> <td>{1}</td> <td>{2}</td> <td>{3}</td> <td>{4}</td> <td>{5}</td> </tr>";
                for (var i = 0; i < list_leave.length; i++) {
                    var obj = list_leave[i];
                    var trangthai = "đang chờ duyệt";
                    if (obj.trangthai == 1) {
                        trangthai = "đã duyệt";
                    } else
                        if(obj.trangthai == -1) {
                            trangthai = "từ chối";
                        }

                    html += String.format(fm, obj.ngaylap, obj.ngaynghi, obj.songaynghi, obj.maquanli, obj.ghichu, trangthai);
                }
                $('#tleave > tbody').html(html);

                //list_request
                var html = "";
                var fm = "<tr> <td>{0}</td> <td>{1}</td> <td>{2}</td> <td>{3}</td> <td>{4}</td> <td>{5}</td> </tr>";
                for (var i = 0; i < list_request.length; i++) {
                    var obj = list_request[i];
                    var trangthai = "<a class='button' target='blank' href='list-approve-request.php'>Chưa đồng ý</a>";
                    if (obj.trangthai == 1) {
                        trangthai = "Đã đồng ý";
                    } else
                    if(obj.trangthai == -1) {
                        trangthai = "đã từ chối";
                    }
                    html += String.format(fm, obj.ngaylap, obj.ngaylamthem, obj.songay, obj.maquanly, obj.ghichu, trangthai);
                }
                $('#trequest > tbody').html(html); 
            }

            function checkValue() {
                var manager = $('#leave_manager').val();
                var day = $('#leave_day').val();
                var number = $('#leave_day_number').val();
                var note = $('#leave_days_note').val();

                var is_check = true;

                if (manager == "") {
                    is_check = false;
                    $('#leave_day_error').show();
                } else {
                    $('#leave_day_error').hide();
                }

                if (day == "") {
                    is_check = false;
                    $('#leave_manager_error').show();
                } else {
                    $('#leave_manager_error').hide();
                }

                if (number == "") {
                    is_check = false;
                    $('#leave_day_number_error').show();
                } else {
                    $('#leave_day_number_error').hide();
                }

                return is_check;
            }
            function getFrameByName(name) {
              for (var i = 0; i < frames.length; i++)
                if (frames[i].name == name)
                  return frames[i];
             
              return null;
            }
            function uploadDone(name) {
               var frame = getFrameByName(name);
               if (frame) {
                 ret = frame.document.getElementsByTagName("body")[0].innerHTML;
             
                 /* If we got JSON, try to inspect it and display the result */
                 if (ret.length) {
                   /* Convert from JSON to Javascript object */
                   try {
                        //var json = eval("("+ret+")");
                        var json = $.parseJSON(ret);
                        
                        /* Process data in json ... */
                        var htmText = '';
                        
                        $('#upload_notification').show();
                        $("#upload_notification").removeAttr("style");
                        
                        if(json.result == 0) {
                            $('#upload_notification').addClass('error').removeClass('information');
                            htmText = json.message;
                        }
                        else {
                            $('#upload_notification').addClass('information').removeClass('error');
                            htmText = json.message;
                            location.reload(); 
                        }        
                        $('#upload_notification').show();
                        $('#upload_message').html(htmText);
                   }
                   catch(err) {
                        //Handle errors here
                        $('#upload_message').html(err);
                   }
                   /* Clear value of upload control */
                   $('#upload_scn').val('');
                 }
              }
            }
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
              
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Lập đơn nghỉ phép</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="add_new_leave_days" action="../ajaxserver/working_calendar_server.php" method="post" target="hidden_upload">
                                <fieldset>
                                    <p>
                                        <table>
                                                <tr>
                                                    <th width="25%"><label>Số ngày hiện tại</label></th>
                                                    <td>
                                                        <label id="ngayconlai"></label> 
                                                   </td>
                                                </tr>
                                                <tr>
                                                    <th width="25%"><label>Cấp trên approve</label></th>
                                                    <td>
                                                        <select  style="width: 150px !important" id="leave_manager" name="leave_manager">
                                                            <option value="">----</option>
                                                        </select>
                                                        <img id="leave_manager_error" name="leave_manager_error" class="none" src="../resources/images/icons/cross_circle.png">
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th width="25%"><label>Ngày bắt đầu nghỉ</label></th>
                                                    <td>
                                                        <input type="text" id="leave_day" name="leave_day"  class="text-input small-input" readonly />
                                                        <img id="leave_day_error" class="none" src="../resources/images/icons/cross_circle.png">
                                                    </td>
                                                </tr>

                                                 <tr>
                                                    <th width="25%"><label>Số ngày nghỉ</label></th>
                                                    <td>
                                                         <select  style="width: 150px !important" id="leave_day_number" name="leave_day_number">
                                                            <option value="">----</option>
                                                        </select>
                                                        <img id="leave_day_number_error" class="none" src="../resources/images/icons/cross_circle.png">
                                                    </td>
                                                </tr>
                                                 <tr>
                                                    <th width="25%"><label>Ghi chú</label></th>
                                                    <td>
                                                       <textarea name="leave_days_note" id="leave_days_note" cols="15" rows="5"></textarea>
                                                    </td>
                                                </tr>
                                        </table>
                                        <div class="clear"></div>
                                    </p>
                                    <p>
                                        <div>
                                            <div id="upload_notification" class="notification information png_bg" style="display: none;">
                                                <a href="#" class="close"><img src="../resources/images/icons/cross_grey_small.png" title="Close" alt="close"></a>
                                                <div id="upload_message">
                                                    Message here!
                                                </div>
                                            </div>
                                        </div>
                                        <input type="submit" class="button" value="Xác nhân" name="addleave" id="addleave">
                                    </p>
                                </fieldset>
                                <iframe id="hidden_upload" name="hidden_upload" src="" onload="uploadDone('hidden_upload');"
                                        style="width:0;height:0;border:0px solid #fff">
                                </iframe>
                            </form>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Danh sách các ngày nghỉ  của bạn</h3>
                    </div>
                    <div class="content-box-content" style="display: block">
                        <div class="tab-content default-tab">
                            <table id="tleave">
                                <thead>
                                    <tr>
                                        <th>Ngày lập</th>
                                        <th>Ngày nghỉ</th>
                                        <th>Số ngày nghỉ</th>
                                        <th>Người xác nhận</th>
                                        <th>Ghi chú</th>
                                        <th>Tình trạng</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                             </table>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Danh sách các ngày làm thêm của bạn</h3>
                    </div>
                    <div class="content-box-content" style="display: block">
                        <div class="tab-content default-tab">
                            <table id="trequest">
                                <thead>
                                     <tr>
                                        <th>Ngày lập</th>
                                        <th>Ngày làm thêm</th>
                                        <th>Số ngày làm thêm</th>
                                        <th>Người yêu cầu</th>
                                        <th>Ghi chú</th>
                                        <th>Tình trạng</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                             </table>
                            <div class="clear"></div>
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
