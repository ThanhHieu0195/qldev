<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_SYSTEM_ADMIN, F_SYSTEM_ADMIN_NEWS_MANAGEMENT, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách bài viết</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
            .text_area { font-size: 10px; border: 1px solid silver; text-align: center; }
        </style>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <!-- jQuery.bPopup -->
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
        <script type="text/javascript" src="../resources/scripts/utility/news_management/news-management-list.js"></script>
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
                            <a class="shortcut-button list" href="../news_management/news-group-list.php">
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
                <?php
                require_once '../models/news.php';
                require_once '../models/news_group.php';
                
                $group_id = (isset ( $_GET ['i'] )) ? $_GET ['i'] : '';
                $model = new news_group();
                $g = $model->detail($group_id);
                
                if ($g != NULL) {
                    $news_model = new news();
                    $news_model->correct_order($g->group_id);
                }
                ?>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Nhóm tin <span style="color: blue"><?php echo ($g != NULL) ? $g->name : "" ?></span></h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <?php if ($g != NULL): ?>
                                <div id="dt_example">
                                    <div id="container">
                                        <div id="demo">
                                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                                <thead>
                                                    <tr>
                                                        <th>Id</th>
                                                        <th>Tiêu đề</th>
                                                        <th>Mô tả chung</th>
                                                        <th>Ngày tạo</th>
                                                        <th>Cập nhật</th>
                                                        <th>Thứ tự</th>
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
                                <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
                                <script type="text/javascript" charset="utf-8">
                                    $(function() {
                                        var oTable = $('#example').dataTable( {
                                            "bProcessing": true,
                                            "bServerSide": true,
                                            "sAjaxSource": "../ajaxserver/news_management_list_server.php?i=<?php echo (isset($_GET['i'])) ? $_GET['i'] : ""; ?>",
                                            "aaSorting": [[ 5, "asc" ]],
                                            "aoColumnDefs": [
                                                { "sClass": "center", "aTargets": [ 0, 5, 6, 7 ] },
                                                { bSortable: false, aTargets: [ 6, 7 ] } // <-- gets these column(s) and turns off sorting
                                            ],
                                            "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                                                $('td:eq(0)', nRow).html(aData[0]);
                                                $('td:eq(1)', nRow).html(String.format("<a id='div{0}' href='../news_management/news-management-detail.php?i={1}'>{2}</a>", iDisplayIndex, aData[0], aData[1]));
                                                $('td:eq(2)', nRow).html(aData[2]);
                                                $('td:eq(3)', nRow).html(aData[3]);
                                                $('td:eq(4)', nRow).html("<label style='text-align: center; color: #F60;'>" + aData[4] + "</label>");

                                                var strUp = String.format("<a href='javascript:reorder(\"{0}\",\"orderup\")' title='Move Up'>   <img src='../resources/images/icons/uparrow.png' width='16' height='16' border='0' alt='Move Up'></a>", aData[0]), 
                                                    strDown = String.format("<a href='javascript:reorder(\"{0}\",\"orderdown\")' title='Move Down'>  <img src='../resources/images/icons/downarrow.png' width='16' height='16' border='0' alt='Move Down'></a>", aData[0]);
                                                if (aData[8] == -1) {
                                                    strUp = "";
                                                } else if (aData[8] == 1) {
                                                    strDown = "";
                                                }
                                                
                                                $('td:eq(5)', nRow).html(String.format("{0} <br><input type='text' id='order_{1}' name='order' size='5' value='{2}' class='text_area numeric' />\
                                                                                            <a href='javascript:saveorder(\"{3}\", \"{4}\")' title='Save Order'><img src='../resources/images/icons/filesave.png' alt='Save Order'></a>", 
                                                                                      strUp + strDown, aData[0], aData[5], aData[0], aData[5]));

                                                if (aData[6] == 0) {
                                                    $('td:eq(6)', nRow).html("<img title='No' alt='no' src='../resources/images/icons/publish_x.png'>");
                                                } else {
                                                    $('td:eq(6)', nRow).html("<img title='Yes' alt='yes' src='../resources/images/icons/tick.png'>");
                                                }
                                                $('td:eq(7)', nRow).html(String.format("<a title='Cập nhật bài viết' href='../news_management/news-management-detail.php?i={0}'>" + 
                                                                                       "<img alt='Edit' src='../resources/images/icons/pencil.png'></a>", aData[0]));
    
                                                /* Tooltip */
                                                oTable.$('#div' + iDisplayIndex).tooltip({
                                                    delay: 50,
                                                    showURL: false,
                                                    bodyHandler: function() {
                                                        return $("<div></div>").html(aData[7]);
                                                    }
                                                });

                                                /* Numeric */
                                                oTable.$('.numeric').numeric();
                                            },
                                            "fnDrawCallback": function( oSettings ) { // DataTables has redrawn the table
                                                if ($('#notification_msg').html() != "") {
                                                    // Hide loading
                                                    hideLoading();
                                                }
                                            }
                                        });
                                    });
                                </script>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div id="popup" style="display: none">
                    <span id="button_close_popup" class="button_popup b-close" style="display: none"><span>X</span></span>
                    <div id="notification_msg"></div>
                </div>
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>