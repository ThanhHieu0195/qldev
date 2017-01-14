<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_STORES, F_STORES_SWAP, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách phiếu chuyển hàng đi</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
        </style>
        <style type="text/css">
            img { vertical-align: middle; }
            #notification_msg span { font-size: 13px; }
            .blue-text { color: blue; font-weight: normal; }
			.green-text { color: green; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #dt_example span { font-weight: normal !important; }
        </style>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                var oTable = $('#example').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bPaginate": true,
                    "sAjaxSource": "../ajaxserver/items_swapping_outgoing_list_server.php",
                    "aaSorting": [[ 6, "ASC" ]],
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [ 4, 6 ] }
                    ],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        $('td:eq(0)', nRow).html(String.format("<a href='../stores/swapping-detail.php?i={0}' id='div{1}'>{2}</a>", aData[0], iDisplayIndex, aData[0]));
                        $('td:eq(1)', nRow).html(String.format("<span class='blue-text'>{0}</span>", aData[1]));
                        $('td:eq(2)', nRow).html(aData[2]);
                        $('td:eq(3)', nRow).html(aData[3]);
                        $('td:eq(4)', nRow).html(String.format("<span class=''>{0}</span>", aData[4]));
                        $('td:eq(5)', nRow).html(aData[5]);
                        if(aData[6] == 1) { // Finished
                            $('td:eq(6)', nRow).html(String.format("<span class='blue-text'>{0}</span>", "Xử lý xong"));
                        } else {
							if(aData[6] == -1){
								$('td:eq(6)', nRow).html(String.format("<span class='green-text'>{0}</span>", "Chưa chuyển"));
							}else{
                            $('td:eq(6)', nRow).html(String.format("<span class='orange'>{0}</span>", "Đang xử lý"));
							}
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
                    <li>
                        <a class="shortcut-button new-page" href="../stores/draft-list.php">
                            <span class="png_bg">Phiếu đã tạo</span>
                        </a>
                    </li>
                    <li>
                        <a class="shortcut-button outgoing current" href="../stores/outgoing-list.php">
                            <span class="png_bg">Chuyển đi</span>
                        </a>
                    </li>
                    <li>
                        <a class="shortcut-button ingoing" href="../stores/ingoing-list.php">
                            <span class="png_bg">Chuyển đến</span>
                        </a>
                    </li>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Danh sách phiếu chuyển hàng đi</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <div id="dt_example">
                                <div id="container">
                                    <div id="demo">
                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                            <thead>
                                                <tr>
                                                    <th>Phiếu chuyển</th>
                                                    <th>Ngày giờ chuyển</th>
                                                    <th>Kho chuyển đi</th>
                                                    <th>Kho chuyển đến</th>
                                                    <th>Số lượng mã hàng</th>
                                                    <th>Người thực hiện</th>
                                                    <th>Trạng thái</th>
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