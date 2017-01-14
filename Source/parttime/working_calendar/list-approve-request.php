<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_WORKING_CALENDAR, F_LIST_APPROVE_REQUEST, TRUE);
require_once "../models/danhsachlamthem.php";
$list_request = new list_request();
$id = current_account();
$listData = $list_request->getRequest($id);

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
        <title>Yêu cầu làm thêm chờ xác nhận</title>
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
                        <h3>Yêu cầu làm thêm chờ xác nhận</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="add_new_request_days">
                                <fieldset>
                                    <input type="hidden" name="processrequest" />
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
                <script type="text/javascript" src="../resources/scripts/utility/working_calendar/list-approve-request.js"></script>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>