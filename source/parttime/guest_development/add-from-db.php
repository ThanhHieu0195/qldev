<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_GUEST_DEVELOPMENT, F_GUEST_DEVELOPMENT_ADD_FROM_DB, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thêm khách hàng cần phát triển từ hệ thống</title>
        <?php require_once '../part/cssjs.php'; ?>
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            .name { color: blue; font-weight: bolder; }
            .ui-autocomplete-loading { background: white url('../resources/images/loading.gif') right center no-repeat !important; }
            #main-content tbody tr.alt-row { background: none; }
        </style>
        <script type="text/javascript" src="../resources/scripts/utility/guest_development/add-new.js"></script>
        <script type="text/javascript">
            // DOM load
            $(function() {
                // autocomplete
                $( "#search_guest" ).autocomplete({
                    minLength: 1,
                    source: "../ajaxserver/autocomplete_server.php?type=guest_development",
                    select: function( event, ui ) {
                        $( "#search_guest" ).val('');
                        $( "#tenkhach" ).html( ui.item.hoten );

                        $( "#makhach" ).html( ui.item.makhach );
                        $("#guest_id").val(ui.item.makhach);
                        
                        $( "#nhomkhach" ).html( ui.item.nhomkhach );
                        $( "#diachi" ).html( ui.item.diachi );
            
                        return false;
                    }
                })
                .data( "autocomplete" )._renderItem = function( ul, item ) {
                    return $( "<li></li>" )
                        .data( "item.autocomplete", item )
                        //.append( "<a>" + "<span class='name'>" + item.hoten + "</span>" + "<br>" + item.diachi + "</a>" )
                        .append( String.format("<a> <span class='name'>{0}</span><br/> <span class='price'>{1}</span><br/> {2} </a>", 
                                               item.hoten,
                                               item.dienthoai,
                                               item.diachi) )
                        .appendTo( ul );
                }; 
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
                    <li>
                        <a class="shortcut-button add" href="../guest_development/add-new.php">
                            <span class="png_bg">Thêm khách hàng cần phát triển</span>
                        </a>
                    </li>
                    <li>
                        <a class="shortcut-button list current" href="../guest_development/add-from-db.php">
                            <span class="png_bg">Thêm khách hàng cần phát triển từ hệ thống</span>
                        </a>
                    </li>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Thêm khách hàng cần phát triển từ hệ thống</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab" style="display: block;">
                            <form id="add_from_db" action="../ajaxserver/guest_development.php" method="post" target="hidden_upload">
                                <table>
                                    <tbody>
                                        <tr>
                                            <td width="20%">
                                                <label>Khách hàng (*)</label>
                                            </td>
                                            <td>
                                                <input type="text" class="text-input small-input" name="search_guest" id="search_guest" />
                                                <span class="error_icon input-notification error png_bg" title="Dữ liệu khách hàng không hợp lệ"></span>
                                                <br><br><label>Họ tên:</label><span class="price" id="tenkhach">?</span>
                                                <br><br><label>Mã khách hàng:</label><span class="price" id="makhach">?</span>
                                                <br><br><label>Nhóm khách hàng:</label><span class="price" id="nhomkhach">?</span>
                                                <br><br><label>Địa chỉ:</label><span class="price" id="diachi">?</span>
                                                <input type="hidden" name="guest_id" id="guest_id" value="" />
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label>Email</label>
                                            </td>
                                            <td>
                                                <input type="text" class="text-input small-input" name="email" id="email" value="" />
                                                <span class="error_icon input-notification error png_bg" title="Dữ liệu không hợp lệ"></span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label>Nội dung đã trao đổi (nếu có)</label>
                                            </td>
                                            <td>
                                                <textarea id="contact_content" name="contact_content" row="10" style="margin-top: 2px; margin-bottom: 2px; height: 74px;"></textarea>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label>
                                                    Ngày liên hệ tiếp theo (*)
                                                </label>
                                            </td>
                                            <td>
                                                <img title="Ngày liên hệ" src="../resources/images/icons/calendar_16.png" alt="calendar">
                                                <input type="text" class="text-input small-input date-picker" name="next_schedule" id="next_schedule" readonly="readonly" value="" />
                                                <span class="error_icon input-notification error png_bg" title="Vui lòng chọn ngày"></span>
                                            </td>
                                        </tr>   
                                        <script type="text/javascript" charset="utf-8">
                                            var countId = 0;
                                        </script>
                                        <tr>
                                            <td><label>Danh sách các ngày cần ghi nhớ (nếu có):</label></td>
                                            <td>
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
                                <fieldset>
                                    <p>
                                        <input type="submit" class="button" value="Thêm khách hàng" name="add_from_db" />
                                        <input type="reset" class="button" value="Làm lại" id="reset" name="reset">
                                        <span id="attention" style="color: red;">Có một số trường dữ liệu chưa đúng. Vui lòng kiểm tra lại!</span>
                                    </p>
                                </fieldset>
                                <div id="notification_msg">
                                </div>
                                <iframe id="hidden_upload" name="hidden_upload" src="" onload="uploadDone('hidden_upload');" 
                                        style="width:0;height:0;border:0px solid #fff">
                                </iframe>
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