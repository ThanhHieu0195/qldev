<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate ( G_ITEMS, F_ITEMS_HISTORY, TRUE );
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Nhật ký nhập xuất hàng</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <script type="text/javascript" src="../resources/scripts/jquery.alphanumeric.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/import_export_history.js"></script>
        <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                var oTable = $('#example').dataTable({
                    "bProcessing": true,
                    "bPaginate": false,
                    "bSort": true,
                    <?php if(isset ($_REQUEST['view'])): ?>
                    "bServerSide": true,
                    "sAjaxSource": "../ajaxserver/import_export_history_list_server.php?from=<?php echo $_REQUEST['tungay']; ?>&to=<?php echo $_REQUEST['denngay']; ?>&showroom=<?php echo $_REQUEST['showroom']; ?>",
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        $('td:eq(0)', nRow).html("<span class='blue-text'>" + aData[0] + "</span>");
                        $('td:eq(1)', nRow).html(aData[1]);
                        $('td:eq(2)', nRow).html(aData[2]);
                        $('td:eq(3)', nRow).html("<span class='blue-violet'>" + aData[3] + "</span>");
                        $('td:eq(4)', nRow).html(aData[4]);
                        $('td:eq(5)', nRow).html(aData[5]);;
                        $('td:eq(6)', nRow).html(aData[6]);
                        $('td:eq(7)', nRow).html(aData[7]);
                        if(aData[8] == 'Nhập')
                            $('td:eq(8)', nRow).html("<span class='blue-text'>" + aData[8] + "</span>");
                        else
                            $('td:eq(8)', nRow).html("<span class='orange'>" + aData[8] + "</span>");
                        $('td:eq(9)', nRow).html(aData[9]);
                    },
                    <?php endif; ?>
                    "aaSorting": [[ 0, "desc" ]],
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [ 5 ] }
                    ]
                });
            });
        </script>
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
        </style>        
        <style type="text/css">
            div#demo { overflow: auto !important; scrollbar-base-color:#ffeaff !important; }
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #dt_example span { font-weight: normal !important; }  
        </style>
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
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Nhật ký nhập xuất hàng</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="history-list" action="" method="get">
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
                                    <label>Showroom:</label>
                                    <select id="showroom" name="showroom">
                                        <optgroup label="Tất cả các showroom">
                                            <option value="-1">Tất cả</option>
                                        </optgroup>
                                        <optgroup label="Chọn theo showroom">
                                            <?php
                                            include_once '../models/database.php';
                                            require_once '../models/helper.php';
                                            
                                            $db = new database();
                                            $db->setQuery("SELECT * FROM khohang ORDER BY tenkho ASC");
                                            $array = $db->loadAllRow();
                                            ?>
                                            <?php foreach ($array as $value): ?>
                                                <option value="<?php echo $value['makho'] ?>"
                                                        <?php echo ($value['makho'] == $_REQUEST['showroom']) ? "selected='selected'" : "" ?>>
                                                    <?php echo $value['tenkho'] ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </optgroup>
                                    </select>
                                    <span id="error-3" style="color: red"></span>                                    
                                    <div style="height: 10px"></div>
                                </div>
                                <div>
                                    <input class="button" type="submit" id="view" name="view" value="Thống kê" />
                                </div>
                                <div id="dt_example">
                                    <div id="container">
                                        <div id="demo">
                                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                                <thead>
                                                    <tr>
                                                        <th style="width: 98px !important">Ngày</th>
                                                        <th>Giờ</th>
                                                        <th>Nhân viên</th>
                                                        <th>Mã SP</th>
                                                        <th>Tên SP</th>
                                                        <th>Showroom</th>
                                                        <th>Số lượng</th>
                                                        <th>Hóa đơn</th>
                                                        <th>Loại</th>
                                                        <th>Nội dung</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div style="padding: 10px"></div>
                                        <div class="bulk-actions align-left">
                                            <input class="button" type="button" id="export" name="export" value="Export file Excel 2003" onclick="return export2Excel();" />
                                        </div>
                                    </div>
                                </div>
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