<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_ITEMS, F_ITEMS_LIST, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Hàng có sẵn trong kho</title>
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
            .ui-dialog { top: 187px !important; left: 506px !important; }
            img { vertical-align: middle; }
            #pagging_info { padding-top: 10px; padding-bottom: 0px; }
            div#scroll { overflow: auto !important; scrollbar-base-color:#ffeaff !important; }
            .data_filter { text-align: right; }
            .link { /*visibility: hidden;*/ display: none; }
        	.hidden { display: none; }
        	.number { cursor: pointer !important; }
        	/*.fixed-dialog{ top: 50px !important; left: 150px !important; }*/
            .fixed-dialog{ top: 8% !important; left: 20% !important; }
            table.dataTable { margin: 0 auto; clear: both; width: 100% !important;}
        </style>
        
        <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/item.list.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/view_store.js"></script>
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
                <div class="clear"></div>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Danh sách sản phẩm có sẵn trong kho</h3>
                    </div>                    
                    <div id="dt_example">
                        <div id="container">
                            <div id="demo">
                                <div role="grid" class="dataTables_wrapper" id="example_wrapper">
                                    <div id="example_length" class="dataTables_length">
                                        <label>Hiển thị 
                                            <select id="data_length" name="data_length" size="1" aria-controls="example">
                                                <option value="5" selected="selected">5</option>
                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="50">50</option>
                                            </select> dòng
                                        </label>
                                    </div>
                                    <div id="example_filter" class="data_filter">
                                        <label>Tìm: <input id="data_filter" name="data_filter" type="text" aria-controls="example"></label>
                                    </div>
                                    <div id="example_processing" class="dataTables_processing"
                                        style="visibility: hidden;">Processing...
                                    </div>
                                    <div id="scroll">
                                        <table cellspacing="0" cellpadding="0" border="0" id="example"
                                            class="display dataTable" aria-describedby="example_info">
                                            <thead>
                                                <tr role="row">
                                                    <th class="sorting_disabled" role="columnheader" rowspan="1"
                                                        colspan="1">Mã sản phẩm</th>
                                                    <th class="sorting_disabled" role="columnheader" rowspan="1"
                                                        colspan="1">Tên sản phẩm</th>
                                                    <th class="sorting_disabled" role="columnheader" rowspan="1"
                                                        colspan="1">Loại sản phẩm</th>
                                                    <th class="sorting_disabled" role="columnheader" rowspan="1"
                                                        colspan="1">Giá bán</th>
                                                    <th class="sorting_disabled" role="columnheader" rowspan="1"
                                                        colspan="1">Số lượng</th>
                                                <?php
                                                require_once '../models/khohang.php';
                                                
                                                $kho_hang = new khohang();
                                                $array = $kho_hang->danh_sach();
                                                foreach($array as $row): ?>
                                                    <th class="sorting_disabled" role="columnheader" rowspan="1"
                                                        colspan="1" style="width: 74px;"><?php echo $row['tenkho']; ?></th>  
                                                <?php endforeach; ?>
                                                </tr>
                                            </thead>
                                            <tbody role="alert" aria-live="polite" aria-relevant="all" id="item_list">
                                            </tbody>
                                        </table>
                                    </div>
                                    <div id="pagging_info" class="pages_div"></div>
                                    <div style="padding: 10px"></div>                                
                                    <div class="bulk-actions align-left">
                                        <a href="../phpexcel/export2exel.php?do=export&table=danhsachsanpham" class="button">Export file Excel 2003</a>
                                    </div>
                                    <div style="padding: 10px"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php include_once '../part/footer.php'; ?>
            </div>
        </div>
        <!-- Dialog -->
        <div id="dialog-form" title="Số lượng">
            <!--<form action="" method="post" onsubmit="return false;"> -->
            <p>
                <strong>Mã sản phẩm: </strong>
                <span id="masotranh">ABCDEF</span>
                <input type="hidden" id="action" name="action" value="" />
                <input type="hidden" id="masotranh" name="masotranh" value="" />
                <input type="hidden" id="makho" name="makho" value="" />
                <input type="hidden" id="url" name="url" value="<?php echo $_SERVER['REQUEST_URI']; ?>" />
            </p>
            <p>
                <strong>Tên sản phẩm: </strong>
                <span id="tentranh">ABCDEF</span>
            </p>
            <p>
                <strong>Loại sản phẩm: </strong>
                <span id="loaitranh">ABCDEF</span>
            </p>
            <p>
                <strong>Showroom: </strong>
                <span id="tenkho">ABCDEF</span>
            </p>
            <p>
                <strong>Số lượng hiện tại: </strong>
                <span id="soluongtonkho">ABCDEF</span>
            </p>
            <p>
                <label for="name" id="title">Số lượng</label>
                <input type="text" name="soluong" id="soluong" class="text ui-widget-content ui-corner-all" maxlength="5" />
            </p>
            <!--</form> -->
       </div>
        <!-- Dialog -->
       <div id="bill-dialog" title="Danh sách đơn hàng">
        <div id="dt_example">
            <div id="container">
                <div id="demo">
                	<input type="hidden" id="item" name="item" value="" />
                    <table cellpadding="0" cellspacing="0" border="0" class="display" id="example2">
                        <thead>
                            <tr>
                                <th>Mã hóa đơn</th>
                                <th>Họ tên khách hàng</th>
                                <th>Số lượng</th>
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
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>