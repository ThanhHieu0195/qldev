<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_GUEST_DEVELOPMENT, F_GUEST_DEVELOPMENT_LIST_FAVOURITE, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách khách hàng quan tâm</title>
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
        </style>
        
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        
        <!-- jQuery.bPopup -->
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
        
        <script type="text/javascript" src="../resources/scripts/utility/guest_development/list-favourite.js"></script>
        
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                var oTable = $('#example').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bPaginate": true,
                    "sAjaxSource": "../ajaxserver/guest_development_list_favourite_server.php",
                    "aoColumnDefs": [
                                         { "sClass": "center", "aTargets": [6] },
                                         { bSortable: false, aTargets: [ 6 ] } // <-- gets these column(s) and turns off sorting
                                     ],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        $('td:eq(0)', nRow).html(String.format("<a href='javascript:' id='div{0}'>{1}</a>", iDisplayIndex, aData[0]));
                        $('td:eq(1)', nRow).html(aData[1]);
                        $('td:eq(2)', nRow).html(String.format("<span class='blue-text'>{0}</span>", aData[2]));
                        $('td:eq(3)', nRow).html(aData[3]);
                        $('td:eq(4)', nRow).html(String.format("<span class='orange'>{0}</span>", aData[4]));
                        $('td:eq(5)', nRow).html(aData[5]);
                        $('td:eq(6)', nRow).html(String.format("<a title='Cập nhật thông tin khách hàng' href='../guest_development/edit.php?i={0}'><img src='../resources/images/icons/user-edit-16.png' alt='' /></a>", aData[6])
                                                 + String.format("&nbsp; <a target='_blank' title='Liên hệ khách hàng' href='../guest_development/contact.php?i={0}#history'><img src='../resources/images/icons/contact-16.png' alt='' /></a>", aData[6])
                                                 + String.format("&nbsp; <a title='Remove khỏi danh sách quan tâm' href='javascript:removeFavourite(\"{0}\");' id='remove_{1}'><img src='../resources/images/icons/star-delete.png' alt='' /></a>", aData[6], aData[7])
                                                );
                    },
                    "fnDrawCallback": function( oSettings ) { // DataTables has redrawn the table
                        if ($('#popup_msg').html() != "") {
                            // Hide loading
                            hideLoading();
                        }
                    }
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
                            <a class="shortcut-button list" href="../guest_development/list-all.php">
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
                            <a class="shortcut-button finished current" href="../guest_development/list-favourite.php">
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
                        <h3>Danh sách khách hàng quan tâm</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <div id="dt_example">
                                <div id="container">
                                    <div id="demo">
                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                            <thead>
                                                <tr>
                                                    <th>Họ tên</th>
                                                    <th>Địa chỉ/Công ty</th>
                                                    <th>Điện thoại</th>
                                                    <th>Di động</th>
                                                    <th>Email</th>
                                                    <th>Người phụ trách</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                        <div style="padding-bottom: 10px;"></div>
                                    </div>
                                </div>
                            </div>
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