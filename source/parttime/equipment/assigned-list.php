<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_EQUIPMENT, F_EQUIPMENT_ASSIGNED_LIST, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách dụng cụ giao cho bạn</title>
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
        
        <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                $('#example').dataTable({
                    "bProcessing": true,
                    "bPaginate": true,
                    "bSort": true,
                    "bFilter": true,
                    "bServerSide": true,
                    "sAjaxSource": "../ajaxserver/equipment_assigned_list_server.php?stored_in=<?php echo $_REQUEST['stored_in']; ?>",
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        $('td:eq(0)', nRow).html(String.format("<span class='blue-text'>{0}</span>", aData[0]));
                        $('td:eq(1)', nRow).html(aData[1]);
                        $('td:eq(2)', nRow).html(aData[2]);
                        $('td:eq(3)', nRow).html(String.format("<span class='orange'>{0}</span>", aData[3]));
                        $('td:eq(4)', nRow).html(aData[4]);
                    },
                    "aoColumnDefs": [
                        //{ "sClass": "center", "aTargets": [ 5 ] }
                    ]
                });

                $('input[aria-controls="example"]').tooltip({
                //$('#example_filter').tooltip({
                     delay: 50,
                     showURL: false,
                     bodyHandler: function() {
                         return $("<div class='orange'></div>").html('Tìm theo mã/tên dụng cụ');
                     }
                 });
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
                    <?php if (verify_access_right(current_account(), F_EQUIPMENT_ASSIGNED_LIST)): ?>
                        <li>
                            <a class="shortcut-button finished current" href="assigned-list.php">
                                <span class="png_bg">Giao cho bạn</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_EQUIPMENT_LIST_ALL)): ?>
                        <li>
                            <a class="shortcut-button on-going" href="list-all.php">
                                <span class="png_bg">Tất cả</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Danh sách dụng cụ giao cho bạn</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="task-statistic-list" action="" method="get">
                                <div>
                                    <label>Nơi để (kho hàng/chi nhánh):</label>
                                    <select name="stored_in" id="stored_in">
                                        <option value="">- Tất cả -</option>
                                        <?php 
                                        require_once '../models/khohang.php';
                                            
                                        $khohang = new khohang();
                                        $arr = $khohang->danh_sach();
                                        if(is_array($arr)):
                                            $stored_in = $_GET['stored_in'];
                                        
                                            foreach ($arr as $item):
                                                if ($item['makho'] == $stored_in)
                                                    echo "<option value=\"{$item['makho']}\" selected>{$item['tenkho']}</option>";
                                                else
                                                    echo "<option value=\"{$item['makho']}\">{$item['tenkho']}</option>";
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                    <input class="button" type="submit" id="view" value="Xem" />
                                    <div style="height: 10px"></div>
                                </div>
                                <!-- <div>
                                    <input class="button" type="submit" id="view" name="view" value="Thống kê" />
                                    <input class="button" type="button" id="export" name="export" value="Export file Excel 2003" onclick="return export2Excel();" />
                                </div> -->
                            </form>
                            <div id="dt_example">
                                    <div id="container">
                                        <div id="demo">
                                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                                <thead>
                                                    <tr>
                                                        <th>Mã dụng cụ</th>
                                                        <th>Tên dụng cụ</th>
                                                        <th>Tình trạng</th>
                                                        <th>Nơi để</th>
                                                        <th>Ngày giao</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
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