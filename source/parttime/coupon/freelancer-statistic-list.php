<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_COUPON, F_COUPON_FREELANCER_STATISTIC_ALL, TRUE);

require_once '../models/donhang.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Tổng hợp doanh thu</title>
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
        
        <script type="text/javascript" src="../resources/scripts/jquery.alphanumeric.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/freelancer-statistic-list.js"></script>
        <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
            <?php if(isset ($_REQUEST['view'])): ?>
                $('#example1').dataTable({
                    "bProcessing": true,
                    "bPaginate": false,
                    "bSort": false,
                    "bFilter": false,
                    "bServerSide": true,
                    "sAjaxSource": "../ajaxserver/freelancer_statistic_list_server.php?from=<?php echo $_REQUEST['tungay']; ?>&to=<?php echo $_REQUEST['denngay']; ?>&status=<?php echo donhang::$CHO_GIAO; ?>",
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        var text = aData[0];
                        if(iDisplayIndex == 0) {
                            text = String.format("<span class='blue-text'>{0}</span>", aData[0]);
                        }
                        else {
                            text = String.format("<a href='../coupon/freelancer-statistic.php?account={0}&uid={1}&tungay={2}&denngay={3}&view=Thống+kê'>{4}</a>", 
                                                 aData[0], aData[3], '<?php echo $_REQUEST['tungay']; ?>', '<?php echo $_REQUEST['denngay']; ?>', aData[0]);
                        }
                        // $('td:eq(0)', nRow).html(String.format("../coupon/freelancer-statistic.php?account={0}&uid={1}", aData[0], aData[3]));
                        $('td:eq(0)', nRow).html(text);
                        $('td:eq(1)', nRow).html(aData[1]);
                        $('td:eq(2)', nRow).html("<span class='orange'>" + aData[2] + "</span>");

                        if(iDisplayIndex == 0) {
                            $('td:eq(0)', nRow).addClass('group');
                            $('td:eq(1)', nRow).addClass('group');
                            $('td:eq(2)', nRow).addClass('group');
                        }
                    },
                    "aoColumnDefs": [
                        //{ "sClass": "center", "aTargets": [ 5 ] }
                    ]
                });

                $('#example2').dataTable({
                    "bProcessing": true,
                    "bPaginate": false,
                    "bSort": false,
                    "bFilter": false,
                    "bServerSide": true,
                    "sAjaxSource": "../ajaxserver/freelancer_statistic_list_server.php?from=<?php echo $_REQUEST['tungay']; ?>&to=<?php echo $_REQUEST['denngay']; ?>&status=<?php echo donhang::$DA_GIAO; ?>",
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        var text = aData[0];
                        if(iDisplayIndex == 0) {
                            text = String.format("<span class='blue-text'>{0}</span>", aData[0]);
                        }
                        else {
                            text = String.format("<a href='../coupon/freelancer-statistic.php?account={0}&uid={1}&tungay={2}&denngay={3}&view=Thống+kê'>{4}</a>", 
                                                 aData[0], aData[3], '<?php echo $_REQUEST['tungay']; ?>', '<?php echo $_REQUEST['denngay']; ?>', aData[0]);
                        }
                        // $('td:eq(0)', nRow).html(String.format("../coupon/freelancer-statistic.php?account={0}&uid={1}", aData[0], aData[3]));
                        $('td:eq(0)', nRow).html(text);
                        $('td:eq(1)', nRow).html(aData[1]);
                        $('td:eq(2)', nRow).html("<span class='orange'>" + aData[2] + "</span>");

                        if(iDisplayIndex == 0) {
                            $('td:eq(0)', nRow).addClass('group');
                            $('td:eq(1)', nRow).addClass('group');
                            $('td:eq(2)', nRow).addClass('group');
                        }
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
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Tổng hợp doanh thu</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="freelancer-statistic-list" action="" method="get">
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
                                            <h4 style="color:rgb(73,134,231);">&bull; Doanh thu theo đơn hàng chờ giao</h4>
                                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example1">
                                                <thead>
                                                    <tr>
                                                        <th>Cộng tác viên</th>
                                                        <th>Họ tên</th>
                                                        <th>Doanh thu</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div id="dt_example">
                                    <div id="container">
                                        <div id="demo">
                                            <h4 style="color:rgb(73,134,231);">&bull; Doanh thu theo đơn hàng đã giao</h4>
                                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example2">
                                                <thead>
                                                    <tr>
                                                        <th>Cộng tác viên</th>
                                                        <th>Họ tên</th>
                                                        <th>Doanh thu</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                        <!--<div style="padding: 10px"></div>
                                        <div class="bulk-actions align-left">
                                            <input class="button" type="button" id="export" name="export" value="Export file Excel 2003" onclick="return export2Excel();" />
                                        </div>-->
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