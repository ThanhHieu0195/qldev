<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_TASK, F_TASK_LIST_ALL, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách công việc đã xong toàn bộ</title>
        <?php 
        require_once '../part/cssjs.php';
        ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
        </style>
        <style type="text/css">
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #dt_example span { font-weight: normal !important; }
        </style>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/task-completed-list.js"></script>
        <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
            <?php if(isset ($_REQUEST['view'])): ?>
            var oTable = $('#example1').dataTable({
                    "bProcessing": true,
                    "bPaginate": false,
                    "bSort": false,
                    "bFilter": false,
                    "bServerSide": true,
                    "sAjaxSource": "../ajaxserver/task_completed_list_server.php?from=<?php echo $_REQUEST['tungay']; ?>&to=<?php echo $_REQUEST['denngay']; ?>",
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        $('td:eq(0)', nRow).html(String.format("<a href='../task/detail.php?i={0}' id='div{1}'>{2}</a>", aData[0], iDisplayIndex, aData[1]));
                        $('td:eq(1)', nRow).html(aData[3]);
                        $('td:eq(2)', nRow).html(aData[4]);
                        $('td:eq(3)', nRow).html(aData[5]);
                        $('td:eq(4)', nRow).html(aData[6]);
                        $('td:eq(5)', nRow).html(aData[7]);
                        $('td:eq(6)', nRow).html(aData[8]);
                        $('td:eq(7)', nRow).html(aData[9]);

                        /* Tooltip */
                        oTable.$('#div' + iDisplayIndex).tooltip({
                            delay: 50,
                            showURL: false,
                            bodyHandler: function() {
                                return $("<div></div>").html(aData[2]);
                            }
                        });
                    },
                    "aoColumnDefs": [
                        //{ "sClass": "center", "aTargets": [ 5 ] }
                    ]
                });
            <?php endif; ?>

                $('.dataTables_info').hide();
            });
        </script>
    </head><body>
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
                        <a class="shortcut-button on-going" href="ongoing-list.php">
                            <span class="png_bg">Đang thực hiện</span>
                        </a>
                    </li>
                    <li>
                        <a class="shortcut-button finished" href="finished-list.php">
                            <span class="png_bg">Chờ đánh giá</span>
                        </a>
                    </li>
                    <li>
                        <a class="shortcut-button unevaluated" href="unevaluated-list.php">
                            <span class="png_bg">Chờ cho điểm</span>
                        </a>
                    </li>
                    <li>
                        <a class="shortcut-button completed current" href="completed-list.php">
                            <span class="png_bg">Xong toàn bộ</span>
                        </a>
                    </li>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Danh sách công việc đã xong toàn bộ</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="task-completed-list" action="" method="get">
                                <div>
                                    <label>Từ ngày (yyyy-mm-dd):</label>
                                    <input id="tungay" name="tungay"
                                           class="text-input small-input" style="width: 150px !important"
                                           value="<?php echo (isset($_REQUEST['tungay'])) ? $_REQUEST['tungay'] : '' ?>" 
                                           type="text" readonly="readonly" />
                                    <span id="error-1" style="color: red"></span> 
                                    <div style="height: 10px"></div>
                                </div>
                                <div>
                                    <label>Đến ngày (yyyy-mm-dd):</label>
                                    <input id="denngay" name="denngay"
                                           class="text-input small-input" style="width: 150px !important" 
                                           value="<?php echo (isset($_REQUEST['denngay'])) ? $_REQUEST['denngay'] : '' ?>"
                                           type="text" readonly="readonly" />
                                    <span id="error-2" style="color: red"></span> 
                                    <div style="height: 10px"></div>
                                </div>
                                <div>
                                    <input class="button" type="submit" id="view" name="view" value="Thống kê" />
                                    <input class="button" type="button" id="export" name="export" value="Export file Excel 2003" onclick="return export2Excel();" />
                                </div>
                            <?php if(isset ($_REQUEST['view'])): ?>
                                <div id="dt_example">
                                    <div id="container">
                                        <div id="demo">
                                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example1">
                                                <thead>
                                                    <tr>
                                                        <th>Tiêu đề</th>
                                                        <th>Người tạo</th>
                                                        <th>Người thực hiện</th>
                                                        <th>Thời hạn</th>
                                                        <th>Ngày thực hiện</th>
                                                        <th>Trạng thái</th>
                                                        <th>Xếp hạng</th>
                                                        <th>Kết quả</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                            </form>
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