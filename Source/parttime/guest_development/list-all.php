<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_GUEST_DEVELOPMENT, F_GUEST_DEVELOPMENT_LIST_ALL, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách toàn bộ khách hàng đang theo dõi</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
        </style>
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal !important; }
            .blue-violet { color: blueviolet; font-weight: normal !important; }
            .orange { color: #FF6600; font-weight: normal !important; }
            .bold { font-weight: bolder; }
            .normal-text { font-weight: normal !important; }
            .small-padding { padding: 1px !important; -webkit-border-radius: 0 !important; border-radius: 0 !important; }
        </style>
        
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        
        <!-- jQuery.bPopup -->
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
        
        <script type="text/javascript" src="../resources/scripts/utility/guest_development/list-all.js"></script>
        
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                var enable = 0;
                $('#actions-panel').hide();
                
                var oTable = $('#example').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bPaginate": true,
                    "sAjaxSource": "../ajaxserver/guest_development_list_all_server.php",
                    <?php if (verify_access_right(current_account(), F_GUEST_DEVELOPMENT_LIST_FAVOURITE)): ?>
                        "aoColumnDefs": [
                            { "sClass": "center", "aTargets": [0, 8, 9] },
                            { bSortable: false, aTargets: [ 0, 8, 9 ] } // <-- gets these column(s) and turns off sorting
                        ],
                    <?php else: ?>
                        "aoColumnDefs": [
                                         { "sClass": "center", "aTargets": [0, 8] },
                                         { bSortable: false, aTargets: [ 0, 8 ] } // <-- gets these column(s) and turns off sorting
                                     ],
                    <?php endif; ?>
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        $('td:eq(0)', nRow).html(String.format("<input type='checkbox' id='guest_{0}' name='guest[]' value='{1}'>", iDisplayIndex, aData[8]));
                        $('td:eq(1)', nRow).html(String.format("<a href='javascript:' id='div{0}'>{1}</a>", iDisplayIndex, aData[1]));
                        $('td:eq(2)', nRow).html(String.format("<span title='{0}' class='normal-text'>{1}</span>", aData[2], stripText(aData[2], 15)));
                        $('td:eq(3)', nRow).html(); //String.format("<span class='blue-text'>{0}</span>", aData[3]));
                        $('td:eq(4)', nRow).html(); //aData[4]);
                        $('td:eq(5)', nRow).html(); //String.format("<span title='{0}' class='orange'>{1}</span>", aData[5], stripText(aData[5], 10)));
                        $('td:eq(6)', nRow).html(aData[6]);

                        $('td:eq(7)', nRow).html(aData[7]);
                        $('td:eq(8)', nRow).html(String.format("<a title='Cập nhật thông tin khách hàng' href='../guest_development/edit.php?i={0}'><img src='../resources/images/icons/user-edit-16.png' alt='' /></a>", aData[8])
                                                 + String.format("&nbsp; <a target='_blank' title='Liên hệ khách hàng' href='../guest_development/contact.php?i={0}#history'><img src='../resources/images/icons/contact-16.png' alt='' /></a>", aData[8])
                                                );
                        <?php if (verify_access_right(current_account(), F_GUEST_DEVELOPMENT_LIST_FAVOURITE)): ?>
                            if (aData[9] == 1) {
                                $('td:eq(9)', nRow).html("<img src='../resources/images/icons/star-on.png' alt='' />");
                            } else {
                                $('td:eq(9)', nRow).html("");
                            }
                        <?php endif; ?>

                        if (enable == false) {
                            enable = true;
                            $('#actions-panel').show();
                        }
                    },
                    "fnDrawCallback": function( oSettings ) { // DataTables has redrawn the table
                        if ($('#popup_msg').html() != "") {
                            // Hide loading
                            hideLoading();
                        }
                    }
                });

                //$("input[aria-controls='example']").addClass("text-input small-input small-padding");
                $("select[aria-controls='example']").addClass("small-padding");
            });
        </script>
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
                    <?php if (verify_access_right(current_account(), F_GUEST_DEVELOPMENT_LIST_ASSIGNED)): ?>
                        <li>
                            <a class="shortcut-button on-going" href="../guest_development/list-assigned.php">
                                <span class="png_bg">Khách hàng đang theo dõi</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_GUEST_DEVELOPMENT_LIST_ALL)): ?>
                        <li>
                            <a class="shortcut-button list current" href="../guest_development/list-all.php">
                                <span class="png_bg">Toàn bộ khách đang theo dõi</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_GUEST_DEVELOPMENT_LIST_CANCELLED)): ?>
                        <li>
                            <a class="shortcut-button switch" href="../guest_development/list-cancelled.php">
                                <span class="png_bg">Không cần theo dõi nữa</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_GUEST_DEVELOPMENT_LIST_FAVOURITE)): ?>
                        <li>
                            <a class="shortcut-button finished" href="../guest_development/list-favourite.php">
                                <span class="png_bg">Khách hàng quan tâm</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_GUEST_DEVELOPMENT_LIST_ASSIGNED)): ?>
                        <li>
                            <a class="shortcut-button list" href="../guest_development/guestlistnew.php">
                                <span class="png_bg">Danh sách khách hàng chưa phát triển</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_GUEST_DEVELOPMENT_LIST_UNFOLLOW)): ?>
                        <li>
                            <a class="shortcut-button list" href="../guest_development/unfollow.php">
                                <span class="png_bg">Danh sách khách hàng trả về</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Danh sách toàn bộ khách hàng đang theo dõi</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="list_all" action="../ajaxserver/guest_development.php" method="post" target="hidden_upload">
                                <div id="dt_example">
                                    <div id="container">
                                        <div id="demo">
                                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                                <thead>
                                                    <tr>
                                                        <th><input class="check-all" type="checkbox"></th>
                                                        <th>Họ tên</th>
                                                        <th>Địa chỉ/Công ty</th>
                                                        <th>Điện thoại</th>
                                                        <th>Di động</th>
                                                        <th>Email</th>
                                                        <th>Ngày nhập KH</th>
                                                        <th>Người phụ trách</th>
                                                        <th>Actions</th>
                                                        <?php if (verify_access_right(current_account(), F_GUEST_DEVELOPMENT_LIST_FAVOURITE)): ?>
                                                            <th>Quan tâm</th>
                                                        <?php endif; ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                            <div style="padding-bottom: 10px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <div style="margin: 50px;"></div>
                                <div id="actions-panel" class="bulk-actions align-left" style="display: block;">
                                    <input type="hidden" id="list_all_action" name="list_all_action" value="" />
                                    <!-- Them khach hang vao danh sach quan tam -->
                                    <?php if (verify_access_right(current_account(), F_GUEST_DEVELOPMENT_LIST_FAVOURITE)): ?>
                                        <a class="blue-text" title="Đưa vào danh sách quan tâm" href="javascript:addFavourites();">
                                            <img alt="bookmark" src="../resources/images/icons/bookmark-32.png" />
                                            Đưa vào danh sách quan tâm
                                        </a>
                                        &nbsp;&nbsp;<span style="margin-left: 50px;"></span>
                                    <?php endif; ?>
                                    
                                    <!-- Thay doi nguoi chiu trach nhiem quan ly khach hang -->
                                    <?php if (verify_access_right(current_account(), F_GUEST_DEVELOPMENT_LIST_ALL)): ?>
                                        <select name="assign_to" id="assign_to">
                                            <option value="">Chọn nhân viên theo dõi...</option>
                                            <?php
                                                require_once '../models/nhanvien.php';
                                                
                                                $nhanvien = new nhanvien();
                                                $arr = $nhanvien->employee_list();
                                                if(is_array($arr)):
                                                    foreach ($arr as $item):
                                                        if (verify_access_right($item['manv'], G_GUEST_DEVELOPMENT, KEY_GROUP)):
                                                            echo "<option value=\"{$item['manv']}\">{$item['hoten']}</option>";
                                                        endif;
                                                    endforeach;
                                                endif;
                                            ?>
                                        </select>
                                        <a class="blue-text" title="Thay đổi nhân viên theo dõi" href="javascript:reAssign();">
                                            <img alt="businessman" src="../resources/images/icons/businessman.png" />
                                            Thay đổi nhân viên theo dõi
                                        </a>
                                    <?php endif; ?>
                                </div>
                                <div class="clear" style="padding: 15px"></div>
                                <div id="notification_msg"></div>
                                <iframe id="hidden_upload" name="hidden_upload" src="" onload="uploadDone('hidden_upload');" 
                                        style="width:0;height:0;border:0px solid #fff">
                                </iframe>
                                <div class="clear"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <div id="popup" style="display: none">
                    <div id="popup_msg"></div>
                </div>
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
