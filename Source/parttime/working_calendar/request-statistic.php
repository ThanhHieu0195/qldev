<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_WORKING_CALENDAR, F_REQUEST_STATISTIC, TRUE);
require_once "../models/danhsachlamthem.php";
require_once "../models/phanquyen.php";
// cập nhật số ngày nghỉ cho phép trong bảng danhsachsongaynghi

// Lấy thông tin thống kê
$list_request = new list_request();
if (verify_access_right ( current_account (), F_SMS_TEMPLATE )) {
    $manager_id = "admin";
} else {
    $manager_id = current_account();
}

// thông kê phiếu nghĩ theo nhân viên
$listData = $list_request->statistic_employee_id($manager_id);

// thống kê phiếu nghĩ theo nhân viên có chi tiết ngày
$listDetail = $list_request->statistic_employee_id_detail($manager_id);

$pq = new phanquyen();
// danh sách tất cả nhân viên được quản lý
$list_all_employee = $pq->loadEmployee($manager_id);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thống kê số ngày làm thêm của nhân viên</title>
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
            #rform {
                background-color: #FFFFFF;
                padding: 10px;
            }
            .row_date > td {
                color: #FFBA00;
                font-style: italic;
                font-weight: bold;
            }
            #dform {
                padding: 20px;
                background-color: #FFFFFF;
                width: 500px;
            }

            #dform > img {
                float: right;
            }

            #dform > table th, #dform > table td {
                padding: 10px;
                color: #001EFF;
            }
            #dform > table th {
                font-weight: bold;
                background-color: #000000;
                color: #FFFFFF;
            }
            #dform > table tr:nth-child(odd) {
                    background-color:  #969090;
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

         <!-- jQuery.bPopup -->
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />

        <script type="text/javascript">

             listData = <?php echo json_encode($listData); ?>;
             listDetail = <?php echo json_encode($listDetail); ?>;
             list_all_employee = <?php echo json_encode($list_all_employee); ?>;
             
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
                        <h3>Thống kê số ngày làm thêm của nhân viên</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="add_new_request_days" action="../ajaxserver/working_calendar_request_server.php" method="post" target="hidden_upload">
                                <fieldset>
                                    <input type="hidden" name="processrequest" />
                                    <input type="hidden" name="max_num_request" id="max_num_request" />
                                    <table id="tstatistic">
                                        <thead>
                                            <tr>
                                                <th>Mã nhân viên</th>
                                                <th>Số ngày làm thêm</th>
                                                <th><input type="checkbox" id="allchecked" /></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            
                                        </tbody>
                                    </table>
                                </fieldset>


                                <iframe id="hidden_upload" name="hidden_upload" src="" onload="uploadDone('hidden_upload');"
                                        style="width:0;height:0;border:0px solid #fff">
                                </iframe>

                                <div>
                                    <input type="submit" class="button" value="export" name="action" id="btnexport" />
                                    <input type="hidden" name="statistic" />
                                </div>
                            </form>
                            <div class="clear"></div>
                        </div>  

                        <div id="dform" class="none">
                            <img src="../resources/images/icons/cross.png" alt="close"/>
                            <table>
                                <thead>
                                    <tr>
                                        <th>Ngày</th>
                                        <th>Số ngày làm thêm</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <?php include_once '../part/footer.php'; ?>
                 <script type="text/javascript" src="../resources/scripts/utility/working_calendar/request-statistic.js">           
                 </script>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
