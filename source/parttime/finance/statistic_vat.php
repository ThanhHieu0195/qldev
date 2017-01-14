<?php
require_once '../part/common_start_page.php';

// Authenticate
do_authenticate(G_FINANCE, F_STATISTIC_VAT, TRUE);
require_once "../models/hoadondo.php";
$model = new RedBill();
$data_statistic = $model->statisticVAT();
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Thông tin thu/chi của từng tài khoản</title>
        <?php require_once '../part/cssjs.php'; ?>
        
        <style type="text/css" title="currentStyle">
            @import "../resources/datatable/css/demo_page.css";
            @import "../resources/datatable/css/demo_table.css";
            img { vertical-align: middle; }
            .none{
                display: none;
            }
            .lb {
                font-weight: bold;
                padding: 10px 10px 10px 0px;
            }
            .fn {
                padding-top: 10px;
            }
            #loading > img {
                background-color: rgb(255, 255, 255);
            }
        </style>
        <link rel="stylesheet" type="text/css" href="../resources/jquery-tooltip/jquery.tooltip.css" />
    
          <!-- jQuery.bPopup -->
        <script type="text/javascript" src="../resources/jquery.bpopup/jquery.bpopup.min.js"></script>
        <link rel="stylesheet" type="text/css" href="../resources/jquery.bpopup/style.min.css" />
        <script type="text/javascript" src="../resources/datatable/js/jquery.dataTables.js"></script>

        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.bgiframe.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.dimensions.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <script type="text/javascript" src="../resources/jquery-tooltip/jquery.tooltip.js"></script>
        <script type="text/javascript">
        function n2s(x) {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        var data = [];
        $(document).ready(function() {
            loading();
            data = <?php echo json_encode($data_statistic); ?>;
            var THUVAT = "<?php echo THUVAT; ?>";
            for (var i = 0; i < data.length; i++) {
                var obj =data[i];
                var html="";
                var fm = "<tr id='tr{0}''><td>{0}</td><td>{1}</td><td>{2}</td><td>{3}</td><td>{4}</td><td>{5}</td><td>{6}</td><td>{7}</td><td>{8}</td><td>{9}</td></tr>";

                // var kt = parseFloat(obj.money_amount) - (parseFloat(obj.giatri)*0.1+(parseFloat(obj.giatri)-parseFloat(obj.thanhtien))*0.2);
                // console.log((parseFloat(obj.giatri)*0.1+(parseFloat(obj.giatri)-parseFloat(obj.thanhtien))*0.2));

                var htmlt = "";

                // if (kt == 0 && obj.item_id == THUVAT) {
                    htmlt = String.format('<input type="button" id="{0}" name="update" value="duyệt" />', obj.stt);
                // }
                var money_amount = obj.money_amount;

                //if (obj.item_id == null || obj.item_id != THUVAT) {
                //    money_amount = 0;
                //}
                
                html = String.format(fm, obj.stt, '<a href="../orders/orderdetail.php?item=' + changeNull(obj.madon, '#') + '" target="_blank">' + changeNull(obj.madon, "#") + '</a>', changeNull(obj.ngaygiao, '#'), changeNull(obj.mahoadon, '#'), changeNull1(obj.thanhtien, '#'), changeNull1(obj.giatrihoadondo, '#'), changeNull(obj.ngayxuat, '#'), changeNull1(obj.giatri, '#'), '<a href="../finance/token-detail.php?i=' + obj.token_id + '" target="_blank">' + changeNull1(obj.money_amount, '#') + '</a>', htmlt);
                // Tiền VAT đã thu = hoadondo.giatri * 0.1 + (hoadondo.giatri-thanhtien)*0.2
                $('#example > tbody').append(html);
            }
            loaded();

            function findObjById(id) {
                for (var i = 0; i < data.length; i++) {
                    var obj = data[i];
                    if (obj.stt == id) {
                        return obj;
                    }
                }
                return null;
            }

            $("input[name='update']").click(function(event) {
                loading();
                var id = event.currentTarget.id;
                var obj = findObjById(id);
                $.post('../ajaxserver/statisticvat_server.php', {action:1, do:"update", mahoadon: obj.mahoadon}, function(data, textStatus, xhr) {
                    loaded();
                    json = jQuery.parseJSON(data);
                    if (json.result == "success") {
                        id = "#tr"+id;
                        $(id).remove();
                    } 
                });

            });

            $('#example').DataTable();
            
        });
        
        function loading() {
            load = $('#loading').bPopup({
               escClose : false, modalClose : false
             });
        }

        function loaded() {
            load.close();
        }

        function changeNull1(text, change="") {
            if (text == null) {
                return change;
            }
            return n2s(text);
        }

        function changeNull(text, change="") {
            if (text == null) {
                return change;
            }
            return text;
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
                        <h3>Thông Kê VAT</h3>
                    </div>
                    <div class="content-box-content">
                        <div class="tab-content default-tab">
                            <form id="statistic" action="" method="POST">
                                
                            </form>
                        </div>
                        <div class="tab-content default-tab">
                        <!-- STT, Mã đơn hàng, ngày giao, Mã hóa đơn đỏ, Thành tiền, Giá tính VAT, Ngày xuất hóa đơn, Giá trị hóa đơn, Tiền VAT đã thu, Kiểm tra -->
                            <table cellpadding="0" cellspacing="0" border="0" id="example">
                                <thead>
                                    <tr>
                                        <th>STT</th>
                                        <th>Mã đơn hàng</th>
                                        <th>Ngày giao</th>
                                        <th>Mã hóa đơn đỏ</th>
                                        <th>Thành tiền</th>
                                        <th>Giá tính VAT</th>
                                        <th>Ngày xuất </th>
                                        <th>Giá trị hóa đơn đỏ</th>
                                        <th>Tiền VAT đã thu</th>
                                        <th>Kiểm tra</th>
                                    </tr>
                                </thead>
                                <tbody>
                                   
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="loading none" id="loading">
                    <img src="../resources/images/loadig_big.gif"/>
                </div>
                <?php require_once '../part/footer.php'; ?>
            </div>
        </div>
    </body>
</html>
<?php 
require_once '../part/common_end_page.php';
?>
