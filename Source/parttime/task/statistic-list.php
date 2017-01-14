<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_TASK, F_TASK_STATISTIC, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Tổng hợp điểm số</title>
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
        
        <script type="text/javascript" src="../resources/scripts/utility/task-statistic-list.js"></script>
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
                    "sAjaxSource": "../ajaxserver/task_statistic_list_server.php?from=<?php echo $_REQUEST['tungay']; ?>&to=<?php echo $_REQUEST['denngay']; ?>",
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        $('td:eq(0)', nRow).html(String.format("<span class='blue-text'>{0}</span>", aData[0]));
                        for(i = 1; i < aData.length; i++) {
                            if(i == aData.length - 1)
                                $('td:eq(' + (i) + ')', nRow).html(String.format("<span class='orange'>{0}</span>", aData[i]));
                            else
                                $('td:eq(' + (i) + ')', nRow).html(String.format("<span class='blue-violet'>{0}</span>", aData[i]));
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
                <div class="clear"></div>
                <ul class="shortcut-buttons-set">
                    <li>
                        <a class="shortcut-button sum current" href="statistic-list.php">
                            <span class="png_bg">Tổng điểm</span>
                        </a>
                    </li>
                    <li>
                        <a class="shortcut-button average" href="average-list.php">
                            <span class="png_bg">Điểm trung bình</span>
                        </a>
                    </li>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Tổng hợp điểm số</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="task-statistic-list" action="" method="get">
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
                                        
                                        $category_model = new task_result_category();
                                        $arr = $category_model->get_all();
                                        if($arr != NULL) {
                                        ?>
                                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example1">
                                                <thead>
                                                    <tr>
                                                        <th>Nhân viên</th>
                                                        <?php foreach ($arr as $c): ?>
                                                        <th><?php echo $c->category_name; ?></th>
                                                        <?php endforeach; ?>
                                                        <th>Tổng cộng</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        <?php } ?>
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