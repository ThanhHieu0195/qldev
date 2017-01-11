<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_MANAGER_KPI, F_KPI_DELIVER, TRUE);
require_once "../ajaxserver/kpi_deliver_server.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>KPI nhân viên giao hàng</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
            .none{
                display: none;
            }
            .rowdate {
                font-weight: bold;
                font-style: italic;
                color: #FFA800;
            }
            #detail {
                background-color: #FFFFFF;
                width: 20%;
                height: auto;
                padding: 20px;
            }
            #tdetail th{
                font-weight: bold;
                font-size: 12pt;
            }
            #tdetail tr:nth-child(even) {background: #CCC}
            #tdetail tr:nth-child(odd) {background: #FFF}
        </style>
         <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <!-- hổ trợ chọn ngày tháng -->
        <script type="text/javascript" src="../resources/scripts/utility/orderdelivered.js"></script>
        <script type="text/javascript" language="javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>

        <link rel="stylesheet" type="text/css" href="../resources/loading/jquery.loading.css" />
        <script type="text/javascript" src="../resources/loading/jquery.loading.js"></script>
        <script type="text/javascript">
            function n2s(x) {
                return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            }
            $(document).ready(function() {
                loading();
                json = <?php echo json_encode($output) ?>;
                //console.log(json);
                if (json['result'] == "success") {
                    if (json['action'] == "statistics_sum") {
                       
                        var from = $('#tungay').val();
                        var to = $('#denngay').val();
                        $('#tsum > tbody').html("");
                        dataStatistics = json.dataStatistics;
                        var html = "";
                        var query = String.format("&tungay={0}&denngay={1}", from, to);
                        var fm = "<tr> <td><a href='../employees/employeedetail.php?item={0}' target='_blank'>{0}</a></td> <td>{1}</td> <td><a href='?employee_id={0}{3}' target='BLANK'>{2}</a></td><td>{4}</td></tr>";
                        for (var i = 0; i < dataStatistics.length; i++) {
                            var obj = dataStatistics[i];
                            if (parseInt(obj.SUM_ORDER)>0) {
                                per = (parseInt(obj.SUM_DELIVER)/parseInt(obj.SUM_ORDER)*100).toFixed(1);
                            } else {
                                per = '----';
                            }
                            html += String.format(fm, obj.MANV, n2s(obj.SUM_DELIVER), n2s(obj.SUM_ORDER), query, per);
                        }
                        $('#tsum > tbody').html(html);
                        $('#tsum').show();
                    }
                    // chức năng thống kê
                    if (json['action'] == "statistics") {
                        //console.log(json.dataStatistics);
                        $('#example > tbody').html("");

                        dataStatistics = json.dataStatistics;

                        var html = "";

                        for (var j = 0; j < dataStatistics.length; j++) {
                            var obj = dataStatistics[j];
                            var row = "";
                            if (obj.loai=='donhang') { 
                                row += String.format("<td><a href='../orders/orderdetail.php?item={0}' target='blank'>{1}</a></td>", obj.madon, obj.madon);
                            } else {
                                row += String.format("<td><a href='../orders/vouchers.php?item={0}' target='blank'>{1}</a></td>", obj.madon, obj.madon);
                            }
                            if (parseInt(obj.thanhtien)>0) {
                                per = (parseInt(obj.tiengiaohang)/parseInt(obj.thanhtien)*100).toFixed(1);      
                            } else {
                                per = '----';
                            }
                            row += String.format("<td>{0}</td>", obj.nhanvien);
                            row += String.format("<td>{0}</td>", obj.ngaygiao);
                            row += String.format("<td>{0}</td>", n2s(obj.tiengiaohang));
                            row += String.format("<td>{0}</td>", n2s(obj.thanhtien));
                            row += String.format("<td>{0}</td>", per);
                            row += String.format("<td>{0}</td>", obj.diachi + ' ' + obj.quan + ' ' + obj.tp);
                            html+= String.format("<tr>{0}</tr>", row);
                        }
                        console.log(html);

                        $('#example > tbody').html(html);
                        $('#example').DataTable({
                            "bSort": false 
                        }); 
                        $('#example').show();
                    }
                   
                }


                $('#function > input').click(function(event) {
                    var tungay = $('#tungay').val();
                    var denngay = $('#denngay').val();

                    $('#error-1').html("");
                    $('#error-2').html("");

                    if (tungay=="" || denngay=="") {
                        if (tungay === "") {
                            $('#error-1').html("*chọn ngày");
                        }
                        if (denngay == "") {
                            $('#error-2').html("*chọn ngày");
                        }
                        return false;
                    }
                });
                loaded();
            });

            function detailInfo(date) {
                html = "";
                fm = "<tr> <td>{0}</td> <td>{1}</td> </tr>";
                for (var i = 0; i < dataStatistics.length; i++) {
                    var obj = dataStatistics[i];
                    if (obj.DATE == date) {
                        if (obj.TYPE == 'order') {
                            html+=String.format(fm, String.format('<a href="../orders/orderdetail.php?item={0}" target="_BLANK">{0}</a>', obj.ORDER_ID), obj.MONEY)
                        } else {
                            html+=String.format(fm, String.format('<a href="../orders/vouchers.php?item={0}" target="_BLANK">{0}</a>', obj.ORDER_ID), obj.MONEY)
                        }
                    }
                }
                $('#tdetail > tbody').html(html);
                $('#detail').bPopup();
            }

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
                <div class="content-box column-left" style="width:100%">
                    <div class="content-box-header">
                        <h3>KPI nhân viên giao hàng</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="excel-export" action="" method="POST">
                                <div>
                                    <label>Từ ngày (yyyy-mm-dd):</label>
                                    <input id="tungay" name="tungay"
                                           class="text-input small-input" style="width: 150px !important"
                                           value="<?php echo (isset($_REQUEST['tungay'])) ? $_REQUEST['tungay'] : '' ?>" 
                                           type="text" readonly="readonly" />
                                    <span id="error-1" style="color: red"></span> 
                                    <div style="height: 10px"></div>
                                </div>
                                <div>
                                    <label>Đến ngày (yyyy-mm-dd):</label>
                                    <input id="denngay" name="denngay"
                                           class="text-input small-input" style="width: 150px !important" 
                                           value="<?php echo (isset($_REQUEST['denngay'])) ? $_REQUEST['denngay'] : '' ?>"
                                           type="text" readonly="readonly" />
                                    <span id="error-2" style="color: red"></span> 
                                    <div style="height: 10px"></div>
                                </div>
                                <div id="function">
                                    <input class="button" type="submit" id="statistics" name="statistics" value="Xem thống kê">
                                    <input class="button" type="submit" id="sum" name="statistics_sum" value="Tổng kết">
                                </div>
                            </form>
                            <div id="dt_example">
                                <div id="container">
                                    <div id="demo">
                                        <table cellpadding="0" cellspacing="0" border="0" id="example" class="none">
                                            <thead>
                                                <tr>
                                                    <th>Mã đơn</th>
                                                    <th>Nhân viên</th>
                                                    <th>Ngày giao</th>
                                                    <th>Tiền giao hàng</th>
                                                    <th>Giá trị đơn hàng</th>
                                                    <th>% đơn hàng</th>
                                                    <th>Địa chỉ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>

                                        <div style="padding-bottom: 10px;"></div>

                                        <table cellpadding="0" cellspacing="0" border="0" id="tsum" class="none">
                                            <thead>
                                                <tr>
                                                    <th>Nhân viên</th>
                                                    <th>Tiền giao hàng</th>
                                                    <th>Tổng tiền giao hàng</th>
                                                    <th>%</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                        </table>

                                    </div>
                                </div>
                            </div>

                            <form id="detail"  class="none">
                                <table id="tdetail">
                                     <thead>
                                        <tr>
                                            <th>Mã đơn</th>
                                            <th>Số tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </form>

                             <div class="loading none" id="loading">
                                <img src="../resources/images/loadig_big.gif"/>
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
