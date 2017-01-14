<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_REWARDS_PENALTY, F_REWARDS_PENALTY_STATISTIC_LIST, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Tổng hợp ghi nhận và đóng góp</title>
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
        
        <script type="text/javascript" src="../resources/scripts/utility/rewards-statistic-list.js"></script>
        <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
            <?php if(isset ($_REQUEST['view'])): ?>
                $('#example').dataTable({
                    "bProcessing": true,
                    "bPaginate": false,
                    "bSort": false,
                    "bFilter": false,
                    "bServerSide": true,
                    "sAjaxSource": "../ajaxserver/rewards_statistic_list_server.php?from=<?php echo $_REQUEST['tungay']; ?>&to=<?php echo $_REQUEST['denngay']; ?>",
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        $('td:eq(0)', nRow).html("<span class='blue-text'>" + aData[0] + "</span>");
                        $('td:eq(1)', nRow).html(aData[1]);
                        $('td:eq(2)', nRow).html(aData[2]);
                        $('td:eq(3)', nRow).html(aData[3]);
                        $('td:eq(4)', nRow).html("<span class='blue-violet'>" + aData[4] + "</span>");
                        $('td:eq(5)', nRow).html("<span class='blue-text'>" + aData[5] + "</span>");
                        $('td:eq(6)', nRow).html("<span class='orange'>" + aData[6] + "</span>");
                        $('td:eq(7)', nRow).html(aData[7]);
                    },
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [ 5 ] }
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
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Tổng hợp ghi nhận và đóng góp</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="rewards-statistic-list" action="" method="get">
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
                                        <?php
                                        require_once '../models/task_result_category.php';
                                        
                                        ?>
                                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                                <thead>
                                                    <tr>
                                                        <th>Ngày</th>
                                                        <th>Giờ</th>
                                                        <th>Nội dung sự kiện</th>
                                                        <th>Người ghi nhận</th>
                                                        <th>Người bị/được ghi nhận</th>
                                                        <th>Mức độ quan trọng</th>
                                                        <th>Mức độ mất mát hoặc đóng góp</th>
                                                        <th>Phản hồi</th>
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