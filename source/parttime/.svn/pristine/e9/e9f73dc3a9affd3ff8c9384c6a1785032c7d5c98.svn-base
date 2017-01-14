<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_STORES, F_STORES_ITEM_OF_STORE, TRUE);

// Lay gia tri id cua kho hang
$makho = $_GET['item'];
?>

<?php
    // Type of access rights
    // 0: none
    // 1: amount management
    // 2: swap items
    // 3: 1 & 2
    $type = 0; $i = 0; $j = 0;
    // Check amount management
    if (verify_access_right(current_account(), F_STORES_AMOUNT_MANAGEMENT)
        && check_store_manager(current_account(), $makho)) {
        
        $i = 1;
    }
    // Check swap items
    if (verify_access_right(current_account(), F_STORES_SWAP)
        && check_store_manager(current_account(), $makho)) {
        
        $j = 1;
    }
    // Result
    if ($i == 1 && $j == 1) {
        $type = 3;
    } else {
        if ($i == 1) {
            $type = 1;
        } else if ($j == 1){
            $type = 2;
        }
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách sản phẩm có trong kho</title>
        <?php require_once '../part/cssjs.php'; ?>

        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            .ui-dialog { /*top: 187px !important; left: 506px !important;*/ }
            .text { padding: .4em; }
            .small-padding { padding: 1px !important; -webkit-border-radius: 0 !important; border-radius: 0 !important; }
            .fixed-dialog{ top: 40% !important; left: 40% !important; }
        </style>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
        <style type="text/css">
            img { vertical-align: middle; }
            #notification_msg span { font-size: 13px; }
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
        </style>

        <script type="text/javascript" src="../resources/scripts/jquery.alphanumeric.js"></script>
        <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        
        <!-- jQuery.bPopup -->
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
        
        <script type="text/javascript" src="../resources/scripts/utility/store.js"></script>
        <script type="text/javascript" src="../resources/scripts/utility/stores/item_of_store.js"></script>
        <script type="text/javascript" charset="utf-8">
            // DOM load
            $(document).ready(function() {
                var enable = 0;
                $('#actions-panel').hide();
                
                // DataTable
                var oTable = $('#example').dataTable( {
                    "bProcessing": true,
                    "bServerSide": true,
                    "bSort": false,
                    "sAjaxSource": "../ajaxserver/itemofstore_server.php?makho=<?php if(isset($_GET['item'])) echo $_GET['item'] ?>",

                    // 0: None
                    <?php if ($type == 0): ?>
                        "aoColumnDefs": [
                            { "sClass": "center", "aTargets": [ 4 ] }
                            //{ bSortable: false, aTargets: [ 0, 6, 7 ] } // <-- gets columns and turns off sorting
                        ],
                        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                            /* Row's data */
                            $('td:eq(0)', nRow).html("<a href='../items/itemdetail.php?item=" + aData[1] + "' id='div" + iDisplayIndex + "'>" + aData[1] + "</a>" );
                            $('td:eq(1)', nRow).html(aData[2]);
                            $('td:eq(2)', nRow).html(aData[3]);
                            $('td:eq(3)', nRow).html("<span class='price'>" + aData[4] + "</span>");
                            $('td:eq(4)', nRow).html("<span class='blue'>" + aData[5] + "</span>");

                            if (enable == false) {
                                enable = true;
                                $('#actions-panel').show();
                            }
                            
                            /* Tooltip */
                            oTable.$('#div' + iDisplayIndex).tooltip({
                                delay: 50,
                                showURL: false,
                                bodyHandler: function() {
                                    return $("<img />").attr("src", "../" + aData[0]);
                                }
                            });
                        }
                    <?php endif; ?>
                    
                    // 1: amount management
                    <?php if ($type == 1): ?>
                        "aoColumnDefs": [
                            { "sClass": "center", "aTargets": [ 4, 5 ] },
                            { bSortable: false, aTargets: [ 5 ] } // <-- gets columns and turns off sorting
                        ],
                        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                            /* Row's data */
                            $('td:eq(0)', nRow).html("<a href='../items/itemdetail.php?item=" + aData[1] + "' id='div" + iDisplayIndex + "'>" + aData[1] + "</a>" );
                            $('td:eq(1)', nRow).html(aData[2]);
                            $('td:eq(2)', nRow).html(aData[3]);
                            $('td:eq(3)', nRow).html("<span class='price'>" + aData[4] + "</span>");
                            $('td:eq(4)', nRow).html("<span class='blue'>" + aData[5] + "</span>");
                            $('td:eq(5)', nRow).html("<a href=\"javascript:showDialog('" + aData[1] + "', '" + aData[7] +"', '" + aData[5] +"')\" title='Thay đổi số lượng'> " +
                                                     "    <img src='../resources/images/icons/minus.png' alt='minus'> " +
                                                     "</a>");

                            if (enable == false) {
                                enable = true;
                                $('#actions-panel').show();
                            }
                            
                            /* Tooltip */
                            oTable.$('#div' + iDisplayIndex).tooltip({
                                delay: 50,
                                showURL: false,
                                bodyHandler: function() {
                                    return $("<img />").attr("src", "../" + aData[0]);
                                }
                            });
                        }
                    <?php endif; ?>
                    
                    // 2: swap items
                    <?php if ($type == 2): ?>
                        "aoColumnDefs": [
                            { "sClass": "center", "aTargets": [ 0, 5 ] },
                            { bSortable: false, aTargets: [ 0, 6 ] } // <-- gets columns and turns off sorting
                        ],
                        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                            /* Row's data */
                            $('td:eq(0)', nRow).html("<input type='checkbox' id='masotranh" + iDisplayIndex + "' name='masotranh[]' " +
                                                     "       value='" + aData[1] +"' " +
                                                     "       onclick=\"return createInput('#masotranh" + iDisplayIndex +"', '" + aData[5] +"');\">");
                            $('td:eq(1)', nRow).html("<a href='../items/itemdetail.php?item=" + aData[1] + "' id='div" + iDisplayIndex + "'>" + aData[1] + "</a>" );
                            $('td:eq(2)', nRow).html(aData[2]);
                            $('td:eq(3)', nRow).html(aData[3]);
                            $('td:eq(4)', nRow).html("<span class='price'>" + aData[4] + "</span>");
                            $('td:eq(5)', nRow).html("<span class='blue'>" + aData[5] + "</span>");
                            $('td:eq(6)', nRow).html("").attr("id", "container" + iDisplayIndex);

                            if (enable == false) {
                                enable = true;
                                $('#actions-panel').show();
                            }
                            
                            /* Tooltip */
                            oTable.$('#div' + iDisplayIndex).tooltip({
                                delay: 50,
                                showURL: false,
                                bodyHandler: function() {
                                    return $("<img />").attr("src", "../" + aData[0]);
                                }
                            });
                        }
                    <?php endif; ?>

                    // 3: 1 & 2
                    <?php if ($type == 3): ?>
                        "aoColumnDefs": [
                            { "sClass": "center", "aTargets": [ 0, 5, 7 ] },
                            { bSortable: false, aTargets: [ 0, 6, 7 ] } // <-- gets columns and turns off sorting
                        ],
                        "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                            /* Row's data */
                            $('td:eq(0)', nRow).html("<input type='checkbox' id='masotranh" + iDisplayIndex + "' name='masotranh[]' " +
                                                     "       value='" + aData[1] +"' " +
                                                     "       onclick=\"return createInput('#masotranh" + iDisplayIndex +"', '" + aData[5] +"');\">");
                            $('td:eq(1)', nRow).html("<a href='../items/itemdetail.php?item=" + aData[1] + "' id='div" + iDisplayIndex + "'>" + aData[1] + "</a>" );
                            $('td:eq(2)', nRow).html(aData[2]);
                            $('td:eq(3)', nRow).html(aData[3]);
                            $('td:eq(4)', nRow).html("<span class='price'>" + aData[4] + "</span>");
                            $('td:eq(5)', nRow).html("<span class='blue'>" + aData[5] + "</span>");
                            $('td:eq(6)', nRow).html("").attr("id", "container" + iDisplayIndex);
                            $('td:eq(7)', nRow).html("<a href=\"javascript:showDialog('" + aData[1] + "', '" + aData[7] +"', '" + aData[5] +"')\" title='Thay đổi số lượng'> " +
                                                     "    <img src='../resources/images/icons/minus.png' alt='minus'> " +
                                                     "</a>");

                            if (enable == false) {
                                enable = true;
                                $('#actions-panel').show();
                            }
                            
                            /* Tooltip */
                            oTable.$('#div' + iDisplayIndex).tooltip({
                                delay: 50,
                                showURL: false,
                                bodyHandler: function() {
                                    return $("<img />").attr("src", "../" + aData[0]);
                                }
                            });
                        }
                    <?php endif; ?>
                });
                
                $("input[aria-controls='example']").addClass("text-input small-input small-padding");
                $("select[aria-controls='example']").addClass("small-padding");
            });
        </script>
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
                    <li>
                        <a class="shortcut-button upload-image" href="storelist.php">
                            <span class="png_bg">Danh sách kho hàng</span>
                        </a>
                    </li>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <?php
                        require_once '../models/khohang.php';
                        require_once '../models/helper.php';
                        require_once '../models/tonkho.php';
                          
                        // Lay ten kho hang
                        $khohang = new khohang();
                        $tenkho = $khohang->ten_kho($makho);
                           
                        // Xoa cac mat hang ton kho het so luong     
                        $tonkho = new tonkho();
                        $tonkho->xoa_hang_muc_het_so_luong();
                        ?>
                        <h3>Danh sách sản phẩm <span class="blue">[ <?php echo $tenkho; ?> ]</span> </h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="itemofstore" action="../ajaxserver/items_swapping_server.php" method="post" target="hidden_upload">
                                <div id="dt_example">
                                    <div id="container">
                                        <div id="demo">
                                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                                <thead>
                                                    <tr>
                                                        <?php if (verify_access_right(current_account(), F_STORES_SWAP)
                                                          && check_store_manager(current_account(), $makho)): ?>
                                                            <th>Chọn</th>
                                                        <?php endif; ?>
                                                        
                                                        <th>Mã sản phẩm</th>
                                                        <th>Tên sản phẩm</th>
                                                        <th>Loại sản phẩm</th>
                                                        <th>Giá bán</th>
                                                        <th>Số lượng tồn</th>
                                                        
                                                        <?php if (verify_access_right(current_account(), F_STORES_SWAP)
                                                          && check_store_manager(current_account(), $makho)): ?>
                                                            <th>Số lượng chuyển kho</th>
                                                        <?php endif; ?>
                                                        
                                                        <!-- Thay doi so luong trong kho -->
                                                        <?php if (verify_access_right(current_account(), F_STORES_AMOUNT_MANAGEMENT)
                                                                  && check_store_manager(current_account(), $makho)): ?>
                                                            <th></th>
                                                        <?php endif; ?>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div style="margin: 50px;"></div>
                                    <div id="actions-panel" class="bulk-actions align-left" style="display: none;">
                                        <?php if (verify_access_right(current_account(), F_STORES_ITEM_OF_STORE)): ?>
                                            <a id="export-panel" title="Xuất ra dạng Excel 2003" href="../phpexcel/export2exel.php?do=export&table=danhsachtranh&store=<?php echo $makho ?>">
                                                <img alt="export" src="../resources/images/icons/excel_32.png" />
                                            </a>
                                        <?php endif; ?>
                                                
                                        <!-- Trao doi hang giua cac kho -->
                                        <?php if (verify_access_right(current_account(), F_STORES_SWAP)
                                                  && check_store_manager(current_account(), $makho)): ?>
                                            &nbsp;&nbsp;<input type="hidden" name="from" value="<?php echo $makho ?>" />
                                            <select name="to" id="to">
                                                <option value="">Chọn kho hàng...</option>
                                                <?php
                                                //++ REQ20120508_BinhLV_M
                                                require_once '../models/database.php';
    
                                                $db = new database();
                                                $db->setQuery("SELECT * FROM khohang");
                                                $array = $db->loadAllRow();
                                                foreach ($array as $value)
                                                {
                                                    if ($value['makho'] != $makho)
                                                        echo "<option value='" . $value['makho'] . "'>" . $value['tenkho'] . "</option>";
                                                }
                                                //-- REQ20120508_BinhLV_M
                                                ?>
                                            </select>
                                            <input type="submit" name="swap_items" value="Chuyển hàng" class="button" />
                                            <span id="error" style="padding-left: 20px" class="require"></span>
                                        <?php endif; ?>
                                </div>
                                <div class="clear" style="padding: 5px"></div>
                                <div id="notification_msg"></div>
                                <iframe id="hidden_upload" name="hidden_upload" src="" onload="uploadDone('hidden_upload');" 
                                        style="width:0;height:0;border:0px solid #fff">
                                </iframe>
                                <div class="clear"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <?php include_once '../part/footer.php'; ?>
            </div>
        </div>
        <div id="popup">
            <span class="button_popup b-close"><span>X</span></span>
            <div id="popup_msg"></div>
        </div>
        <!-- Dialog -->
        <div id="dialog-form" title="Số lượng">
            <p id="require" style="color: red; font-weight: bolder;">* Nhập số lượng cần xóa đi.</p>
                <fieldset>
                    <label for="name">Số lượng</label>
                    <input type="hidden" id="masotranh" value="masotranh" />
                    <input type="hidden" id="makho" value="makho" />
                    <input type="hidden" id="tonkho" value="10" />
                    <input type="text" name="soluong" id="soluong" class="text ui-widget-content ui-corner-all numeric" maxlength="5" />
                </fieldset>
       </div>
       <div id="ajax-loader" style="display: none;"><img src="../resources/images/loadig_big.gif" /> <span style="color: black;">Loading...</span></div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>