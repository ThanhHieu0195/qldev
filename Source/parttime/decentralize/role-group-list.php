<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_SYSTEM_ADMIN, F_DECENTRALIZE_ROLE_GROUP, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách nhóm quyền</title>

        <?php require_once '../part/cssjs.php'; ?>

        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
        </style>
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/decentralize/role-group.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                var i = 0;
                var oTable = $('#example').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bPaginate": false,
                    "sAjaxSource": "../ajaxserver/account_role_group_list_server.php",
                    "bSort": true,
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [ 2 ] },
                        { bSortable: false, aTargets: [ 2 ] } // <-- gets columns and turns off sorting
                    ],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                            var ctrlId = 'status_' + aData[0];
                            if (aData[2] == 1) {
                                $('td:eq(0)', nRow).html(String.format("<img id='{0}' src='../resources/images/icons/user-male-add.png' alt='status' title='Nhóm quyền đang enable' /> <a href='../decentralize/role-group-detail.php?i={1}' title='Xem chi tiết'>{2}</a>", ctrlId, aData[0], aData[0]));
                            } else {
                                $('td:eq(0)', nRow).html(String.format("<img id='{0}' src='../resources/images/icons/user-male-delete.png' alt='status' title='Nhóm quyền đang disable' /> <a href='../decentralize/role-group-detail.php?i={1}' title='Xem chi tiết'>{2}</a>", ctrlId, aData[0], aData[0]));
                            }
                            $('td:eq(1)', nRow).html(aData[1]);
                            if (aData[3] != -1) {
                                ctrlId = 'enable_' + aData[0];
                                if (aData[2] == 0) {
                                    $('td:eq(2)', nRow).html(String.format("<div id='{0}'><a href='javascript:' onclick='enableRole(\"{1}\", {2})' title='Enable nhóm quyền này'><img src='../resources/images/icons/user-male-add.png' alt='action' /></a></div>", ctrlId, aData[0], aData[3]));
                                } else if (aData[2] == 1){
                                    $('td:eq(2)', nRow).html(String.format("<div id='{0}'><a href='javascript:' onclick='enableRole(\"{1}\", {2})' title='Disable nhóm quyền này'><img src='../resources/images/icons/user-male-delete.png' alt='action' /></a></div>", ctrlId, aData[0], aData[3]));
                                } 
                            } else {
                                $('td:eq(2)', nRow).html('');
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
                <noscript>
                    <div class="notification error png_bg">
                        <div>
                            Javascript is disabled or is not supported by your browser. Please <a href="http://browsehappy.com/" title="Upgrade to a better browser">upgrade</a> your browser or <a href="http://www.google.com/support/bin/answer.py?answer=23852" title="Enable Javascript in your browser">enable</a> Javascript to navigate the interface properly.
                        </div>
                    </div>
                </noscript>
                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), F_DECENTRALIZE_ROLE_GROUP)) : ?>
                        <li>
                            <a class="shortcut-button freelancer current" href="../decentralize/role-group-list.php">
                                <span class="png_bg">Danh sách nhóm quyền</span>
                            </a>
                        </li>
                        <li>
                            <a class="shortcut-button add-freelancer" href="../decentralize/add-role-group.php"">
                                <span class="png_bg">Thêm nhóm quyền</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%"><!-- Start Content Box -->
                    <div class="content-box-header">
                        <h3>Danh sách nhóm quyền</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <div id="dt_example">
                                <div id="container">
                                    <div id="demo">
                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                            <thead>
                                                <tr>
                                                    <th>Mã nhóm</th>
                                                    <th>Tên nhóm</th>
                                                    <th></th>
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
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>