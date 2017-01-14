<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_EQUIPMENT, F_EQUIPMENT_LIST_ALL, TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách dụng cụ</title>
        <?php 
        require_once '../part/cssjs.php';
        ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
            .text { padding: .4em; }
            .small-padding { padding: 1px !important; -webkit-border-radius: 0 !important; border-radius: 0 !important; }
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
        
        <script type="text/javascript" src="../resources/scripts/utility/equipment/re-assign.js"></script>
        <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript" charset="utf-8">
            $(function() {
                var enable = 0;
                $('#reassign-panel').hide();
                
                $('#example').dataTable({
                    "bProcessing": true,
                    "bPaginate": true,
                    "bSort": true,
                    "bFilter": true,
                    "bServerSide": true,
                    <?php if (verify_access_right(current_account(), F_EQUIPMENT_SWAP)) { ?>
                    "sAjaxSource": "../ajaxserver/equipment_list_all_server.php?stored_in=<?php echo $_REQUEST['stored_in']; ?>&assign_to=<?php echo $_REQUEST['assign_to']; ?>",
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        if (aData[7] == 1) {
                            $('td:eq(0)', nRow).html(String.format("<input type='checkbox' id='equipment_{0}' name='equipment[]' value='{1}'>", iDisplayIndex, aData[0]));
                        } else {
                            $('td:eq(0)', nRow).html("");
                        }
                        $('td:eq(1)', nRow).html(String.format("<span class='blue-text'>{0}</span>", aData[1]));
                        $('td:eq(2)', nRow).html(aData[2]);
                        $('td:eq(3)', nRow).html(aData[3]);
                        $('td:eq(4)', nRow).html(String.format("<span class='orange'>{0}</span>", aData[4]));
                        $('td:eq(5)', nRow).html(aData[5]);
                        $('td:eq(6)', nRow).html(aData[6]);

                        if (enable == false) {
                            enable = true;
                            $('#reassign-panel').show();
                        }
                    },
                    "aoColumnDefs": [
                        { "sClass": "center", "aTargets": [0] },
                        { bSortable: false, aTargets: [ 0 ] } // <-- gets first column and turns off sorting
                    ]
                    <?php } else { ?>
                    "sAjaxSource": "../ajaxserver/equipment_list_all_server_2.php?stored_in=<?php echo $_REQUEST['stored_in']; ?>&assign_to=<?php echo $_REQUEST['assign_to']; ?>",
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        $('td:eq(0)', nRow).html(String.format("<span class='blue-text'>{0}</span>", aData[0]));
                        $('td:eq(1)', nRow).html(aData[1]);
                        $('td:eq(2)', nRow).html(aData[2]);
                        $('td:eq(3)', nRow).html(String.format("<span class='orange'>{0}</span>", aData[3]));
                        $('td:eq(4)', nRow).html(aData[4]);
                        $('td:eq(5)', nRow).html(aData[5]);
                    }
                    <?php } ?>
                });

                $("input[aria-controls='example']").addClass("text-input small-input small-padding");
                $("select[aria-controls='example']").addClass("small-padding");
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
                            <a class="shortcut-button finished" href="assigned-list.php">
                                <span class="png_bg">Giao cho bạn</span>
                            </a>
                        </li>
                    <?php endif; ?>
                    <?php if (verify_access_right(current_account(), F_EQUIPMENT_LIST_ALL)): ?>
                        <li>
                            <a class="shortcut-button on-going current" href="list-all.php">
                                <span class="png_bg">Tất cả</span>
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Danh sách dụng cụ</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="list-all" action="" method="get">
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
                                    <div style="height: 10px"></div>
                                </div>
                                <div>
                                    <label>Người chịu trách nhiệm:</label>
                                    <select name="assign_to" id="assign_to">
                                        <option value="">- Tất cả -</option>
                                        <?php 
                                        require_once '../models/nhanvien.php';
                                            
                                        $nhanvien = new nhanvien();
                                        $arr = $nhanvien->employee_list();
                                        if(is_array($arr)):
                                            $assign_to = $_GET['assign_to'];
                                        
                                            foreach ($arr as $item):
                                                if ($item['manv'] == $assign_to)
                                                    echo "<option value=\"{$item['manv']}\" selected>{$item['hoten']}</option>";
                                                else
                                                    echo "<option value=\"{$item['manv']}\">{$item['hoten']}</option>";
                                            endforeach;
                                        endif;
                                        ?>
                                    </select>
                                    <div style="height: 10px"></div>
                                </div>
                                <div>
                                    <input class="button" type="submit" id="view" value="Xem" />
                                    <!-- <input class="button" type="button" id="export" name="export" value="Export file Excel 2003" onclick="return export2Excel();" /> -->
                                </div>
                            </form>
                            <form id="re-assign" action="" method="post">
                                <?php
                                require_once '../models/equipment.php';
                                require_once '../models/equipment_assign.php';
                                
                                if(isset($_POST['submit'])) {
                                    $equipment_id = $_POST['equipment'];
                                    $stored_in_new = ($_POST['stored_in_new'] == "") ? NULL : $_POST['stored_in_new'];
                                    $assign_to_new = ($_POST['assign_to_new'] == "") ? NULL : $_POST['assign_to_new'];
                                    
                                    //debug($equipment_id);
                                    //debug($stored_in_new);
                                    //debug($assign_to_new);
                                    
                                    if (is_array($equipment_id)) {
                                        $equipment_model = new equipment();
                                        $assign_model = new equipment_assign();
                                        
                                        for ($i = 0; $i < count($equipment_id); $i++) {
                                            $tmp = $equipment_id[$i];
                                            // Get equipment detail
                                            $eq = $equipment_model->detail($tmp);
                                            
                                            // Just update stored_in location
                                            if (($assign_to_new == NULL) || ($assign_to_new == $eq->assign_to)) {
                                                if (($stored_in_new != NULL) && ($stored_in_new != $eq->stored_in)) {
                                                    $eq->stored_in = $stored_in_new;
                                                    
                                                    $equipment_model->update($eq);
                                                }
                                            }
                                            // In case re-assign to another staff
                                            else {
                                                // Disable above equipment until it is accepted by new assignee
                                                $stored_in_old = $eq->stored_in;
                                                //if ($stored_in_new != NULL) {
                                                //    $eq->stored_in = $stored_in_new;
                                                //}
                                                $eq->enable = BIT_FALSE;
                                                
                                                if ($equipment_model->update($eq)) {

                                                    // Add new assign item to the database
                                                    $item = new equipment_assign_entity();
                                                    $item->equipment_id = $tmp;
                                                    $item->stored_in_old = $stored_in_old;
                                                    $item->assign_to_old = $eq->assign_to;
                                                    if ($stored_in_new != NULL) {
                                                        $item->stored_in_new = $stored_in_new;
                                                    } else {
                                                        $item->stored_in_new = $eq->stored_in;
                                                    }
                                                    $item->assign_to_new = $assign_to_new;
                                                    $item->assign_by = current_account();
                                                    
                                                    if (!$assign_model->insert($item)) {
                                                        $eq->enable = BIT_TRUE;
                                                        $equipment_model->update($eq);
                                                        
                                                        //debug($assign_model->getMessage());
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                ?>
                            <div id="dt_example">
                                    <div id="container">
                                        <div id="demo">
                                            <table cellpadding="0" cellspacing="0" border="0" class="display" id="example">
                                                <thead>
                                                    <tr>
                                                        <?php if (verify_access_right(current_account(), F_EQUIPMENT_SWAP)): ?>
                                                            <th><input class="check-all" type="checkbox"></th>
                                                        <?php endif; ?>
                                                        <th>Mã dụng cụ</th>
                                                        <th>Tên dụng cụ</th>
                                                        <th>Tình trạng</th>
                                                        <th>Nơi để</th>
                                                        <th>Người chịu trách nhiệm</th>
                                                        <th>Ngày giao</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                            <?php if (verify_access_right(current_account(), F_EQUIPMENT_SWAP)): ?>
                                                <div style="margin: 30px;"></div>
                                                <div id="reassign-panel" class="bulk-actions align-left">
                                                    <input type="hidden" name="from" value="<?php echo $makho ?>" />
                                                    <select name="stored_in_new" id="stored_in_new">
                                                        <option value="">- Nơi để -</option>
                                                        <?php
                                                        $khohang = new khohang();
                                                        $arr = $khohang->danh_sach();
                                                        if(is_array($arr)):
                                                            foreach ($arr as $item):
                                                                echo "<option value=\"{$item['makho']}\">{$item['tenkho']}</option>";
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                    <select name="assign_to_new" id="assign_to_new">
                                                        <option value="">- Người chịu trách nhiệm -</option>
                                                        <?php
                                                        $nhanvien = new nhanvien();
                                                        $arr = $nhanvien->employee_list();
                                                        if(is_array($arr)):
                                                            foreach ($arr as $item):
                                                                echo "<option value=\"{$item['manv']}\">{$item['hoten']}</option>";
                                                            endforeach;
                                                        endif;
                                                        ?>
                                                    </select>
                                                    <input type="submit" name="submit" value="Chuyển dụng cụ" class="button" />
                                                    <span id="error" style="padding-left: 20px" class="require"></span>
                                                </div>
                                                <br /><br />
                                            <?php endif; ?>
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