<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_WORKING_CALENDAR, F_LIST_APPROVE_LEAVE, TRUE);
require_once "../models/danhsachnghi.php";
$list_leave = new list_leave();
$manager_id = current_account();
$listData = $list_leave->getListByManagerId($manager_id);

if (isset($_GET['nhanvien'])) {
    $filter_employee_id = $_GET['nhanvien'];
} else {
    $filter_employee_id = "";
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Danh sách đơn nghỉ phép cần approve</title>
        <?php require_once '../part/cssjs.php'; ?>
       
        <style type="text/css">
            .name { color: blue; font-weight: bolder; }
            .blue-text { color: blue; font-weight: normal; }
            .blue-violet { color: blueviolet; font-weight: normal; }
            .orange { color: #FF6600; font-weight: normal; }
            .bold { font-weight: bolder; }
            #main-content tbody tr.alt-row { background: none; }
            #upload_message span { font-size: 13px; }
            .none {
                display: none;
            }
        </style>
        
        <link rel="stylesheet" href="../resources/chosen/chosen.css">
         <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
        </style>

        <script src="../resources/chosen/chosen.jquery.js" type="text/javascript"></script>
        <script src="../resources/chosen/docsupport/prism.js" type="text/javascript" charset="utf-8"></script>
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>
        <script type="text/javascript">
            listData = <?php echo json_encode($listData); ?>;
            filter_employee_id = <?php echo json_encode($filter_employee_id); ?>;

            $(document).ready(function() {
                for (var i = 0; i < listData.length; i++) {
                    var obj = listData[i];
                    if (obj.trangthai >= -1 && obj.trangthai <= 1 && (filter_employee_id == "" || obj.manv == filter_employee_id)) {
                        var fm = "<tr id={0}> <td class='manv'><a href='../employees/employeedetail.php?item={1}'>{1}</a></td> <td class='ngaynghi'>{2}</td> <td class='songaynghi'>{3}</td> <td class='lido'>{4}</td>  <td class='trangthai'>{5}</td> </tr>";
                        var status = "approved";
                        if (obj.trangthai == 0) {
                            status = String.format('<input type="button" class="button" value="approve" name="action" onClick="approve(\'{0}\');"> <input type="button" class="button" value="reject" name="action" onClick="reject(\'{0}\');">', obj.id);
                        }

                        if (obj.trangthai == -1) {
                            status = "rejected";
                        }

                        var html = String.format(fm, obj.id, obj.manv, obj.ngaynghi, obj.songaynghi, obj.ghichu, status);
                        $('#tapprove > tbody').append(html);     
                    }
                }

                $('#tapprove').dataTable({
                     "aaSorting": [[4,'asc']],
                });
            });

             function approve(id) {
                $.post('../ajaxserver/working_calendar_server.php', {id: id, processleave:"", action:"approve"}, function(data, textStatus, xhr) {
                    json = jQuery.parseJSON(data);
                    if (json.result == 1) {
                        id = String.format("#{0} > .trangthai", id);
                        $(id).html("approved");
                    }
                });
            }

             function reject(id) {
                $.post('../ajaxserver/working_calendar_server.php', {id: id, processleave:"", action:"reject"}, function(data, textStatus, xhr) {
                    json = jQuery.parseJSON(data);
                    if (json.result == -1) {
                        id = String.format("#{0} > .trangthai", id);
                        $(id).html("rejected");
                    }
                });
            }

             
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
                <div class="clear"></div>
              
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>Danh sách đơn nghỉ phép cần approve</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="add_new_leave_days">
                                <fieldset>
                                    <input type="hidden" name="processleave" />
                                    <table id="tapprove">
                                        <thead>
                                            <tr>
                                                <th>Mã nhân viên</th>
                                                <th>Ngày nghỉ</th>
                                                <th>Số ngày nghỉ</th>
                                                <th>Lí do</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </fieldset>
                            </form>
                            <div class="clear"></div>
                        </div>
                    </div>
                </div>
                <?php include_once '../part/footer.php'; ?>
                 </script>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>