<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ITEMS, F_ITEMS_UPLOAD, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Chi tiết upload</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <script type="text/javascript" src="../resources/scripts/jquery.alphanumeric.js"></script>
        <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/upload_detail.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                loaimap=['SP','MODULE'];
                var oTable = $('#example').dataTable({
                    "bProcessing": true,
                    "bPaginate": false,
                    "bSort": true,
                    <?php if(isset ($_REQUEST['item'])): ?>
                    "bServerSide": true,
                    "sAjaxSource": "../ajaxserver/upload_detail_list_server.php?item=<?php echo $_REQUEST['item']; ?>",
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        $('td:eq(0)', nRow).html("<span class='blue-text'>" + aData[0] + "</span>");
                        $('td:eq(1)', nRow).html(aData[1]);
                        $('td:eq(2)', nRow).html(aData[2]);
                        $('td:eq(3)', nRow).html(aData[3]);
                        $('td:eq(4)', nRow).html(aData[4]);
                        $('td:eq(5)', nRow).html(aData[5]);
                        $('td:eq(6)', nRow).html(aData[6]);
                        $('td:eq(7)', nRow).html(aData[7]);
                        $('td:eq(8)', nRow).html(aData[8]);
                        $('td:eq(9)', nRow).html(aData[9]);
                        $('td:eq(10)', nRow).html(aData[10]);
                        $('td:eq(11)', nRow).html(aData[11]);
                        $('td:eq(12)', nRow).html(aData[12]);
                        $('td:eq(13)', nRow).html("<span class='orange'>" + aData[13] + "</span>");
                        $('td:eq(14)', nRow).html("<span class='blue-violet'>" + aData[14] + "</span>");
                        $('td:eq(15)', nRow).html(loaimap[aData[15]]);
                        $('td:eq(16)', nRow).html(createDeleteButton(aData[16]));
                    },
                    <?php endif; ?>
                    "aaSorting": [[ 0, "desc" ]],
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [ 9, 10, 11 ] }
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
            img { vertical-align: middle; }
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
                <ul class="shortcut-buttons-set">
                    <?php if (verify_access_right(current_account(), F_ITEMS_UPLOAD)): ?>
                        <li>
                            <a class="shortcut-button upload-image" href="upload.php">
                                <span class="png_bg">Quản lý upload sản phẩm</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Chi tiết upload file <span class="blue">[ <?php echo $_GET['file']; ?> ]</span> </h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <div id="dt_example">
                                <div id="container">
                                    <div id="demo">
                                        <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                            <thead>
                                                <tr>
                                                    <th>Mã sản phẩm</th>
                                                    <th>Tên sản phẩm</th>
                                                    <th>Mã loại</th>
                                                    <th>Dài</th>
                                                    <th>Rộng</th>
                                                    <th>Cao</th>
                                                    <th>Giá vốn</th>
                                                    <th>Giá bán</th>
                                                    <th>Mã thợ</th>
                                                    <th>Ghi chú</th>
                                                    <th>Hình ảnh</th>
                                                    <th>Tông màu</th>
                                                    <th>Hoa văn</th>
                                                    <th>Mã kho</th>
                                                    <th>Số lượng</th>
                                                    <th>Loại</th>
                                                    <th>Xóa</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="bulk-actions align-left">
                                <a href="review_upload.php?do=approve&item=<?php echo $_REQUEST['item'];?>" title="Approve file upload này" onclick="return confirm('Bạn có chắc muốn approve không?');">
                                    <img src="../resources/images/approve.jpg" alt="approve" height="20px" width="20px">
                                    <b>Approve</b>
                                </a>
                                <span>&nbsp;&nbsp;</span>
                                <a href="review_upload.php?do=reject&item=<?php echo $_REQUEST['item'];?>" title="Reject file upload này" onclick="return confirm('Bạn có chắc muốn reject không?');">
                                    <img src="../resources/images/reject.jpg" alt="reject" height="20px" width="20px">
                                    <b>Reject</b>
                                </a>
                            </div>
                            <div style="height: 20px"></div>
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
