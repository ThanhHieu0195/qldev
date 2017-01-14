<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_EQUIPMENT, '', TRUE);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Dụng cụ mới nhận</title>
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
        
        <script type="text/javascript" src="../resources/scripts/utility/equipment/re-assign-list.js"></script>
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
                    "sAjaxSource": "../ajaxserver/equipment_reassign_list_server.php",
                    "fnRowCallback": function( nRow, aData, iDisplayIndex ) {
                        $('td:eq(0)', nRow).html(String.format("<input type='checkbox' id='reassign_{0}' name='reassign_uid[]' value='{1}'>", iDisplayIndex, aData[0]));
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
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Danh sách dụng cụ mới bàn giao cho bạn</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="re-assign-list" action="" method="post">
                                <?php
                                require_once '../models/equipment.php';
                                require_once '../models/equipment_assign.php';
                                
                                // Accept
                                if(isset($_POST['accept'])) {
                                    $reassign_uid = $_POST['reassign_uid'];
                                    //debug($equipment_id);
                                    
                                    if (is_array($reassign_uid)) {
                                        $equipment_model = new equipment();
                                        $assign_model = new equipment_assign();
                                        
                                        for ($i = 0; $i < count($reassign_uid); $i++) {
                                            $uid = $reassign_uid[$i];
                                            
                                            // Get re-assign detail
                                            $item = $assign_model->detail($uid);
                                            if ($item != NULL) {
                                                // Get equipment detail
                                                $eq = $equipment_model->detail($item->equipment_id);
                                                if ($eq != NULL) {
                                                    // Update equipment detail
                                                    $eq->assign_to = $item->assign_to_new;
                                                    $eq->stored_in = $item->stored_in_new;
                                                    $eq->assign_date = $item->assign_date;
                                                    $eq->enable = BIT_TRUE;
                                                    if ($equipment_model->update($eq)) {
                                                        // Update assign detail
                                                        $item->status = EQUIPMENT_ACCEPTED;
                                                        
                                                        $assign_model->update($item);
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                                
                                // Cancel
                                if(isset($_POST['cancel'])) {
                                    $reassign_uid = $_POST['reassign_uid'];
                                    //debug($equipment_id);
                                
                                    if (is_array($reassign_uid)) {
                                        $equipment_model = new equipment();
                                        $assign_model = new equipment_assign();
                                
                                        for ($i = 0; $i < count($reassign_uid); $i++) {
                                            $uid = $reassign_uid[$i];
                                
                                            // Get re-assign detail
                                            $item = $assign_model->detail($uid);
                                            if ($item != NULL) {
                                                // Get equipment detail
                                                $eq = $equipment_model->detail($item->equipment_id);
                                                if ($eq != NULL) {
                                                    // Update equipment detail
                                                    $eq->enable = BIT_TRUE;
                                                    if ($equipment_model->update($eq)) {
                                                        // Update assign detail
                                                        $item->status = EQUIPMENT_CANCELLED;
                                
                                                        $assign_model->update($item);
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
                                                        <th><input class="check-all" type="checkbox"></th>
                                                        <th>Mã dụng cụ</th>
                                                        <th>Tên dụng cụ</th>
                                                        <th>Tình trạng</th>
                                                        <th>Nơi để</th>
                                                        <th>Người giao</th>
                                                        <th>Ngày giao</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                            </table>
                                            <div style="margin: 30px;"></div>
                                            <div id="reassign-panel" class="bulk-actions align-left">
                                                <input type="submit" name="accept" value="Nhận dụng cụ" class="button" />
                                                <input type="submit" name="cancel" value="Huỷ bỏ" class="button" />
                                                <span id="error" style="padding-left: 20px" class="require"></span>
                                            </div>
                                            <br /><br />
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