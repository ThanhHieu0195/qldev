<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_SYSTEM_ADMIN, F_SYSTEM_ADMIN_NEWS_MANAGEMENT, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách nhóm tin</title>

        <?php require_once '../part/cssjs.php'; ?>

        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
        </style>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/news_management/news_group.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                var i = 0;
                var oTable = $('#example').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bPaginate": false,
                    "sAjaxSource": "../ajaxserver/news_group_list_server.php",
                    "bSort": true,
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [ 3, 4 ] },
                        { bSortable: false, aTargets: [ 2, 4 ] } // <-- gets columns and turns off sorting
                    ],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                            $('td:eq(0)', nRow).html(String.format("<a id='div{0}' href='../news_management/news-group-detail.php?i={1}' title='Xem chi tiết'>{2}</a>", iDisplayIndex, aData[0], aData[0]));
                            $('td:eq(1)', nRow).html(aData[1]);
                            $('td:eq(2)', nRow).html(aData[2]);
                            if (aData[3] == 0) {
                                $('td:eq(3)', nRow).html('');
                            } else {
                                $('td:eq(3)', nRow).html("<span class='input-notification success png_bg'></span>");
                            }
                            $('td:eq(4)', nRow).html(String.format("<a href='../news_management/news-group-detail.php?i={0}' title='Cập nhật nhóm tin'><img src='../resources/images/icons/pencil.png' alt='Edit'></a>\
                                                                    <a href='../news_management/news-management-list.php?i={0}' title='Xem danh sách bài viết'><img src='../resources/images/icons/list_16.png' alt='Edit Meta'></a>", 
                                                                    aData[0], aData[0]));

                            /* Tooltip */
                            oTable.$('#div' + iDisplayIndex).tooltip({
                                delay: 50,
                                showURL: false,
                                bodyHandler: function() {
                                    return $("<div></div>").html(aData[5]);
                                }
                            });
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
                    <?php if (verify_access_right(current_account(), F_SYSTEM_ADMIN_NEWS_MANAGEMENT)) : ?>
                        <li>
                            <a class="shortcut-button list current" href="../news_management/news-group-list.php">
                                <span class="png_bg">Danh sách nhóm tin</span>
                            </a>
                        </li>
                        <li>
                            <a class="shortcut-button add" href="../news_management/add-news-group.php"">
                                <span class="png_bg">Thêm nhóm tin mới</span>
                            </a>
                        </li>
                        <li>
                            <a class="shortcut-button new-page" href="../news_management/add-news.php"">
                                <span class="png_bg">Thêm bài viết mới</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%"><!-- Start Content Box -->
                    <div class="content-box-header">
                        <h3>Danh sách nhóm tin</h3>
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
                                                    <th>Ghi chú</th>
                                                    <th>Enable</th>
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