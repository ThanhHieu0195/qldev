<?php
require_once '../part/common_start_page.php';
require_once '../models/default_users.php';

// Product Id to searching
$item_id = (isset ( $_REQUEST ['i'] )) ? $_REQUEST ['i'] : '';

// Get info from request
$username = (isset ( $_REQUEST ['u'] )) ? $_REQUEST ['u'] : '';
$password = (isset ( $_REQUEST ['p'] )) ? $_REQUEST ['p'] : '';
if (! empty ( $password )) {
    $password = md5 ( $password );
}

// Get info from database
$users_model = new default_users();
$u = $users_model->detail($username);

// Login result
$result = FALSE;

// Check info
if ($u != NULL) {
    if ($u->enable == BIT_TRUE && $u->password == $password) {
        $result = TRUE;
    }
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php if ($result): ?>
<?php if (empty($item_id)): ?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Default user</title>
        <?php require_once '../part/cssjs.php'; ?>

        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
        </style>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <style type="text/css">
            #dialog-form label, #dialog-form input { display: block; }
            #dialog-form input.text { margin-bottom: 12px; width: 95%; padding: .4em; }
            #dialog-form fieldset { padding: 0; border: 0; margin-top: 25px; }
            #dialog-form h1 { font-size: 1.2em; margin: .6em 0; }
            div#users-contain { width: 350px; margin: 20px 0; }
            div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
            div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
            .ui-dialog { left: 40% !important; top: 40% !important; }
            .ui-dialog .ui-state-error { padding: .3em; }
            .validateTips { border: 1px solid transparent; padding: 0.3em; }
            #loading { display: none; }
            img { vertical-align: middle; }
            /*.fixed-dialog{ top: 50px !important; left: 150px !important; }*/
            .fixed-dialog{ top: 8% !important; left: 20% !important; }
            table.dataTable { margin: 0 auto; clear: both; width: 100% !important;}
        </style>

        <?php
        require_once '../config/constants.php';
        require_once '../models/helper.php';
        require_once '../models/nhanvien.php';
        ?>

        <script type="text/javascript" src="../resources/scripts/jquery.alphanumeric.js"></script>
        <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                var oTable = $('#example').dataTable( {
                    "bProcessing": true,
                    "bSort": true,
                    "bServerSide": true,
                    "sAjaxSource": "../ajaxserver/server_processing_default_user_list.php?account=<?php echo $u->account_id; ?>",
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [ 5] }
                    ],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        $('td:eq(0)', nRow).html( "<a href='javascript:' id='div" + iDisplayIndex + "'>" + aData[0] + "</a>" );
                        //$('td:eq(6)', nRow).html(aData[8]);
                        /* Gia ban san pham */
                        var html = "<span class='price'>" + aData[3] + "</span>";
                        $('td:eq(3)', nRow).html(html);

                        /* Tooltip */
                        oTable.$('#div' + iDisplayIndex).tooltip({
                            delay: 50,
                            showURL: false,
                            bodyHandler: function() {
                                return $("<img />").attr("src", "../" + aData[7]);
                            }
                        });
                    }
                });
            } );
        </script>
    </head>
    <body>
        <div id="body-wrapper">
            <?php
            require_once '../part/menu_default_user.php';
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
                        <h3>Danh sách sản phẩm có sẵn trong kho</h3>
                    </div>
                    <div id="dt_example">
                        <div id="container">
                            <div id="demo">
                                <?php
                                require_once '../models/tonkho.php';
                                
                                // Xoa cac mat hang ton kho het so luong
                                $tonkho = new tonkho();
                                $tonkho->xoa_hang_muc_het_so_luong();
                                ?>
                                <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                    <thead>
                                        <tr>
                                            <th>Mã sản phẩm</th>
                                            <th>Tên sản phẩm</th>
                                            <th>Loại sản phẩm</th>
                                            <th>Giá bán</th>
                                            <th>Thuộc kho hàng</th>
                                            <th>Tồn kho</th>
                                            <th>Số lượng tổng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                                <br />
                                <br />
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php else: ?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Default user</title>
        <?php require_once '../part/cssjs.php'; ?>

        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
        </style>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <style type="text/css">
            #dialog-form label, #dialog-form input { display: block; }
            #dialog-form input.text { margin-bottom: 12px; width: 95%; padding: .4em; }
            #dialog-form fieldset { padding: 0; border: 0; margin-top: 25px; }
            #dialog-form h1 { font-size: 1.2em; margin: .6em 0; }
            div#users-contain { width: 350px; margin: 20px 0; }
            div#users-contain table { margin: 1em 0; border-collapse: collapse; width: 100%; }
            div#users-contain table td, div#users-contain table th { border: 1px solid #eee; padding: .6em 10px; text-align: left; }
            .ui-dialog { left: 40% !important; top: 40% !important; }
            .ui-dialog .ui-state-error { padding: .3em; }
            .validateTips { border: 1px solid transparent; padding: 0.3em; }
            #loading { display: none; }
            img { vertical-align: middle; }
            /*.fixed-dialog{ top: 50px !important; left: 150px !important; }*/
            .fixed-dialog{ top: 8% !important; left: 20% !important; }
            table.dataTable { margin: 0 auto; clear: both; width: 100% !important;}
        </style>

        <?php
        require_once '../config/constants.php';
        require_once '../models/helper.php';
        require_once '../models/nhanvien.php';
        ?>

        <script type="text/javascript" src="../resources/scripts/jquery.alphanumeric.js"></script>
        <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                var oTable = $('#example').dataTable( {
                    "bProcessing": true,
                    "bSort": true,
                    "bPaginate": false,
                    "bServerSide": true,
                    "sAjaxSource": "../ajaxserver/server_processing_default_user.php?account=<?php echo $u->account_id; ?>",
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [ 5 ] },
                        { bSortable: false, aTargets: [ 4, 5] } // <-- gets columns and turns off sorting
                    ],
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        $('td:eq(0)', nRow).html( "<a href='javascript:' id='div" + iDisplayIndex + "'>" + aData[0] + "</a>" );
                        /* Gia ban san pham */
                        var html = "<span class='price'>" + aData[3] + "</span>";
                        $('td:eq(3)', nRow).html(html);

                        /* Tooltip */
                        oTable.$('#div' + iDisplayIndex).tooltip({
                            delay: 50,
                            showURL: false,
                            bodyHandler: function() {
                                return $("<img />").attr("src", "../" + aData[6]);
                            }
                        });
                    }
                });

                // Sometime later - filter...
                <?php 
                $search = (isset ( $_REQUEST ['i'] )) ? $_REQUEST ['i'] : '';
                ?>
                oTable.fnFilter('<?php echo $search; ?>');
            } );
        </script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
            });
        </script>
    </head>
    <body>
            <div id="body-wrapper">
                <?php
                require_once '../part/menu_default_user.php';
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
                            <h3>Danh sách sản phẩm có sẵn trong kho</h3>
                        </div>
                        <div id="dt_example">
                            <div id="container">
                                <div id="demo">
                                    <?php
                                    require_once '../models/tonkho.php';
                                    
                                    // Xoa cac mat hang ton kho het so luong
                                    $tonkho = new tonkho();
                                    $tonkho->xoa_hang_muc_het_so_luong();
                                    ?>
                                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                        <thead>
                                            <tr>
                                                <th>Mã sản phẩm</th>
                                                <th>Tên sản phẩm</th>
                                                <th>Loại sản phẩm</th>
                                                <th>Giá bán</th>
                                                <th>Thuộc kho hàng</th>
                                                <th>Số lượng tồn</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <br />
                                    <br />
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php include_once '../part/footer.php'; ?>
                </div>
            </div>
    </body>
</html>
<?php endif; ?>
<?php else: ?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Default user</title>
    </head>
    <body>
        <h1>Access forbidden!</h1>
    </body>
</html>
<?php endif; ?>
<?php 
require_once '../part/common_end_page.php';
?>